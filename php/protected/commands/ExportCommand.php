<?php 
 
class ExportCommand extends CConsoleCommand
{
    public function run($args)
    {
    	$folder = $args[0];
    	$type = $args[1];
    	$helper = new ExportDb;
    	for ($i = 2; $i < count($args); $i++) {
    		$table = $args[$i];
    		$fieldList = array();
			foreach (Yii::app()->db->schema->getTable($table)->columns as $column) {
				$fieldList[] = $column->name;
			}
    		$fileName = Yii::app()->basePath . "/../../files/$folder/$table-" . date("YmdHis");
			if ($type == 'txt') {
				$helper->exportText($table, $fieldList, $fileName);
			} else {
				$helper->exportExcel($table, $fieldList, $fileName);
			}
    	}
    }
}

?>