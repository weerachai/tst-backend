<?php
class CustomerStockReport extends MyReport {

  	public function create($ids, $from_date, $to_date, $format) {
  		$title = 'สต็อคร้านค้า';
		$header = array('รหัสสินค้า',
        	'ชื่อสินค้า', 
        	'เดือน', 
        	'สต็อค', 
        	'สั่งซื้อ');
		$w = array(8, 20, 10, 16, 16);
		$align = array('L','L','L','L','L');

		$idlist = implode("','",$ids);
 		$sql = <<<SQL
		SELECT ProductId, YEAR(OrderDate) as Year, MONTH(OrderDate) AS Month, 
		SUM(BuyLevel1) AS Qty1,
		SUM(BuyLevel2) AS Qty2,
		SUM(BuyLevel3) AS Qty3,
		SUM(BuyLevel4) AS Qty4
		FROM OrderDetail JOIN ProductOrder USING(OrderNo)
  		WHERE OrderDate >= '$from_date' AND OrderDate <= '$to_date' AND SaleId IN ('$idlist')
		GROUP BY ProductId, Year, Month
		ORDER BY ProductId, Year DESC, Month
SQL;
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$buy = array();
		foreach ($rawData as $row)
			$buy[$row['ProductId']] = $row;
		$date = explode('-',$from_date);
		$from = $date[0]%100*100+$date[1];
		$date = explode('-',$to_date);
		$to = $date[0]%100*100+$date[1];
 		$sql = <<<SQL
		SELECT P.ProductId, ProductName, Year, Month, 
		SUM(FrontQtyLevel1+BackQtyLevel1) AS Qty1,
		SUM(FrontQtyLevel2+BackQtyLevel2) AS Qty2,
		SUM(FrontQtyLevel3+BackQtyLevel3) AS Qty3,
		SUM(FrontQtyLevel4+BackQtyLevel4) AS Qty4,
		PackLevel1, PackLevel2, PackLevel3, PackLevel4
		FROM StockCheck JOIN Product P USING(ProductId)
  		WHERE Year*100+Month >= $from AND Year*100+Month <= $to AND SaleId IN ('$idlist')
		GROUP BY P.ProductId, ProductName, Year, Month
		ORDER BY P.ProductId, Year DESC, Month
SQL;

		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$data = array();
		foreach ($rawData as $row) {
			$data[] = array(
				$row['ProductId'],
				$row['ProductName'],
				$this->thaidate->format("M y",mktime(0,0,0,$row['Month'],1,$row['Year'])),
				$this->formatQty(
					array(
						$row['Qty1'],
						$row['Qty2'],
						$row['Qty3'],
						$row['Qty4'],
					),
					array(
						$row['PackLevel1'],
						$row['PackLevel2'],
						$row['PackLevel3'],
						$row['PackLevel4'],
					)
				),
				isset($buy[$row['ProductId']])?				
					$this->formatQty(
						array(
							$buy[$row['ProductId']]['Qty1'],
							$buy[$row['ProductId']]['Qty2'],
							$buy[$row['ProductId']]['Qty3'],
							$buy[$row['ProductId']]['Qty4'],
						),
						array(
							$row['PackLevel1'],
							$row['PackLevel2'],
							$row['PackLevel3'],
							$row['PackLevel4'],
						)
					) : '-'
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);
		$this->output($objPHPExcel, $format, "CustomerStockReport");
		Yii::app()->end();
  	}
}
?>