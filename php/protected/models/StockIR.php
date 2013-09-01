<?php

Yii::import('application.models._base.BaseStockIR');

class StockIR extends BaseStockIR
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'requestIRs' => array(self::HAS_MANY, 'RequestIR', 'IRNo'),
			'IRDetails' => array(self::HAS_MANY, 'IRDetail', 'IRNo'),
		);
	}

	public function updateTotal() {
		$total = 0;
		foreach ($this->IRDetails as $detail) {
			$total += $detail->QtyLevel1 * $detail->PriceLevel1;
			$total += $detail->QtyLevel2 * $detail->PriceLevel2;
			$total += $detail->QtyLevel3 * $detail->PriceLevel3;
			$total += $detail->QtyLevel4 * $detail->PriceLevel4;
		}
		$this->Total = $total;
	}

	public static function canAddDeliver($requestNo) {
		$model = RequestIR::model()->find("RequestNo='$requestNo'");
		if (empty($model->stockIR->UpdateAt)) // not comfirm IR
			return false;
		if ($model->stockRequest->deliver) // already create StockDeliver
			return false;
		foreach ($model->stockIR->requestIRs as $request)
			if ($request->stockRequest->deliver 
				&& $request->stockRequest->deliver->Status == 'อยู่ระหว่างบันทึก')
				return false;
		return true;
	}

	public function getAvailableQty($productId) {
		$id = $this->IRNo;
		$model = IRDetail::model()->findByPk(array('IRNo'=>$id,'ProductId'=>$productId));
		$qtys = array($model->QtyLevel1,$model->QtyLevel2,$model->QtyLevel3,$model->QtyLevel4);
		$sql = <<<SQL
			SELECT 
			SUM(T.QtyLevel1) AS Qty1, 
			SUM(T.QtyLevel2) AS Qty2, 
			SUM(T.QtyLevel3) AS Qty3, 
			SUM(T.QtyLevel4) AS Qty4
			FROM (DeliverDetail T JOIN Product USING(ProductId))
			JOIN StockDeliver USING(DeliverNo)
			WHERE ProductId = '$productId' AND RequestNo IN 
			(SELECT RequestNo FROM RequestIR WHERE IRNo = '$id')
SQL;
		$data = Yii::app()->db->createCommand($sql)->queryAll();

		if ($data) {
			$qtys[0] -= $data[0]['Qty1'];
			$qtys[1] -= $data[0]['Qty2'];
			$qtys[2] -= $data[0]['Qty3'];
			$qtys[3] -= $data[0]['Qty4'];
		}
		return $qtys;
	}

	public static function getMaxQty($productId, $deliverNo, $reqQty, $level) {
		$deliver = StockDeliver::model()->findByPk($deliverNo);
		$id = $deliver->request->requestIR->IRNo;
		$model = IRDetail::model()->findByPk(array('IRNo'=>$id,'ProductId'=>$productId));
		$qtys = array($model->QtyLevel1,$model->QtyLevel2,$model->QtyLevel3,$model->QtyLevel4);
		$sql = <<<SQL
			SELECT 
			SUM(T.QtyLevel1) AS Qty1, 
			SUM(T.QtyLevel2) AS Qty2, 
			SUM(T.QtyLevel3) AS Qty3, 
			SUM(T.QtyLevel4) AS Qty4
			FROM (DeliverDetail T JOIN Product USING(ProductId))
			JOIN StockDeliver USING(DeliverNo)
			WHERE ProductId = '$productId' AND RequestNo IN 
			(SELECT RequestNo FROM RequestIR WHERE IRNo = '$id')
			AND DeliverNo != '$deliverNo'
SQL;
		$data = Yii::app()->db->createCommand($sql)->queryAll();

		if ($data) {
			$qtys[0] -= $data[0]['Qty1'];
			$qtys[1] -= $data[0]['Qty2'];
			$qtys[2] -= $data[0]['Qty3'];
			$qtys[3] -= $data[0]['Qty4'];
		}
		return min($reqQty,$qtys[$level-1]);
	}

	public function auto() {
		$id = $this->IRNo;
		$sql = <<<SQL
			SELECT T.ProductId,
			SUM(T.QtyLevel1) AS ReqQty1, 
			SUM(T.QtyLevel2) AS ReqQty2,
			SUM(T.QtyLevel3) AS ReqQty3,
			SUM(T.QtyLevel4) AS ReqQty4,
			D.QtyLevel1 AS Qty1, D.QtyLevel2 AS Qty2,
			D.QtyLevel3 AS Qty3, D.QtyLevel4 AS Qty4		
			FROM (RequestDetail T JOIN Product USING(ProductId))
			JOIN IRDetail D USING(ProductId)
			WHERE IRNo = '$id' AND RequestNo IN 
			(SELECT RequestNo FROM RequestIR WHERE IRNo = '$id')
			GROUP BY ProductId, PackLevel1, PackLevel2,
			PackLevel3, PackLevel4, Qty1, Qty2, Qty3, Qty4
			ORDER BY ProductName
SQL;
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$auto = true;
		foreach ($rawData as $row) {
			for ($i = 1; $i <= 4; $i++)
				if ($row["ReqQty$i"] != $row["Qty$i"]) {
					$auto = false;
					break;
				}
			if (!$auto)
				break;
		}
		if ($auto) {
			$t = date("Y-m-d H:i:s");
			foreach ($this->requestIRs as $model) {
				$request = $model->stockRequest;
				$deliver = new StockDeliver;
				$deliver->SaleId = $request->SaleId;
				$deliver->RequestNo = $request->RequestNo;
				$deliver->DeliverDate = date("Y-m-d");
				$deliver->DeliverNo = ControlNo::model()->getControlNo($deliver->SaleId,'ใบส่งสินค้า');
				$deliver->Total = $request->Total;
				$deliver->Status = 'ยืนยัน';
				$deliver->UpdateAt = $t;
				if ($deliver->save()) {
					ControlNo::model()->updateControlNo($deliver->SaleId,'ใบส่งสินค้า');
					foreach ($request->requestDetails as $detail) {
						$rec = new DeliverDetail;
						$rec->DeliverNo = $deliver->DeliverNo;
						$rec->ProductId = $detail->ProductId;
						$rec->QtyLevel1 = $detail->QtyLevel1;
						$rec->QtyLevel2 = $detail->QtyLevel2;
						$rec->QtyLevel3 = $detail->QtyLevel3;
						$rec->QtyLevel4 = $detail->QtyLevel4;
						$rec->PriceLevel1 = $detail->PriceLevel1;
						$rec->PriceLevel2 = $detail->PriceLevel2;
						$rec->PriceLevel3 = $detail->PriceLevel3;
						$rec->PriceLevel4 = $detail->PriceLevel4;
						$rec->UpdateAt = $t;
						$rec->save();
					}
				}
			}
		}
	}
}