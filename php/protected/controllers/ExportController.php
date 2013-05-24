<?php

class ExportController extends Controller
{
	private function formatTable($text) {
		$pos = strpos($text, "(");
		$text = substr($text,0,$pos+1)."\n  SyncFlag char(1) NOT NULL DEFAULT 'N',".substr($text,$pos+1);
		$pos = strrpos($text,"\n)");
		$text = substr($text,0,$pos).")";
		$text = str_replace(' AUTO_INCREMENT','',$text);
		$text = str_replace('`','',$text);
		$text = str_replace("\n","\" +\n\t\"", $text);
		return "\"$text\";\n";
	}
	private function formatRow($table, $row) {
		return "\"INSERT INTO $table VALUES('" . implode("','",array_values($row)) . "')\"";
	}
	public function actionSql() {
		$table = $_GET['table'];
		header('Content-type: text/plain; charset=utf-8');
		$db = Yii::app()->db;
		$db->createCommand("SET sql_quote_show_create = 0")->execute();
		$reader = $db->createCommand("SHOW CREATE TABLE $table")->query();
 		echo "\npublic final static String $table = ";
    	foreach($reader as $row)
    		echo $this->formatTable($row['Create Table']);
	   	echo "\ndb.execSQL(SQLTable.$table);\n";
    	

 		$reader = $db->createCommand("SELECT * FROM $table")->query();
 		echo "\npublic final static String[] $table = new String[] {\n\t";
 		$rows = array();
		foreach($reader as $row)
    		$rows[] = $this->formatRow($table, $row);
    	echo implode(",\n\t",$rows);
    	echo "};\n";

    	echo "\nfor (String row : LoadOptionData.$table)";
    	echo "\n\tdb.execSQL(row);\n";

    	Yii::app()->end();    
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