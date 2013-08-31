<?php 
 
class HistoryCommand extends CConsoleCommand
{
    public function run($args)
    {
    	$helper = new CreateHistory;

		$helper->generate();

    }
}

?>