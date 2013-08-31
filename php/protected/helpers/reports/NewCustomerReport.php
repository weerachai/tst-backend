<?php
class NewCustomerReport extends MyReport {

  	public function create($ids, $format) {
  		$title = 'รายชื่อร้านค้าใหม่';
		$header = array('รหัสร้านค้า',
        	'ชื่อร้านค้า', 
        	'ตำบล', 
        	'อำเภอ', 
        	'จังหวัด', 
        	'หน่วยขาย');
		$w = array(13, 20, 10, 10, 10, 12);
		$align = array('L','L','L','L','L','L');
  		$models = Customer::model()->findAll(array(
  			'order'=>'Title, CustomerName', 
  			'condition'=>"NewFlag = 'Y' AND SaleId IN ('".implode("','",$ids)."')",
  			));
		$data = array();
		foreach ($models as $model) {
			$data[] = array(
				$model->CustomerId,
				$model->Title.$model->CustomerName,
				$model->SubDistrict,
				$model->District,
				$model->Province,
				$model->saleUnit->SaleName,
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);
		$this->output($objPHPExcel, $format, "NewCustomerReport");
		Yii::app()->end();
  	}
}
?>