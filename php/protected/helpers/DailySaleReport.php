<?php
class DailySaleReport extends MyReport {

  	public function create($ids, $from_date, $to_date, $format) {
  		$title = 'ยอดขายรายวัน';
		$header = array('หน่วยขาย',
        	'วันที่', 
        	'ยอดขาย');
		$w = array(20, 20, 20);
		$align = array('L','L','R');

		$idlist = implode("','",$ids);
 		$sql = <<<SQL
		SELECT SaleName, OrderDate, SUM(Total) AS Total
		FROM ProductOrder JOIN SaleUnit USING(SaleId)
  		WHERE OrderDate >= '$from_date' AND OrderDate <= '$to_date' AND SaleId IN ('$idlist')
		GROUP BY SaleName, OrderDate
		ORDER BY SaleName, OrderDate
SQL;

		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$data = array();
		foreach ($rawData as $row) {
			$data[] = array(
				$row['SaleName'],
				$row['OrderDate'],
				number_format($row['Total'],2)
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);
		$this->output($objPHPExcel, $format, "DailySaleReport");
		Yii::app()->end();
  	}
}
?>