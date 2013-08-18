<?php
class BillCollectionReport extends MyReport {

  	public function create($ids, $from_date, $to_date, $format) {
  		$title = 'ชำระเงิน';
		$header = array('เลขที่ชำระเงิน',
        	'วันที่', 
        	'จำนวนเก็บ', 
        	'จำนวนรับ',
        	'ส่วนต่าง');
		$w = array(13, 20, 10, 10, 10);
		$align = array('L','L','R','R','R');
  		$models = BillCollection::model()->findAll(array(
  			'order'=>'CollectionNo', 
  			'condition'=>"CollectionDate >= :from AND CollectionDate <= :to AND SaleId IN ('".implode("','",$ids)."')",
  			'params'=>array(':from'=>$from_date, ':to'=>$to_date)
  			));
		$data = array();
		foreach ($models as $model) {
			$datetime = new DateTime($model->CollectionDate);
			$data[] = array(
				$model->CollectionNo,
				$this->thaidate->format("j M y",$datetime->getTimestamp()),
				number_format($model->CollectionAmount,2),
				number_format($model->PaidAmount,2),
				number_format($model->CollectionAmount-$model->PaidAmount,2),
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);

		$w = array(13, 15, 15, 15);
		$align = array('L','R','R','R');
		foreach ($models as $i=>$model) {
  			$title = 'รายการชำระ เลขที่: '.$model->CollectionNo;
			$header = array('เลขที่อินวอซย์',
    	    	'จำนวนอินวอยซ์', 
        		'จำนวนชำระ', 
        		'ส่วนต่าง');
			$CollectionNo = $model->CollectionNo;
	 		$sql = <<<SQL
			SELECT I.InvoiceNo, Total, SUM(Amount) AS Paid
			FROM (InvoicePayment JOIN ProductInvoice I USING(InvoiceNo))
			JOIN Payment USING(PaymentId)
	  		WHERE CollectionNo = '$CollectionNo'
			GROUP BY I.InvoiceNo, Total
			ORDER BY I.InvoiceNo, Total
SQL;

			$rawData = Yii::app()->db->createCommand($sql)->queryAll();
			$data = array();
			foreach ($rawData as $row) {			
				$data[] = array(
					$row['InvoiceNo'],
					number_format($row['Total'],2),
					number_format($row['Paid'],2),
					number_format($row['Total']-$row['Paid'],2)
				);
			}
			$data[] = array('','รวมชำระ: ',number_format($model->PaidAmount,2),'');

			$objPHPExcel->createSheet();
			$this->writeSheet($objPHPExcel, $i+1, $title, $model->CollectionNo, $header, $w, $align, $data);
		}
		$this->output($objPHPExcel, $format, "BillCollectionReport");
		Yii::app()->end();
  	}
}
?>