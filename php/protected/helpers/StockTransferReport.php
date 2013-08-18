<?php
class StockTransferReport extends MyReport {

  	public function create($ids, $from_date, $to_date, $format) {
  		$title = 'รายการโอนสินค้าสินทริป';
		$header = array('เลขที่ใบโอน',
        	'หน่วยขาย', 
        	'วันที่', 
        	'มูลค่า');
		$w = array(13, 15, 10, 10);
		$align = array('L','L','L','R');
  		$models = StockTransfer::model()->findAll(array(
  			'order'=>'TransferDate', 
  			'condition'=>"EndTripFlag = 'Y' AND TransferDate >= :from AND TransferDate <= :to AND SaleId IN ('".implode("','",$ids)."')",
  			'params'=>array(':from'=>$from_date, ':to'=>$to_date)
  			));
		$data = array();
		foreach ($models as $model) {
			$datetime = new DateTime($model->TransferDate);
			$data[] = array(
				$model->TransferNo,
				$model->saleUnit->SaleName,
				$this->thaidate->format("j M y",$datetime->getTimestamp()),
				number_format($model->Total,2),
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);

		$w = array(13, 25, 20, 15);
		$align = array('L','L','R','R');
		foreach ($models as $i=>$model) {
  			$title = 'รายละเอียดใบโอนเลขที่: '.$model->TransferNo;
			$header = array('รหัสสินค้า',
    	    	'ชื่อสินค้า', 
        		'จำนวน', 
        		'มูลค่า');
  			$products = TransferDetail::model()->findAll(array(
  				'order'=>'ProductId', 
	  			'condition'=>'TransferNo = :TransferNo',
  				'params'=> array(':TransferNo'=>$model->TransferNo),
  				));
			$data = array();
			foreach ($products as $product) {			
				$data[] = array(
					$product->ProductId,
					$product->product->ProductName,
					$this->formatQty(
						array(
							$product->QtyLevel1,
							$product->QtyLevel2,
							$product->QtyLevel3,
							$product->QtyLevel4,
						),
						array(
							$product->product->PackLevel1,
							$product->product->PackLevel2,
							$product->product->PackLevel3,
							$product->product->PackLevel4,
						)
					),
					number_format($this->getCost(
						array(
							$product->QtyLevel1,
							$product->QtyLevel2,
							$product->QtyLevel3,
							$product->QtyLevel4,
						),
						array(
							$product->PriceLevel1,
							$product->PriceLevel2,
							$product->PriceLevel3,
							$product->PriceLevel4,
						)
					),2),
				);   
			}
			$data[] = array('','','มูลค่ารวม: ',number_format($model->Total,2));

			$objPHPExcel->createSheet();
			$this->writeSheet($objPHPExcel, $i+1, $title, $model->TransferNo, $header, $w, $align, $data);
		}
		
		$this->output($objPHPExcel, $format, "StockTransferReport");
		Yii::app()->end();
  	}
}
?>