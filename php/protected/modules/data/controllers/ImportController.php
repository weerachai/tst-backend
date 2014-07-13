<?php

class ImportController extends GxController
{
	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index'),
				'expression'=>'$user->checkAccess("operator")', 
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}
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

		$message = '';
		$error = '';
		if (isset($_POST['Table']) && isset($_POST['Folder']) && isset($_POST['FileName'])) {
			$table = $_POST['Table'];
			$folder = $_POST['Folder'];
			$fileName = $_POST['FileName'];
			$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
			if (isset($_POST['FieldList'])) {
				$fieldList = $_POST['FieldList'];
				$options[] = array();
				$update = 0;
				$insert = 0;
				if ($fileType == 'txt') {
					$file = @fopen($fileName, "r") ;  
					// while there is another line to read in the file
					$i = 0;
					while (!feof($file))
					{
						$i++;
					    // Get the current line that the file is reading
					    $currentLine = trim(fgets($file));
					    $data = array();
					    $vals = explode(',',$currentLine);
					    for ($j = 0; $j < count($vals); $j++) {
					    	$field = $vals[$j];
					    	if ($i == 1)
						    	$options[$j] = $field;
						    else if (is_string($field) && strlen($field) > 1 && $field[0] == '"') {
						    	while ($vals[$j][strlen($vals[$j])-1] != '"') {
						    		$j++;
						    		$field .= $vals[$j];
						    	}
						    	$field = substr($field,1,strlen($field)-2);
						    }
						    $data[$options[$j]] = $field;
						}
						if ($i > 1) {
						    $model = new $table;
						    foreach($fieldList as $tableField=>$fileField) {
						    	if (!empty($fileField) && isset($data[$fileField]))
						    		$model->$tableField = $data[$fileField];
						    }
						    try {
						    	if (isset($model->UpdateAt) && ($model->UpdateAt == null || empty($model->UpdateAt) || $model->UpdateAt == '0000-00-00 00:00:00'))
						    		$model->UpdateAt = date("Y-m-d H:i:s");
	
						    	if ($oldModel = $table::model()->findByPk($model->getPrimaryKey())) {
						    		$oldModel->attributes = $model->attributes;
						    		if ($oldModel->save())
						    			$update++;
						    	} elseif ($model->save())
								    $insert++;
							} catch (CDbException $e) {
								;
							}
						}
					}  
					fclose($file) ;
				} else {
					$objPHPExcel= new PHPExcel();
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
					    	if (isset($model->UpdateAt) && ($model->UpdateAt == null || empty($model->UpdateAt) || $model->UpdateAt == '0000-00-00 00:00:00'))
						    		$model->UpdateAt = date("Y-m-d H:i:s");
						    if ($oldModel = $table::model()->findByPk($model->getPrimaryKey())) {
					    		$oldModel->attributes = $model->attributes;
					    		if ($oldModel->save())
					    			$update++;
					    	} elseif ($model->save())
							    $insert++;
						} catch (CDbException $e) {
							;
						}
					}
				}
				$message = "นำเข้าข้อมูลจำนวน $insert แถว และ update จำนวน $update แถว";
			} else {
				$fileName = Yii::app()->basePath. "/../../files/$folder/$fileName";
				$options = array(''=>'-');
				if ($fileType == 'txt') {
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
					$objPHPExcel= new PHPExcel();
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
			if (!isset($_POST['Folder']))
				$error = 'ท่านไม่ได้เลือก folder';
			elseif (!isset($_POST['FileName']))
				$error = 'ท่านไม่ได้เลือกไฟล์';
		}

		$tableList = array(
			"Customer" => "Customer",
			"Product" => "Product",
			);

		$dir = Yii::app()->basePath . "/../../files";
		$files = scandir($dir);
		$folderList = array();
		foreach ($files as $file) {
			if ($file != '.' && $file != '..' && is_dir("$dir/$file"))
				$folderList[$file] = $file;
		}
		$fileList = array();
		if (!empty($folderList)) {
			$files = scandir("$dir/".array_shift(array_keys($folderList)));
			foreach ($files as $file) {
				if (!is_dir("$dir/$file") && 
					($this->endsWith($file,'.xls') || $this->endsWith($file,'.txt')) )
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
    		'error' => $error,
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