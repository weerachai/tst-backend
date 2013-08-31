<?php
class ProductReturnReport extends MyReport {

  	public function create($ids, $from_date, $to_date, $format) {
  		$title = 'รายการรับคืนสินค้า';
		$header = array('เลขที่ใบคืนสินค้า',
        	'ชื่อร้านค้า', 
        	'วันที่', 
        	'มูลค่า');
		$w = array(13, 20, 10, 10);
 		$align = array('L','L','L','R');
  		$models = ProductReturn::model()->findAll(array(
  			'order'=>'ReturnNo', 
  			'condition'=>"ReturnDate >= :from AND ReturnDate <= :to AND SaleId IN ('".implode("','",$ids)."')",
  			'params'=>array(':from'=>$from_date, ':to'=>$to_date)
   			));
		$data = array();
		foreach ($models as $model) {
			$datetime = new DateTime($model->ReturnDate);
			$data[] = array(
				$model->ReturnNo,
				$model->customer->Title.$model->customer->CustomerName,
				$this->thaidate->format("j M y",$datetime->getTimestamp()),
				number_format($model->Total,2),
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);

		$w = array(13, 20, 10, 10);
		$align = array('L','L','R','R');
		foreach ($models as $i=>$model) {
  			$title = 'รายละเอียดใบสั่งซื้อเลขที่: '.$model->ReturnNo;
			$header = array('รหัสสินค้า',
    	    	'ชื่อสินค้า', 
        		'จำนวน', 
        		'มูลค่า');
  			$products = ReturnDetail::model()->findAll(array(
  				'order'=>'ProductId', 
	  			'condition'=>'ReturnNo = :ReturnNo',
  				'params'=> array(':ReturnNo'=>$model->ReturnNo),
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
			$this->writeSheet($objPHPExcel, $i+1, $title, $model->ReturnNo, $header, $w, $align, $data);
		}
		$this->output($objPHPExcel, $format, "ProductReturnReport");
		Yii::app()->end();
  	}
}
?>