<?php

class DefaultController extends GxController
{
	private $reportList = array(
			'NewCustomer' => 'ร้านค้าใหม่',
			'ProductOrder' => 'ใบสั่งซื้อ',
			'ProductReturn' => 'รับคืนสินค้า',
			'CustomerStock' => 'สต็อคร้านค้า',
			'DailySale' => 'ยอดขายรายวัน',
			'TargetSale' => 'ยอดขายเทียบเป้า',
			'BillCollection' => 'ชำระเงิน',
			'Payment' => 'รายการเช็ค CN โอนเงินสด',
			'MoneyTransfer' => 'โอนเงินสด',
			'Customer' => 'ร้านค้า',
			'ProductExchange' => 'เปลี่ยนสินค้า',
			'StockRequest' => 'เบิก ส่ง รับ สินค้า',
			'StockTransfer' => 'โอนสินค้าเข้าคล้งสิ้นทริป',
			'StockStatus' => 'สินค้าเคลื่อนไหว',
			'SyncLog' => 'รับส่งข้อมูล',
		);

	public function actionIndex()
	{
		$error = '';
		if (isset($_POST['from_date'])) {
			$from_date = $_POST['from_date'];
			$to_date = $_POST['to_date'];
			$report = $_POST['report'];
			$format = $_POST['format'];
			if (isset($_POST['ids'])) {
				$ids = $_POST['ids'];
				if ($report == 'NewCustomer') {
					$report = new NewCustomerReport();
					$report->create($ids, $format);
				} elseif ($report == 'ProductOrder') {
					$report = new ProductOrderReport();
					$report->create($ids, $from_date, $to_date, $format);
				} elseif ($report == 'ProductReturn') {
					$report = new ProductReturnReport();
					$report->create($ids, $from_date, $to_date, $format);
				} elseif ($report == 'CustomerStock') {
					$report = new CustomerStockReport();
					$report->create($ids, $from_date, $to_date, $format);
				} elseif ($report == 'DailySale') {
					$report = new DailySaleReport();
					$report->create($ids, $from_date, $to_date, $format);
				} elseif ($report == 'TargetSale') {
					$report = new TargetSaleReport();
					$report->create($ids, $from_date, $to_date, $format);
				} elseif ($report == 'BillCollection') {
					$report = new BillCollectionReport();
					$report->create($ids, $from_date, $to_date, $format);
				} elseif ($report == 'Payment') {
					$report = new PaymentReport();
					$report->create($ids, $from_date, $to_date, $format);
				} elseif ($report == 'MoneyTransfer') {
					$report = new MoneyTransferReport();
					$report->create($ids, $from_date, $to_date, $format);
				} elseif ($report == 'Customer') {
					$report = new CustomerReport();
					$report->create($ids, $format);
				} elseif ($report == 'ProductExchange') {
					$report = new ProductExchangeReport();
					$report->create($ids, $from_date, $to_date, $format);
				} elseif ($report == 'StockRequest') {
					$report = new StockRequestReport();
					$report->create($ids, $from_date, $to_date, $format);
				} elseif ($report == 'StockTransfer') {
					$report = new StockTransferReport();
					$report->create($ids, $from_date, $to_date, $format);
				} elseif ($report == 'StockStatus') {
					$report = new StockStatusReport();
					$report->create($ids, $format);
				} elseif ($report == 'SyncLog') {
					$report = new SyncLogReport();
					$report->create($ids, $from_date, $to_date, $format);
				} else
					throw new CHttpException(404,'The specified action cannot be found.');
				
			}
			else
				$error = 'กรุณาเลือกหน่วยขาย';
		} else {
			$from_date = date("Y-m-01");
			$to_date = date("Y-m-t");
			$report = '';
			$format = 'Pdf';
		}
		$sql = <<<SQL
		SELECT SaleId AS id, SaleName
		FROM SaleUnit
		WHERE SaleId IN (SELECT SaleId FROM Device)
		ORDER BY SaleName
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
           	 	'SaleName'
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>count($rawData),
    		),
		));

		// Render
		$this->render('index', array(
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
			'from_date' => $from_date,
			'to_date' => $to_date,
			'report' => $report,
			'format' => $format,
			'reportList' => $this->reportList,
			'error' => $error,
		));
	}
}