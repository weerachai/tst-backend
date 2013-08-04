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

	public function actionGetAvailableLocations() {
		$province = $_POST['Province'];
	    $data = Customer::model()->getAvailableDistricts($province);
	    $districts = '';
    	foreach($data as $value=>$name)
        	$districts .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['District']))
	        $district = $_POST['District'];
	   	else
	   		$district = array_shift(array_values($data));
	    $data = Customer::model()->getAvailableSubDistricts($province,$district);
	    $subdistricts = '';
    	foreach($data as $value=>$name)
        	$subdistricts .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        echo CJSON::encode(array(
              'districts'=>$districts,
              'subdistricts'=>$subdistricts,
            ));
	}

	public function actionGetSaleLocations() {
		$saleId = $_POST['SaleId'];

		$data = Customer::model()->getSaleProvinces($saleId);
		$provinces = '';
		foreach($data as $value=>$name)
        	$provinces .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['Province']))
	        $province = $_POST['Province'];
	   	else
	   		$province = array_shift(array_values($data));
	    $data = Customer::model()->getsaleDistricts($saleId,$province);
	    $districts = '';
    	foreach($data as $value=>$name)
        	$districts .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['District']))
	        $district = $_POST['District'];
	   	else
	   		$district = array_shift(array_values($data));
	    $data = Customer::model()->getSaleSubDistricts($saleId,$province,$district);
	    $subdistricts = '';
    	foreach($data as $value=>$name)
        	$subdistricts .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        echo CJSON::encode(array(
              'provinces'=>$provinces,
              'districts'=>$districts,
              'subdistricts'=>$subdistricts,
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

	public function actionGetTrips() {
		$data = Trip::model()->getOptions($_POST['Type']);
		$trips = '';
    	foreach($data as $value=>$name)
        	$trips .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        echo CJSON::encode(array(
              'trips'=>$trips,
            ));
	}

	public function actionGetCheckOptions() {
		$saleId = $_POST['SaleId'];
	    $data = StockCheckList::model()->getCheckGrpLevel1($saleId);
	    $grp1 = '';
    	foreach($data as $value=>$name)
        	$grp1 .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['GrpLevel1Id']))
	        $grpLevel1Id = $_POST['GrpLevel1Id'];
	   	else
	   		$grpLevel1Id = '';
	    $data = StockCheckList::model()->getCheckGrpLevel2($saleId,$grpLevel1Id);
	    $grp2 = '';
    	foreach($data as $value=>$name)
        	$grp2 .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['GrpLevel2Id']))
	        $grpLevel2Id = $_POST['GrpLevel2Id'];
	   	else
	   		$grpLevel2Id = '';
	    $data = StockCheckList::model()->getCheckGrpLevel3($saleId,$grpLevel1Id,$grpLevel2Id);
	    $grp3 = '';
    	foreach($data as $value=>$name)
        	$grp3 .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['GrpLevel3Id']))
	        $grpLevel3Id = $_POST['GrpLevel3Id'];
	   	else
	   		$grpLevel3Id = '';
	    $data = StockCheckList::model()->getCheckProduct($saleId,$grpLevel1Id,$grpLevel2Id,$grpLevel3Id);
	    $pro = '';
    	foreach($data as $value=>$name)
        	$pro .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        echo CJSON::encode(array(
              'grp1'=>$grp1,
              'grp2'=>$grp2,
              'grp3'=>$grp3,
              'pro'=>$pro,
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