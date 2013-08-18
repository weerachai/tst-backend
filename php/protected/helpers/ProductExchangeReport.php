<?php
class ProductExchangeReport extends MyReport {

  	public function create($ids, $from_date, $to_date, $format) {
  		$title = 'รายการเปลี่ยนสินค้า';
		$header = array('เลขที่ใบเปลี่ยนสินค้า',
        	'ชื่อร้านค้า', 
        	'วันที่', 
        	'มูลค่ารับมา',
        	'มูลค่าให้ไป',
        	'ส่วนต่าง');
		$w = array(14, 20, 10, 10, 10, 10);
 		$align = array('L','L','L','R','R','R');
  		$models = ProductExchange::model()->findAll(array(
  			'order'=>'ExchangeNo', 
  			'condition'=>"ExchangeDate >= :from AND ExchangeDate <= :to AND SaleId IN ('".implode("','",$ids)."')",
  			'params'=>array(':from'=>$from_date, ':to'=>$to_date)
   			));
		$data = array();
		foreach ($models as $model) {
			$datetime = new DateTime($model->ExchangeDate);
			$data[] = array(
				$model->ExchangeNo,
				$model->customer->Title.$model->customer->CustomerName,
				$this->thaidate->format("j M y",$datetime->getTimestamp()),
				number_format($model->InTotal,2),
				number_format($model->OutTotal,2),
				number_format($model->InTotal-$model->OutTotal,2),
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);

		$w = array(13, 20, 20, 15);
		$align = array('L','L','R','R');
		foreach ($models as $i=>$model) {
  			$title = 'รายละเอียดใบเปลี่ยนสินค้าเลขที่: '.$model->ExchangeNo;
			$header = array('รหัสสินค้า',
    	    	'ชื่อสินค้า', 
        		'จำนวน', 
        		'มูลค่า');
  			$products = ExchangeInDetail::model()->findAll(array(
  				'order'=>'ProductId', 
	  			'condition'=>'ExchangeNo = :ExchangeNo',
  				'params'=> array(':ExchangeNo'=>$model->ExchangeNo),
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
			$data[] = array('','','มูลค่ารวม: ',number_format($model->InTotal,2));

			$count = count($data)+4;
  			$products = ExchangeOutDetail::model()->findAll(array(
  				'order'=>'ProductId', 
	  			'condition'=>'ExchangeNo = :ExchangeNo',
  				'params'=> array(':ExchangeNo'=>$model->ExchangeNo),
  				));
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
			$data[] = array('','','มูลค่ารวม: ',number_format($model->OutTotal,2));
			$data[] = array('','','ส่วนต่าง: ',number_format($model->InTotal-$model->OutTotal,2));

			$objPHPExcel->createSheet();
			$this->writeSheet($objPHPExcel, $i+1, $title, $model->ExchangeNo, $header, $w, $align, $data);
			$this->addSection($objPHPExcel, 3, count($header), "สินค้ารับมา");
			$this->addSection($objPHPExcel, $count, count($header), "สินค้าให้ไป");
		}
		
		$this->output($objPHPExcel, $format, "ExchangeProductReport");
		Yii::app()->end();
  	}
}
?>