<?php

class ImportController extends GxController
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
	private function endsWith($haystack, $needle)
	{
	    $length = strlen($needle);
	    if ($length == 0) {
	        return true;
	    }
	    return (substr($haystack, -$length) === $needle);
	}
	public function actionIndex()
	{

		if (isset($_POST['Table'])) {
			$table = $_POST['Table'];
			$folder = $_POST['Folder'];
			$fileName = $_POST['FileName'];
			$fileType = $_POST['FileType'];
			if (isset($_POST['FieldList'])) {
				$fieldList = $_POST['FieldList'];
				$options[] = array();
				$count = 0;
				if ($fileType == 'Text') {
					$file = @fopen($fileName, "r") ;  
					// while there is another line to read in the file
					$i = 0;
					while (!feof($file))
					{
						$i++;
					    // Get the current line that the file is reading
					    $currentLine = trim(fgets($file));
					    $data = array();
					    foreach (explode(',',$currentLine) as $j=>$field) {
					    	if ($i == 1)
						    	$options[$j] = $field;
						    else
						    	$data[$options[$j]] = $field;
						}
						if ($i > 1) {
						    $model = new $table;
						    foreach($fieldList as $tableField=>$fileField) {
						    	if (!empty($fileField) && isset($data[$fileField]))
						    		$model->$tableField = $data[$fileField];
						    }
						    try {
						    	//$model->UpdateAt = date("Y-m-d H:i:s");
							    if ($model->save())
								    $count++;
							} catch (CDbException $e) {
								;
							}
						}
					}  
					fclose($file) ;
				} else {
					Yii::import('ext.phpexcel.XPHPExcel');   
					$objPHPExcel= XPHPExcel::createPHPExcel();
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objPHPExcel = $objReader->load($fileName);
					$objWorksheet = $objPHPExcel->getActiveSheet();
					$highestRow = $objWorksheet->getHighestRow(); 
					$highestColumn = $objWorksheet->getHighestColumn(); 
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); 
					for ($col = 0; $col < $highestColumnIndex; ++$col) {
						$field = $objWorksheet->getCellByColumnAndRow($col,1)->getValue();
    					$options[$col] = $field;
					}
					for ($row = 2; $row <= $highestRow; ++$row) {
						for ($col = 0; $col < $highestColumnIndex; ++$col) {
							$field = $objWorksheet->getCellByColumnAndRow($col,$row)->getValue();
    						$data[$options[$col]] = $field;
						}
						$model = new $table;
					    foreach($fieldList as $tableField=>$fileField) {
					    	if (!empty($fileField) && isset($data[$fileField]))
					    		$model->$tableField = $data[$fileField];
					    }
					    try {
					    	//$model->UpdateAt = date("Y-m-d H:i:s");
						    if ($model->save())
							    $count++;
						} catch (CDbException $e) {
							;
						}
					}
				}
				$message = "นำเข้าข้อมูลจำนวน $count แถว";
			} else {
				$fileName = Yii::app()->basePath.DIRECTORY_SEPARATOR.			
					'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.
					DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$fileName;
				$options = array(''=>'-');
				if ($fileType == 'Text') {
					$file = @fopen($fileName, "r") ;  
					// while there is another line to read in the file
					while (!feof($file))
					{
					    // Get the current line that the file is reading
					    $currentLine = trim(fgets($file));
					    foreach (explode(',',$currentLine) as $field)
					    	$options[$field] = $field;
					    break;
					}  
					fclose($file) ;
				} else {
					Yii::import('ext.phpexcel.XPHPExcel');   
					$objPHPExcel= XPHPExcel::createPHPExcel();
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objPHPExcel = $objReader->load($fileName);
					$objWorksheet = $objPHPExcel->getActiveSheet();
					$highestColumn = $objWorksheet->getHighestColumn(); 
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); 
					for ($col = 0; $col < $highestColumnIndex; ++$col) {
						$field = $objWorksheet->getCellByColumnAndRow($col,1)->getValue();
    					$options[$field] = $field;
					}		
				}
 
				$sql = <<<SQL
					SELECT COLUMN_NAME AS id
					FROM INFORMATION_SCHEMA.COLUMNS 
					WHERE TABLE_SCHEMA='backend' 
    				AND TABLE_NAME='$table'
SQL;
				$rawData = Yii::app()->db->createCommand($sql)->queryAll();
				$dataProvider = new CArrayDataProvider($rawData, array(
    				'pagination'=>array(
        				'pageSize'=>count($rawData),
    				),
				));
				$this->render('index2', array(
    				'table' => $table,
    				'folder' => $folder,
    				'fileName' => $fileName,
    				'fileType' => $fileType,
    				'dataProvider' => $dataProvider,
    				'options' => $options,
				));
				return;
			}
		} else {
			$message = '';
		}

		$tableList = array(
			"Customer" => "Customer",
			"Product" => "Product",
			);

		$dir = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files';
		$files = scandir($dir);
		$folderList = array();
		foreach ($files as $file) {
			if ($file != '.' && $file != '..' && is_dir($dir.DIRECTORY_SEPARATOR.$file))
				$folderList[$file] = $file;
		}
		$fileList = array();
		if (!empty($folderList)) {
			$files = scandir($dir.DIRECTORY_SEPARATOR.array_shift(array_keys($folderList)));
			foreach ($files as $file) {
				if (!is_dir($dir.DIRECTORY_SEPARATOR.$file) && $this->endsWith($file,'.xls'))
					$fileList[$file] = $file;
			}
		}

		$fieldList = array();
		foreach (Yii::app()->db->schema->getTable('Customer')->columns as $column) {
			$fieldList[$column->name] = $column->name;
		}
		$this->render('index', array(
    		'tableList' => $tableList,
    		'folderList' => $folderList,
    		'fileList' => $fileList,
    		'fieldList' => $fieldList,
    		'message' => $message,
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