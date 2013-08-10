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

	public function actionGetStockStartOptions() {
		$saleId = $_POST['SaleId'];
	    $data = StockStartList::model()->getGrpLevel1($saleId);
	    $grp1 = '';
    	foreach($data as $value=>$name)
        	$grp1 .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['GrpLevel1Id']))
	        $grpLevel1Id = $_POST['GrpLevel1Id'];
	   	else
	   		$grpLevel1Id = '';
	    $data = StockStartList::model()->getGrpLevel2($saleId,$grpLevel1Id);
	    $grp2 = '';
    	foreach($data as $value=>$name)
        	$grp2 .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['GrpLevel2Id']))
	        $grpLevel2Id = $_POST['GrpLevel2Id'];
	   	else
	   		$grpLevel2Id = '';
	    $data = StockStartList::model()->getGrpLevel3($saleId,$grpLevel1Id,$grpLevel2Id);
	    $grp3 = '';
    	foreach($data as $value=>$name)
        	$grp3 .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['GrpLevel3Id']))
	        $grpLevel3Id = $_POST['GrpLevel3Id'];
	   	else
	   		$grpLevel3Id = '';

	    $data = StockStartList::model()->getType();
	    $type = '';
    	foreach($data as $value=>$name)
        	$type .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['Type']))
	        $ptype = $_POST['Type'];
	   	else
	   		$ptype = 'a';
	    $data = StockStartList::model()->getProduct($saleId,$grpLevel1Id,$grpLevel2Id,$grpLevel3Id,$ptype);
	    $pro = '';
    	foreach($data as $value=>$name)
        	$pro .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['ProductId']))
	        $productId = $_POST['ProductId'];
	   	else
	   		$productId = array_shift(array_keys($data));	
	   	$pack = '';
	   	if (!empty($productId)) {
		    $data = StockStartList::model()->getPack($productId);		    
    		foreach($data as $value=>$name)
        		$pack .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
        }
        echo CJSON::encode(array(
              'grp1'=>$grp1,
              'grp2'=>$grp2,
              'grp3'=>$grp3,
              'type'=>$type,
              'pack'=>$pack,
              'pro'=>$pro,
            ));
	}

	public function actionGetRequestId() {
		$saleId = $_POST['SaleId'];
 		echo ControlNo::model()->getControlNo($saleId,'ใบเบิกสินค้า');
	}


	public function actionGetRequestOptions() {
		$requestNo = $_POST['RequestNo'];
	    $data = RequestDetail::model()->getGrpLevel1($requestNo);
	    $grp1 = '';
    	foreach($data as $value=>$name)
        	$grp1 .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['GrpLevel1Id']))
	        $grpLevel1Id = $_POST['GrpLevel1Id'];
	   	else
	   		$grpLevel1Id = '';
	    $data = RequestDetail::model()->getGrpLevel2($requestNo,$grpLevel1Id);
	    $grp2 = '';
    	foreach($data as $value=>$name)
        	$grp2 .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['GrpLevel2Id']))
	        $grpLevel2Id = $_POST['GrpLevel2Id'];
	   	else
	   		$grpLevel2Id = '';
	    $data = RequestDetail::model()->getGrpLevel3($requestNo,$grpLevel1Id,$grpLevel2Id);
	    $grp3 = '';
    	foreach($data as $value=>$name)
        	$grp3 .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['GrpLevel3Id']))
	        $grpLevel3Id = $_POST['GrpLevel3Id'];
	   	else
	   		$grpLevel3Id = '';

	   	if (isset($_POST['ProductIdName']))
	   		$productIdName = $_POST['ProductIdName'];
	   	else
	   		$productIdName = '';
	    $data = RequestDetail::model()->getProduct($requestNo,$grpLevel1Id,$grpLevel2Id,$grpLevel3Id,$productIdName);
	    $pro = '';
    	foreach($data as $value=>$name)
        	$pro .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);

        if (isset($_POST['ProductId']))
	        $productId = $_POST['ProductId'];
	   	else
	   		$productId = array_shift(array_keys($data));	
	  
	  	$l1 = $l2 = $l3 = $l4 = true;
	  	$p1 = $p2 = $p3 = $p4 = '';
	   	if (!empty($productId)) {
	   		$product = Product::model()->findByPk($productId);
	   		$l1 = empty($product->PackLevel1);
	   		$l2 = empty($product->PackLevel2);
	   		$l3 = empty($product->PackLevel3);
	   		$l4 = empty($product->PackLevel4);
	   		$p1 = $product->PackLevel1;
	   		$p2 = $product->PackLevel2;
	   		$p3 = $product->PackLevel3;
	   		$p4 = $product->PackLevel4;
       }
        echo CJSON::encode(array(
              'grp1'=>$grp1,
              'grp2'=>$grp2,
              'grp3'=>$grp3,
              'pro'=>$pro,
              'l1'=>$l1,
              'l2'=>$l2,
              'l3'=>$l3,
              'l4'=>$l4,
              'p1'=>$p1,
              'p2'=>$p2,
              'p3'=>$p3,
              'p4'=>$p4,
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