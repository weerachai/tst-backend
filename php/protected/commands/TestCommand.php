<?php 
 
class TestCommand extends CConsoleCommand
{
    public function run($args)
    {
    	$helper = new BackupDb;

		$tables = $helper->getTables();

		if($helper->StartBackup())
		{
			foreach($tables as $tableName)
			{
				$helper->getColumns($tableName);
			}
			foreach($tables as $tableName)
			{
				$helper->getData($tableName);
			}
			$helper->EndBackup();
    	}
    }
}

?>