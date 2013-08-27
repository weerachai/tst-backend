<?php
class ExportDb {

	private function col($index) {
		if ($index < 26)
			return chr(ord('A')+$index);
		else {
			$i = $index / 26 - 1;
			$j = $index % 26;
			return chr(ord('A')+$i).chr(ord('A')+$j);
		}
	}

	public function exportText($table, $fieldList, $fileName) {
		$select = implode(',', $fieldList);		
		$cmd = Yii::app()->db->createCommand("SELECT $select FROM $table");	
		Yii::import('ext.ECSVExport.ECSVExport');
		$fileName .= '.txt';
		$csv = new ECSVExport($cmd);
		$csv->toCSV($fileName);
	}

	public function exportExcel($table, $fieldList, $fileName) {
		$select = implode(',', $fieldList);		
		$cmd = Yii::app()->db->createCommand("SELECT $select FROM $table");	
		$fileName .= '.xls'; 
      	Yii::import('ext.phpexcel.XPHPExcel');    
      	$objPHPExcel= XPHPExcel::createPHPExcel();
 		$objPHPExcel->setActiveSheetIndex(0);

		// Add header
		$row = 1;
		foreach ($fieldList as $i=>$field) {
			$objPHPExcel->getActiveSheet()->setCellValue($this->col($i).$row, $field);
		}
		$data = $cmd->queryAll();
		foreach ($data as $rec) {
			$row++;
			foreach ($fieldList as $i=>$field) {
				$objPHPExcel->getActiveSheet()->setCellValue($this->col($i).$row, $rec[$field]);
			}
		}				
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($table);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($fileName);
	}
}
?>