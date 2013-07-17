<?php

class HelperController extends Controller
{

	public function actionGetLocations() {
		$province = $_POST['Province'];
	    $data = Location::model()->getDistricts($province);
	    $districts = '';
    	foreach($data as $value=>$name)
        	$districts .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['District']))
	        $district = $_POST['District'];
	   	else
	   		$district = array_shift(array_values($data));
	    $data = Location::model()->getSubDistricts($province,$district);
	    $subdistricts = '';
    	foreach($data as $value=>$name)
        	$subdistricts .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['SubDistrict']))
	        $subdistrict = $_POST['SubDistrict'];
	   	else
        	$subdistrict = array_shift(array_values($data));
	    $data = Location::model()->getZipCodes($province,$district,$subdistrict);
	    $zipcodes = '';
    	foreach($data as $value=>$name)
        	$zipcodes .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        echo CJSON::encode(array(
              'districts'=>$districts,
              'subdistricts'=>$subdistricts,
              'zipcodes'=>$zipcodes,
            ));
	}

	public function actionGetProductsOrGroups() {
		$type = $_POST['PromotionType'];
		if ($type == 'sku' || $type == 'accu-sku') {
			$data = Product::model()->getOptions();
		} else if ($type == 'group') {
			$data = Promotion::model()->getProductGroups();
		} else if ($type == 'accu-l1') {
			$data = Product::model()->getGroupLevel1();
		} else if ($type == 'accu-l2') {
			$data = Product::model()->getGroupLevel2();
		} else if ($type == 'accu-l3') {
			$data = Product::model()->getGroupLevel3();
		} else {
			$data = array();
		}
		if (count($data) > 0)
		    foreach($data as $value=>$name)
 		       echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
    	else
    		echo CHtml::tag('option',array('value'=>''),CHtml::encode('-'),true);
	}

	public function actionGetFreeProductsOrGroups() {
		$type = $_POST['FreeType'];
		if ($type == 'S') {
			$data = Product::model()->getOptions();
		} else if ($type == 'G') {
			$data = Promotion::model()->getFreeProductGroups();
		} else {
			$data = array();
		}
		if (count($data) > 0)
		    foreach($data as $value=>$name)
 		       echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
    	else
    		echo CHtml::tag('option',array('value'=>''),CHtml::encode('-'),true);
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