<?php
class NewCustomerReport {
	private $title = 'รายชื่อร้านค้าใหม่';
	private $header = array('รหัสร้านค้า',
        	'ชื่อร้านค้า', 
        	'ตำบล', 
        	'อำเภอ', 
        	'จังหวัด', 
        	'หน่วยขาย'); 
	private $data;

  	public function __construct($ids) {
  		$where = "NewFlag = 'Y' AND SaleId IN ('".implode("','",$ids)."')";
  		$models = Customer::model()->findAll(array(
  			'order'=>'Title, CustomerName', 
  			'condition'=>"NewFlag = 'Y' AND SaleId IN ('".implode("','",$ids)."')",
  			));
		$data = array();
		foreach ($models as $model) {
			$data[] = array(
				$model->CustomerId,
				$model->Title.$model->CustomerName,
				$model->SubDistrict,
				$model->District,
				$model->Province,
				$model->saleUnit->SaleName,
			);   
		}    
    	$this->data = $data;
  	}

  	public function create2($format) {
  		if ($format == 'Excel')
  			$this->createExcel();
  		else
  			$this->createPdf();
  	}

  	private function createPdf() {
  		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        spl_autoload_register(array('YiiBase','autoload'));
        // set document information
 		$thaidate = new ThaiDate;
        $pdf->SetCreator(PDF_CREATOR);   
        $pdf->SetTitle($this->title);                
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $this->title, "รายงาน".$thaidate->thaidate( "วันที่ j F Y - H:i:s" ));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetTextColor(80,80,80);
        $pdf->AddPage();

		$w = array(100, 140, 60, 60, 60, 90);
		$html = "<h2>".$this->title.":</h2>";
        $html .= '<table border="1" bordercolor="#eeeeee" cellspacing="0" cellpadding="3">';
        $html .= "<tr bgcolor=\"#eebba0\">";
        foreach ($this->header as $i=>$txt)
        	$html .= "<th width=\"$w[$i]\"><b>$txt</b></th>";
        $html .= "</tr>";
        foreach ($this->data as $i=>$row) {
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
        $pdf->Output('NewCustomerReport.pdf', 'I');
        Yii::app()->end();
  	}

	private function col($index) {
		if ($index < 26)
			return chr(ord('A')+$index);
		else {
			$i = $index / 26 - 1;
			$j = $index % 26;
			return chr(ord('A')+$i).chr(ord('A')+$j);
		}
	}

  	public function create($format) {
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getDefaultStyle()->getFont()->setName('THSarabunNew'); 
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(16);
		// $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT); 
		// $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		// $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1); 
		// $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75); 
		// $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75); 
		// $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1);
		// $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1); 
		// $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		// $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true); 
		// $objPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

		$objPHPExcel->getActiveSheet()->setTitle($this->title);
		
		$col = $this->col(count($this->header)-1);
		$styleArray = array( 
			'font' => array( 'bold' => true, 'size' => 18), 
			'alignment' => array( 
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
				), 
			 // 'borders' => array( 
			 // 		'allborders' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN, ), 
			 // 	), 
			'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 
				'startcolor' => array( 'argb' => 'ffeebba0', ), 
				), 
			); 
		$objPHPExcel->getActiveSheet()->mergeCells("A1:{$col}1");
		$objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $this->title);
		$styleArray = array( 
			'font' => array( 'bold' => true, 'size' => 16), 
			'alignment' => array( 
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
				), 
			'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 
				'startcolor' => array( 'argb' => 'ffe0ebff', ), 
				), 
			); 
		$objPHPExcel->getActiveSheet()->getStyle("A3:{$col}3")->applyFromArray($styleArray);

		foreach ($this->header as $i=>$txt)
			$objPHPExcel->getActiveSheet()->SetCellValue($this->col($i).'3', $txt);

		foreach ($this->data as $i=>$row)
			foreach ($row as $j=>$txt)
				$objPHPExcel->getActiveSheet()->SetCellValue($this->col($j).($i+4), $txt);
		// $col = $this->col($j);
		// $i+=5;
		// $objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea("A1:$col$i");
		$w = array(13, 20, 10, 10, 10, 12);
		for ($i = 0; $i < count($this->header); $i++)	
			$objPHPExcel->getActiveSheet()->getColumnDimension($this->col($i))->setWidth($w[$i]);
		//	$objPHPExcel->getActiveSheet()->getColumnDimension($this->col($i))->setAutoSize(true);
		if ($format == 'Excel') {
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="NewCustomerReport.xls"'); 
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		} else {
			$rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF; 
			$rendererLibrary = 'tcpdf'; 
			$rendererLibraryPath = Yii::getPathOfAlias('application.vendors') . '/' . $rendererLibrary; 
			if (!PHPExcel_Settings::setPdfRenderer( $rendererName, $rendererLibraryPath )) { 
				die( 'Please set the $rendererName and $rendererLibraryPath values' . PHP_EOL . ' as appropriate for your directory structure' ); 
			}
			header('Content-Type: application/pdf');
			// header('Content-Disposition: attachment;filename="NewCustomerReport.pdf"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
		}
		$objWriter->save('php://output');
		Yii::app()->end();
  	}










}
?>