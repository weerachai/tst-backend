<?php

class DeliverController extends GxController
{
	public function actionIndex() { 
		$from_date = isset($_POST['from_date'])? $_POST['from_date'] : '';
		$to_date = isset($_POST['to_date']) ? $_POST['to_date'] : '';
		$status = isset($_POST['status']) ? $_POST['status'] : '0';

		$from_date_sql = empty($from_date) ? '2000-01-01' : $from_date;
		$to_date_sql = empty($to_date) ? '2099-12-31' : $to_date;

		$sql = <<<SQL
		SELECT R.RequestNo AS id, RequestType, RequestFlag,
		RequestDate, D.DeliverNo, D.Status AS Status, DeliverDate,
		ReceiveNo, ReceiveDate
		FROM ((StockRequest R LEFT JOIN StockDeliver D USING(RequestNo))
		LEFT JOIN StockReceive USING(DeliverNo))
		WHERE RequestDate >= '$from_date_sql' AND RequestDate <= '$to_date_sql'
SQL;

		if ($status == '1')
			$sql .= " AND DeliverNo IS NULL";
		elseif ($status == '2')
			$sql .= " AND DeliverNo IS NOT NULL AND ReceiveNo IS NULL";
		$sql .= " ORDER BY id";

		// Create filter model and set properties
		$filtersForm = new FiltersForm;
		if (isset($_GET['FiltersForm']))
		    $filtersForm->filters=$_GET['FiltersForm'];
		 
		// Get rawData and create dataProvider
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$filteredData = $filtersForm->filter($rawData);
		$dataProvider = new CArrayDataProvider($filteredData, array(
    		'sort'=>array(
        		'attributes'=>array(
           	 	 'id', 'RequestType', 'RequestFlag', 'RequestDate', 'DeliverNo', 'Status', 'DeliverDate', 'ReceiveNo', 'ReceiveDate'
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		// Render
		$this->render('index', array(
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
    		'from_date' => $from_date,
    		'to_date' => $to_date,
    		'status' => $status,
		));
	}

	public function actionView($id1, $id2, $id3) {
		if (!empty($id2) && !empty($id3))
			$sql = <<<SQL
			SELECT P.ProductId AS id, RequestNo, DeliverNo, ReceiveNo,
			ProductName, PackLevel1, PackLevel2, PackLevel3, PackLevel4,
			R.QtyLevel1 AS ReqQty1, R.QtyLevel2 AS ReqQty2, 
			R.QtyLevel3 AS ReqQty3, R.QtyLevel4 AS ReqQty4,
			D.QtyLevel1 AS DQty1, D.QtyLevel2 AS DQty2, 
			D.QtyLevel3 AS DQty3, D.QtyLevel4 AS DQty4,
			Rc.QtyLevel1 AS RcQty1, Rc.QtyLevel2 AS RcQty2, 
			Rc.QtyLevel3 AS RcQty3, Rc.QtyLevel4 AS RcQty4
			FROM ((RequestDetail R JOIN Product P USING(ProductId))
			JOIN DeliverDetail D USING(ProductId))
			JOIN ReceiveDetail Rc USING(ProductId)
			WHERE RequestNo = '$id1' AND DeliverNo = '$id2'
			AND ReceiveNo = '$id3'
			ORDER BY ProductName
SQL;
		elseif (!empty($id2))
			$sql = <<<SQL
			SELECT P.ProductId AS id, RequestNo, DeliverNo, '' AS ReceiveNo,
			ProductName, PackLevel1, PackLevel2, PackLevel3, PackLevel4,
			R.QtyLevel1 AS ReqQty1, R.QtyLevel2 AS ReqQty2, 
			R.QtyLevel3 AS ReqQty3, R.QtyLevel4 AS ReqQty4,
			D.QtyLevel1 AS DQty1, D.QtyLevel2 AS DQty2, 
			D.QtyLevel3 AS DQty3, D.QtyLevel4 AS DQty4,
			0 AS RcQty1, 0 AS RcQty2, 
			0 AS RcQty3, 0 AS RcQty4
			FROM (RequestDetail R JOIN Product P USING(ProductId))
			JOIN DeliverDetail D USING(ProductId)
			WHERE RequestNo = '$id1' AND DeliverNo = '$id2'
			ORDER BY ProductName
SQL;
		else
			$sql = <<<SQL
			SELECT P.ProductId AS id, RequestNo, '' AS DeliverNo, '' AS ReceiveNo,
			ProductName, PackLevel1, PackLevel2, PackLevel3, PackLevel4,
			R.QtyLevel1 AS ReqQty1, R.QtyLevel2 AS ReqQty2, 
			R.QtyLevel3 AS ReqQty3, R.QtyLevel4 AS ReqQty4,
			0 AS DQty1, 0 AS DQty2, 
			0 AS DQty3, 0 AS DQty4,
			0 AS RcQty1, 0 AS RcQty2, 
			0 AS RcQty3, 0 AS RcQty4
			FROM RequestDetail R JOIN Product P USING(ProductId)
			WHERE RequestNo = '$id1'
			ORDER BY ProductName
SQL;
		// Create filter model and set properties
		$filtersForm = new FiltersForm;
		if (isset($_GET['FiltersForm']))
		    $filtersForm->filters=$_GET['FiltersForm'];
		 
		// Get rawData and create dataProvider
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$filteredData = $filtersForm->filter($rawData);
		$dataProvider = new CArrayDataProvider($filteredData, array(
    		'sort'=>array(
        		'attributes'=>array(
           	 	 'id','ProductName',
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		// Render
		$this->render('view', array(
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
    		'id1' => $id1,
    		'id2' => $id2,
    		'id3' => $id3,
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