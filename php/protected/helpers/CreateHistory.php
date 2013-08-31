<?php
class CreateHistory {
	public function generate() {
		Yii::app()->db->createCommand()->truncateTable('SaleHistory');
		$sql = <<<SQL
			SELECT SaleId, CustomerId, P.ProductId
			FROM (Customer C JOIN StockCheckList S USING(SaleId))
			JOIN Product P USING(GrpLevel1Id)
			WHERE S.GrpLevel2Id = '' AND S.GrpLevel3Id = '' AND S.ProductId = ''
			UNION
			SELECT SaleId, CustomerId, P.ProductId
			FROM (Customer C JOIN StockCheckList S USING(SaleId))
			JOIN Product P USING(GrpLevel1Id, GrpLevel2Id)
			WHERE S.GrpLevel3Id = '' AND S.ProductId = ''
			UNION
			SELECT SaleId, CustomerId, P.ProductId
			FROM (Customer C JOIN StockCheckList S USING(SaleId))
			JOIN Product P USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id)
			WHERE S.ProductId = ''
			UNION
			SELECT SaleId, CustomerId, P.ProductId
			FROM (Customer C JOIN StockCheckList S USING(SaleId))
			JOIN Product P USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId)
			ORDER BY SaleId, CustomerId, ProductId
SQL;
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($rawData as $row) {
			$this->compute($row['SaleId'], $row['CustomerId'], $row['ProductId']);
		}
	}

	private function compute($saleId, $customerId, $productId) {
		$lastyear = date("Y-m-00",strtotime("-1 year"));
		$current = date("Y-m-00");
		$sql = <<<SQL
			SELECT MONTH(OrderDate) AS M, YEAR(OrderDate) AS Y,
			SUM(BuyLevel1) AS Qty1,
			SUM(BuyLevel2) AS Qty2,
			SUM(BuyLevel3) AS Qty3,
			SUM(BuyLevel4) AS Qty4
			FROM ProductOrder JOIN OrderDetail
			WHERE CustomerId = '$customerId' AND ProductId = '$productId'
			AND OrderDate >= '$lastyear' AND OrderDate < '$current'
			GROUP BY M, Y
			ORDER BY Y DESC, M DESC
SQL;
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$num = count($rawData);
		if ($num > 0) {
			
			$count = array();
			for ($i = 1; $i <= 12; $i++) {
				$key = date("Y-n", mktime(0, 0, 0, date("n")-$i, 1, date("Y"))); 
				$count[$key] = array("Qty1"=>0,"Qty2"=>0,"Qty3"=>0,"Qty4"=>0);
			}
			foreach ($rawData as $row) {
				$key = "$row[Y]-$row[M]";
				for ($i = 1; $i <= 4; $i++) {
					$k = "Qty$i";
					$count[$key][$k] = $row[$k];
				}
			}
			$avg = array("Qty1"=>0,"Qty2"=>0,"Qty3"=>0,"Qty4"=>0);

			$model = Product::model()->findByPk($productId);		
			$packs = array();
			for ($i = 1; $i <= 4; $i++) {
				$key = "PackLevel$i";
				$pack[$key] = $model->$key;
			}
			foreach ($count as $row) {
				for ($i = 1; $i <= 4; $i++) {
					$k = "Qty$i";
					$avg[$k] += $row[$k];
				}					
			}
			for ($i = 1; $i <= 4; $i++) {
				$k = "Qty$i";
				$avg[$k] /= $num;
			}
			$model = new SaleHistory;
			$model->SaleId = $saleId;
			$model->CustomerId = $customerId;
			$model->ProductId = $productId;
			$model->SaleAvg = Product::model()->formatQty($avg+$pack, "Qty");
			$i = 1;
			foreach ($count as $row) {
				$key = sprintf("M%02d", $i);
				$model->$key = Product::model()->formatQty($row+$pack, "Qty");
				$i++;
			}
			$model->UpdateAt = date("Y-m-d H:i:s");
			$model->save();
		}
	}
}
?>