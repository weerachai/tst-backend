<?php

class ExportController extends GxController
{
	private function col($index) {
		if ($index < 26)
			return chr(ord('A')+$index);
		else {
			$i = $index / 26 - 1;
			$j = $index % 26;
			return chr(ord('A')+$i).chr(ord('A')+$j);
		}
	}
	public function actionIndex()
	{

		if (isset($_POST['Table'])) {
			$table = $_POST['Table'];
			$folder = $_POST['Folder'];
			$fileName = $_POST['FileName'];
			$fileType = $_POST['FileType'];
			$fieldList = $_POST['FieldList'];

			$fileName = Yii::app()->basePath.DIRECTORY_SEPARATOR.			
					'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.
					DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$fileName;
			$select = implode(',', $fieldList);		
			$cmd = Yii::app()->db->createCommand("SELECT $select FROM $table");	
			if ($fileType == 'Text') {
				Yii::import('ext.ECSVExport.ECSVExport');
				$fileName .= '.txt';
				$csv = new ECSVExport($cmd);
				$csv->toCSV($fileName); // returns string by default
				echo file_get_contents($fileName);
			} else {
				Yii::import('ext.phpexcel.XPHPExcel');   
				$fileName .= '.xls'; 
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
			$this->redirect(array('/media','p'=>$folder));
		}

		$tableList = array(
			"Customer" => "Customer",
			"Product" => "Product",
			);

		$dir = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files';
		$files = scandir($dir);
		$folderList = array();
		foreach ($files as $file) {
			if ($file != '.' && $file != '..')
				$folderList[$file] = $file;
		}
		$fieldList = array();
		foreach (Yii::app()->db->schema->getTable('Customer')->columns as $column) {
			$fieldList[$column->name] = $column->name;
		}
		$this->render('index', array(
    		'tableList' => $tableList,
    		'folderList' => $folderList,
    		'defaultFileName' => 'Customer-'.date("YmdHis"),
    		'fieldList' => $fieldList
		));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}