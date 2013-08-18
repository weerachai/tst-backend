<?php
class TargetSaleReport extends MyReport {

  	public function create($ids, $from_date, $to_date, $format) {
  		$title = 'ยอดขายเทียบเป้า';
		$header = array('หน่วยขาย',
        	'วันที่', 
        	'เป้าทั้งทริป', 
        	'ยอดขายทั้งทริป', 
        	'% เทียบเป้า');
		$w = array(12, 10, 20, 20, 10);
		$align = array('L','L','R','R','R');

		$idlist = implode("','",$ids);
 		$sql = <<<SQL
		SELECT SaleName, OrderDate, TargetAmount, SUM(Total) AS Total
		FROM (ProductOrder JOIN SaleUnit USING(SaleId))
		JOIN TargetSale USING(SaleId)
  		WHERE Level = 'all' AND TargetAmount > 0 
  		AND OrderDate >= '$from_date' AND OrderDate <= '$to_date' 
  		AND SaleId IN ('$idlist')
		GROUP BY SaleName, OrderDate, TargetAmount
		ORDER BY SaleName, OrderDate, TargetAmount
SQL;

		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$data = array();
		foreach ($rawData as $row) {
			$data[] = array(
				$row['SaleName'],
				$row['OrderDate'],
				number_format($row['TargetAmount'],2),
				number_format($row['Total'],2),
				number_format($row['Total']*100/$row['TargetAmount'],2),
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);
		$this->output($objPHPExcel, $format, "TargetSaleReport");
		Yii::app()->end();
  	}
}
?>