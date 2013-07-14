<?php

class HelperController extends Controller
{

	public function actionGetDistricts() {
	    $data = Location::model()->getDistricts($_POST['Province']);
	    $districts = '';
    	foreach($data as $value=>$name)
        	$districts .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

	    $data = Location::model()->getSubDistricts($_POST['Province'],array_shift(array_values($data)));
	    $subdistricts = '';
    	foreach($data as $value=>$name)
        	$subdistricts .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        echo CJSON::encode(array(
              'districts'=>$districts,
              'subdistricts'=>$subdistricts
            ));
	}

	public function actionGetSubDistricts() {
		$data = Location::model()->getSubDistricts($_POST['Province'],$_POST['District']);
    	foreach($data as $value=>$name)
        	echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
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