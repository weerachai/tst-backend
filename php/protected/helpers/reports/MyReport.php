<?php
class MyReport {
	protected $thaidate;

	public function __construct() {
    	$this->thaidate = new ThaiDate;
  	}

	private function cellNo($col, $row=0) {
		$cellNo = '';
		if ($col < 26)
			$cellNo = chr(ord('A')+$col);
		else {
			$i = $col / 26 - 1;
			$j = $col % 26;
			$cellNo = chr(ord('A')+$i).chr(ord('A')+$j);
		}
		if ($row>0)
			$cellNo .= $row;
		return $cellNo;
	}

	protected function formatQty($qty, $pack) {
		$str = '';
		for ($i = 0; $i < 4; $i++)
			if ($qty[$i] > 0)
				$str .= number_format($qty[$i]).' '.$pack[$i].' ';
		return trim($str);
	}

	protected function getCost($qty, $price) {
		$cost = 0;
		for ($i = 0; $i < 4; $i++)
			$cost += $qty[$i]*$price[$i];
		return $cost;
	}

	protected function getPHPExcel() {
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getDefaultStyle()->getFont()->setName('THSarabunNew'); 
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(16);

		return $objPHPExcel;
	}

	protected function writeSheet(&$objPHPExcel, $sheet, $title, $short, $header, $w, $align, $data) {
		$objPHPExcel->setActiveSheetIndex($sheet);
		$objPHPExcel->getActiveSheet()->setTitle($short);
		
		$styleArray = array( 
			'font' => array( 'bold' => true, 'size' => 18), 
			'alignment' => array( 
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
				), 
			'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 
				'startcolor' => array( 'argb' => 'ffeebba0', ), 
				), 
			); 
		$objPHPExcel->getActiveSheet()->mergeCells('A1:'.$this->cellNo(count($header)-1,1));
		$objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		
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
		$objPHPExcel->getActiveSheet()
			->getStyle($this->cellNo(0,2).':'.$this->cellNo(count($header)-1,2))
			->applyFromArray($styleArray);

		$a = array('L'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			'R'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			'C'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
		foreach ($header as $i=>$txt) {
			$cell = $this->cellNo($i);
			$objPHPExcel->getActiveSheet()->getColumnDimension($cell)->setWidth($w[$i]);
			$objPHPExcel->getActiveSheet()->SetCellValue($cell.'2', $txt);
		}


		foreach ($data as $i=>$row)
			foreach ($row as $j=>$txt)
				$objPHPExcel->getActiveSheet()->SetCellValue($this->cellNo($j,$i+3), $txt);
		
		for ($j = 0; $j < count($header); $j++) {
			$cell = $this->cellNo($j);
			$objPHPExcel->getActiveSheet()->getStyle($cell.'2:'.$cell.($i+3))->getAlignment()->setHorizontal($a[$align[$j]]);
		}

//		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(2, 2);
	}

	protected function output(&$objPHPExcel, $format, $filename) {
		if ($format == 'Excel') {
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="'.$filename.'".xls"'); 
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
			// header('Content-Disposition: attachment;filename="'.$filename.'".pdf"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
			$objWriter->writeAllSheets();
		}
		$objWriter->save('php://output');
	}

	protected function addSection(&$objPHPExcel, $row, $col, $section) {
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);
		$objPHPExcel->getActiveSheet()->mergeCells("A$row:".$this->cellNo($col-1,$row));
		$styleArray = array( 
			'font' => array( 'bold' => true, 'size' => 16, 'color' => array( 'argb' => 'ffffff00', ) ), 
			'alignment' => array( 
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
				), 
			'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 
				'startcolor' => array( 'argb' => 'ff33aa33', ), 
				),
			); 
		$objPHPExcel->getActiveSheet()->getStyle("A$row")->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->SetCellValue("A$row", $section);
	}
}