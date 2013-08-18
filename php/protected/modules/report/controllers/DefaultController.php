<?php

class DefaultController extends Controller
{
	public function createpdf($title, $header, $w, $data){
 
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        spl_autoload_register(array('YiiBase','autoload'));
        // set document information
 		$thaidate = new ThaiDate;
        $pdf->SetCreator(PDF_CREATOR);   
        $pdf->SetTitle($title);                
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, "รายงาน".$thaidate->thaidate( "วันที่ j F Y - H:i:s" ));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetTextColor(80,80,80);
        $pdf->AddPage();

		$html = "<h2>$title:</h2>";
        $html .= '<table border="1" bordercolor="#eeeeee" cellspacing="0" cellpadding="3">';
        $html .= "<tr bgcolor=\"#ff0000\">";
        foreach ($header as $i=>$txt)
        	$html .= "<th width=\"$w[$i]\"><b>$txt</b></th>";
        $html .= "</tr>";
        foreach ($data as $i=>$row) {
        	if ($i%2)
        		$html .= "<tr bgcolor=\"#e0ebff\">";
        	else
        		$html .= "<tr>";
        	foreach ($row as $txt) {
        		$html .= "<td>$txt</td>";
        	}
        	$html .= "</tr>";
        }
        $html .= '</table>';
		$pdf->writeHTML($html, true, false, true, false, '');

        // reset pointer to the last page
        $pdf->lastPage();
 
        //Close and output PDF document
        $pdf->Output('filename.pdf', 'I');
        Yii::app()->end();
    }

    private function createExcel($title,$header,$data) {
    	$c = count($header);
        $r = new YiiReport(array('template'=> "template$c.xls"));
        $r->load(array(
            	array(
                    'id' => 'report',
                    'data' => array('name'=>$title),
            	),
            	array(
                    'id' => 'header',
                    'data' => $header,
            	),
            	array(
                    'id' => 'row',
                    'repeat'=>true,
                    'data' => $data,
                    'minRows'=>2,
            	),
       		));        
        echo $r->render('excel5', 'NewCustomerReport');
    }
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
			'StockExchange' => 'เปลี่ยนสินค้า',
			'StockRequest' => 'เบิก ส่ง รับ สินค้า',
			'StockTransfer' => 'โอนสินค้าเข้าคล้งสิ้นทริป',
			'StockProgress' => 'สินค้าเคลื่อนไหว',
		);

	private function newCustomerReport($ids, $format) {
        $title = "รายชื่อร้านค้าใหม่";
        $header = array('h1'=>'รหัสร้านค้า',
        	'h2'=>'ชื่อร้านค้า', 
        	'h3'=>'ตำบล', 
        	'h4'=>'อำเภอ', 
        	'h5'=>'จังหวัด', 
        	'h6'=>'หน่วยขาย'); 
		$models = Customer::model()->findAll("SaleId IN ('".implode("','",$ids)."')");
		$data = array();
		foreach ($models as $model) {
			$data[] = array(
				'd1'=>$model->CustomerId,
				'd2'=>$model->Title.$model->CustomerName,
				'd3'=>$model->SubDistrict,
				'd4'=>$model->District,
				'd5'=>$model->Province,
				'd6'=>$model->saleUnit->SaleName,
			);   
		}     
		if ($format == 'Excel') {
	        $this->createExcel($title,$header,$data);
        } else {
			$w = array(100, 140, 60, 60, 60, 90);
			$this->createpdf($title,array_values($header),$w,$data);
        }
	}

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
				if ($report == 'NewCustomer')
					$this->newCustomerReport($ids, $format);
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