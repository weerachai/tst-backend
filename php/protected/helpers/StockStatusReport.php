<?php
class StockStatusReport extends MyReport {

  	public function create($ids, $format) {
  		$title = 'สินค้าเคลื่อนไหว';
		$header = array('หน่วยขาย',
			'รหัสสินค้า',
			'ชื่อสินค้า',
        	'รับต้นทริป', 
        	'รับระหว่างทริป', 
        	'รับ',
        	'ให้',
        	'ขาย',
        	'แถม',
        	'โอนระหว่างทริป',
        	'โอนสิ้นทริป',
        	);
		$w = array(12, 8, 15, 8, 8, 8, 8, 8, 8, 8, 8);
		$align = array('L','L','L','L','L','L','L','L','L','L','L');
  		$models = Stock::model()->findAll(array(
  			'order'=>'SaleId, ProductId', 
  			'condition'=>"SaleId IN ('".implode("','",$ids)."')",
  			));
		$data = array();
		foreach ($models as $model) {
			$data[] = array(
				$model->saleUnit->SaleName,
				$model->ProductId,
				$model->product->ProductName,
				$this->formatQty(
					array(
						$model->StartQtyLevel1,
						$model->StartQtyLevel2,
						$model->StartQtyLevel3,
						$model->StartQtyLevel4,
					),
					array(
						$model->product->PackLevel1,
						$model->product->PackLevel2,
						$model->product->PackLevel3,
						$model->product->PackLevel4,
					)
				),
				$this->formatQty(
					array(
						$model->MidInQtyLevel1,
						$model->MidInQtyLevel2,
						$model->MidInQtyLevel3,
						$model->MidInQtyLevel4,
					),
					array(
						$model->product->PackLevel1,
						$model->product->PackLevel2,
						$model->product->PackLevel3,
						$model->product->PackLevel4,
					)
				),
				$this->formatQty(
					array(
						$model->ReturnQtyLevel1,
						$model->ReturnQtyLevel2,
						$model->ReturnQtyLevel3,
						$model->ReturnQtyLevel4,
					),
					array(
						$model->product->PackLevel1,
						$model->product->PackLevel2,
						$model->product->PackLevel3,
						$model->product->PackLevel4,
					)
				),
				$this->formatQty(
					array(
						$model->ReplaceQtyLevel1,
						$model->ReplaceQtyLevel2,
						$model->ReplaceQtyLevel3,
						$model->ReplaceQtyLevel4,
					),
					array(
						$model->product->PackLevel1,
						$model->product->PackLevel2,
						$model->product->PackLevel3,
						$model->product->PackLevel4,
					)
				),
				$this->formatQty(
					array(
						$model->SaleQtyLevel1,
						$model->SaleQtyLevel2,
						$model->SaleQtyLevel3,
						$model->SaleQtyLevel4,
					),
					array(
						$model->product->PackLevel1,
						$model->product->PackLevel2,
						$model->product->PackLevel3,
						$model->product->PackLevel4,
					)
				),
				$this->formatQty(
					array(
						$model->FreeQtyLevel1,
						$model->FreeQtyLevel2,
						$model->FreeQtyLevel3,
						$model->FreeQtyLevel4,
					),
					array(
						$model->product->PackLevel1,
						$model->product->PackLevel2,
						$model->product->PackLevel3,
						$model->product->PackLevel4,
					)
				),
				$this->formatQty(
					array(
						$model->MidOutQtyLevel1,
						$model->MidOutQtyLevel2,
						$model->MidOutQtyLevel3,
						$model->MidOutQtyLevel4,
					),
					array(
						$model->product->PackLevel1,
						$model->product->PackLevel2,
						$model->product->PackLevel3,
						$model->product->PackLevel4,
					)
				),
				$this->formatQty(
					array(
						$model->EndQtyLevel1,
						$model->EndQtyLevel2,
						$model->EndQtyLevel3,
						$model->EndQtyLevel4,
					),
					array(
						$model->product->PackLevel1,
						$model->product->PackLevel2,
						$model->product->PackLevel3,
						$model->product->PackLevel4,
					)
				),
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);
		
		$this->output($objPHPExcel, $format, "StockStatusReport");
		Yii::app()->end();
  	}
}
?>