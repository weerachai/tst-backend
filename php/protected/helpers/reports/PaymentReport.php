<?php
class PaymentReport extends MyReport {

  	public function create($ids, $from_date, $to_date, $format) {
  		$title = 'รายการเช็ค';
		$header = array('เลขที่เช็ค',
        	'วันที่', 
        	'ธนาคาร',
        	'สาขา',
        	'จำนวน');
		$w = array(13, 10, 10, 10, 10);
		$align = array('L','L','L','L','R');
		$idlist = implode("','",$ids);
 		$sql = <<<SQL
		SELECT DocNo, DocDate, P.PaidAmount, Bank, Branch
		FROM Payment P JOIN BillCollection USING(CollectionNo)
  		WHERE PaymentType = 'เช็ค'
  		AND DocDate >= '$from_date' AND DocDate <= '$to_date' 
  		AND SaleId IN ('$idlist')
		ORDER BY DocDate, PaymentId
SQL;

		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$data = array();
		foreach ($rawData as $row) {
			$datetime = new DateTime($row['DocDate']);
			$data[] = array(
				$row['DocNo'],
				$this->thaidate->format("j M y",$datetime->getTimestamp()),
				$row['Bank'],
				$row['Branch'],
				number_format($row['PaidAmount'],2),
			);   
		}

		$objPHPExcel = $this->getPHPExcel();
		$this->writeSheet($objPHPExcel, 0, $title, $title, $header, $w, $align, $data);

  		$title = 'รายการ CN';
		$header = array('เลขที่',
        	'วันที่', 
        	'จำนวน');
		$w = array(13, 10, 10);
		$align = array('L','L','R');
		$idlist = implode("','",$ids);
 		$sql = <<<SQL
		SELECT DocNo, DocDate, P.PaidAmount
		FROM Payment P JOIN BillCollection USING(CollectionNo)
  		WHERE PaymentType = 'CN'
  		AND DocDate >= '$from_date' AND DocDate <= '$to_date' 
  		AND SaleId IN ('$idlist')
		ORDER BY DocDate, PaymentId
SQL;

		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$data = array();
		foreach ($rawData as $row) {
			$datetime = new DateTime($row['DocDate']);
			$data[] = array(
				$row['DocNo'],
				$this->thaidate->format("j M y",$datetime->getTimestamp()),
				number_format($row['PaidAmount'],2),
			);   
		}

		$objPHPExcel->createSheet();
		$this->writeSheet($objPHPExcel, 1, $title, $title, $header, $w, $align, $data);

  		$title = 'รายการโอนเงิน';
		$header = array('วันที่', 
        	'ธนาคาร',
        	'สาขา',
        	'เลขที่บัญชี',
        	'จำนวน');
		$w = array(13, 10, 10, 10, 10);
		$align = array('L','L','L','L','R');
		$idlist = implode("','",$ids);
 		$sql = <<<SQL
		SELECT AccountNo, DocDate, P.PaidAmount, Bank, Branch
		FROM Payment P JOIN BillCollection USING(CollectionNo)
  		WHERE PaymentType = 'โอนเงินสด'
  		AND DocDate >= '$from_date' AND DocDate <= '$to_date' 
  		AND SaleId IN ('$idlist')
		ORDER BY DocDate, PaymentId
SQL;

		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$data = array();
		foreach ($rawData as $row) {
			$datetime = new DateTime($row['DocDate']);
			$data[] = array(
				$this->thaidate->format("j M y",$datetime->getTimestamp()),
				$row['Bank'],
				$row['Branch'],
				$row['AccountNo'],
				number_format($row['PaidAmount'],2),
			);   
		}

		$objPHPExcel->createSheet();
		$this->writeSheet($objPHPExcel, 2, $title, $title, $header, $w, $align, $data);
		
		$this->output($objPHPExcel, $format, "PaymentReport");
		Yii::app()->end();
  	}
}
?>