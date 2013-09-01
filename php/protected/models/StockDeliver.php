<?php

Yii::import('application.models._base.BaseStockDeliver');

class StockDeliver extends BaseStockDeliver
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'deliverDetails' => array(self::HAS_MANY, 'DeliverDetail', 'DeliverNo'),
			'request' => array(self::BELONGS_TO, 'StockRequest', 'RequestNo'),
			'receive' => array(self::HAS_ONE, 'StockReceive', 'DeliverNo'),
		);
	}

	public function updateTotal() {
		$total = 0;
		foreach ($this->deliverDetails as $detail) {
			$total += $detail->QtyLevel1 * $detail->PriceLevel1;
			$total += $detail->QtyLevel2 * $detail->PriceLevel2;
			$total += $detail->QtyLevel3 * $detail->PriceLevel3;
			$total += $detail->QtyLevel4 * $detail->PriceLevel4;
		}
		$this->Total = $total;
	}
}