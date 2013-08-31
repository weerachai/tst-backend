<?php
class MoneyTransferReport extends MyReport {

  	public function create($ids, $from_date, $to_date, $format) {
  		$title = 'รายการโอนเงินสด';
		$header = array('หน่วยขาย',
        	'วันที่', 
        	'บัญชี',
        	'จำนวน');
		$w = array(13, 8, 35, 15);
		$align = array('L','L','L','R');
  		$models = MoneyTransfer::model()->findAll(array(
  			'order'=>'SaleId, TransferDate', 
  			'condition'=>"TransferDate >= :from AND TransferDate <= :to AND SaleId IN ('".implode("','",$ids)."')",
  			'params'=>array(':from'=>$from_date, ':to'=>$to_date)
  			));
		$data = array();
		foreach ($models as $model) {
			$datetime = new DateTime($model->TransferDate);
			$data[] = array(
				$model->saleUnit->SaleName,
				$this->thaidate->format("j M y",$datetime->getTimestamp()),
				$model->BankAccount,
				number_format($model->Amount,2),
			);   
		}
		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);

		$this->output($objPHPExcel, $format, "PaymentReport");
		Yii::app()->end();
  	}
}
?>