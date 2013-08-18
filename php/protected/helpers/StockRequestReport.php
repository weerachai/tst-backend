<?php
class StockRequestReport extends MyReport {

  	public function create($ids, $from_date, $to_date, $format) {
  		$title = 'รายการเบิกสินค้า';
		$header = array('เลขที่ใบเบิก',
        	'วันที่เบิก', 
        	'มูลค่าเบิก',
        	'เลขที่ใบส่ง', 
        	'วันที่ส่ง',
        	'มูลค่าส่ง');
		$w = array(14, 10, 10, 14, 10, 10);
 		$align = array('L','L','R','L','L','R');
  		$models = StockRequest::model()->findAll(array(
  			'order'=>'RequestNo', 
  			'condition'=>"RequestDate >= :from AND RequestDate <= :to AND SaleId IN ('".implode("','",$ids)."')",
  			'params'=>array(':from'=>$from_date, ':to'=>$to_date)
   			));
		$data = array();
		foreach ($models as $model) {
			$datetime1 = new DateTime($model->RequestDate);
			if ($model->deliver) {
				$datetime2 = new DateTime($model->deliver->DeliverDate);
				$date2 = $this->thaidate->format("j M y",$datetime2->getTimestamp());
			} else
				$date2 = '';
			$data[] = array(
				$model->RequestNo,
				$this->thaidate->format("j M y",$datetime1->getTimestamp()),
				number_format($model->Total,2),
				$model->deliver? $model->deliver->DeliverNo : '',
				$date2,
				$model->deliver? number_format($model->deliver->Total,2) : '',
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);

		$w = array(13, 20, 20, 15);
		$align = array('L','L','R','R');
		$i = 0;
		foreach ($models as $model) {
			$i++;
  			$title = 'รายละเอียดใบเบิกสินค้าเลขที่: '.$model->RequestNo;
			$header = array('รหัสสินค้า',
    	    	'ชื่อสินค้า', 
        		'จำนวน', 
        		'มูลค่า');
  			$products = RequestDetail::model()->findAll(array(
  				'order'=>'ProductId', 
	  			'condition'=>'RequestNo = :RequestNo',
  				'params'=> array(':RequestNo'=>$model->RequestNo),
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
			$this->writeSheet($objPHPExcel, $i, $title, $model->RequestNo, $header, $w, $align, $data);

			if ($model->deliver) {
				$i++;
	  			$title = 'รายละเอียดใบส่งสินค้าเลขที่: '.$model->deliver->DeliverNo;
	  			$products = DeliverDetail::model()->findAll(array(
	  				'order'=>'ProductId', 
		  			'condition'=>'DeliverNo = :DeliverNo',
	  				'params'=> array(':DeliverNo'=>$model->deliver->DeliverNo),
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
				$data[] = array('','','มูลค่ารวม: ',number_format($model->deliver->Total,2));

				$objPHPExcel->createSheet();
				$this->writeSheet($objPHPExcel, $i, $title, $model->deliver->DeliverNo, $header, $w, $align, $data);
			}
		}
		
		$this->output($objPHPExcel, $format, "StockRequestReport");
		Yii::app()->end();
  	}
}
?>