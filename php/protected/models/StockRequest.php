<?php

Yii::import('application.models._base.BaseStockRequest');

class StockRequest extends BaseStockRequest
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'requestDetails' => array(self::HAS_MANY, 'RequestDetail', 'RequestNo'),
			'deliver' => array(self::HAS_ONE, 'StockDeliver', 'RequestNo'),
			'receive' => array(self::HAS_ONE, 'StockReceive', 'RequestNo'),
			'requestIR' => array(self::HAS_ONE, 'RequestIR', 'RequestNo'),
		);
	}

	public function updateTotal() {
		$total = 0;
		foreach ($this->requestDetails as $detail) {
			$total += $detail->QtyLevel1 * $detail->PriceLevel1;
			$total += $detail->QtyLevel2 * $detail->PriceLevel2;
			$total += $detail->QtyLevel3 * $detail->PriceLevel3;
			$total += $detail->QtyLevel4 * $detail->PriceLevel4;
		}
		$this->Total = $total;
	}
	
	public static function canConfirm($id) {
		$model = StockRequest::model()->findByPk($id);
		return (!empty($model->requestDetails) && empty($model->UpdateAt));
	}
	private $id;
}