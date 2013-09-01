<?php
class SyncLogReport extends MyReport {

  	public function create($ids, $from_date, $to_date, $format) {
  		$title = 'รายงานรับส่งข้อมูล';
		$header = array('รหัสอุปกรณ์',
        	'ชื่อหน่วยขาย', 
        	'วันเวลา', 
        	'การดำเนินการ', 
        	'Table', 
        	'Records',
        	'หมายเหตุ');
		$w = array(10, 12, 10, 10, 10, 12, 10);
		$align = array('L','L','L','L','L','R','L');
		$idlist = implode("','",$ids);
 		$sql = <<<SQL
		SELECT DeviceId, SaleName, LogTime, Action, TableName, NumRecords, Remark
		FROM (SyncLog JOIN SaleUnit USING(SaleId))
		JOIN Device USING(SaleId)
  		WHERE DATE(LogTime) >= '$from_date' AND DATE(LogTime) <= '$to_date' 
  		AND SaleId IN ('$idlist')
		ORDER BY SaleName, LogTime, id
SQL;

		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$data = array();
		foreach ($rawData as $row) {
			$data[] = array(
				$row['DeviceId'],
				$row['SaleName'],
				$row['LogTime'],
				$row['Action'],
				$row['TableName'],
				$row['NumRecords']>0?number_format($row['NumRecords']):'',
				$row['Remark'],
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);
		$this->output($objPHPExcel, $format, "SyncLogReport");
		Yii::app()->end();
  	}
}
?>