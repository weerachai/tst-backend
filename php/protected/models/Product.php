<?php

Yii::import('application.models._base.BaseProduct');

class Product extends BaseProduct
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'ProductId'),
			'exchangeInDetails' => array(self::HAS_MANY, 'ExchangeInDetail', 'ProductId'),
			'exchangeOutDetails' => array(self::HAS_MANY, 'ExchangeOutDetail', 'ProductId'),
			'requestDetails' => array(self::HAS_MANY, 'RequestDetail', 'ProductId'),
			'deliverDetails' => array(self::HAS_MANY, 'DeliverDetail', 'ProductId'),
			'transferDetails' => array(self::HAS_MANY, 'TransferDetail', 'ProductId'),
			'stocks' => array(self::HAS_MANY, 'Stock', 'ProductId'),
		);
	}

	public static function getOptions($grp1='%',$grp2='%',$grp3='%') {
		return CHtml::listData(Product::model()->findAll('GrpLevel1Id LIKE ? AND GrpLevel2Id LIKE ? AND GrpLevel3Id LIKE ?',array($grp1,$grp2,$grp3)), 
				'ProductId', 'ProductName'
			);
	}

	public static function getGroupLevel1() {
		$data = GrpLevel1::model()->findAll(array(
				'select'=>'GrpLevel1Id, GrpLevel1Name',
				'distinct'=>true
				));
		return CHtml::listData($data,'GrpLevel1Id','GrpLevel1Name');
	}

	public static function getGroupLevel2($grp1='%') {
		$data = GrpLevel2::model()->findAll(array(
				'condition'=>"GrpLevel1Id LIKE '$grp1'",
				'select'=>'GrpLevel2Id, GrpLevel2Name',
				'distinct'=>true
				));
		return CHtml::listData($data,'GrpLevel2Id','GrpLevel2Name');
	}

	public static function getGroupLevel3($grp2='%') {
		$data = GrpLevel3::model()->findAll(array(
				'condition'=>"GrpLevel2Id LIKE '$grp2'",
				'select'=>'GrpLevel3Id, GrpLevel3Name',
				'distinct'=>true
				));
		return CHtml::listData($data,'GrpLevel3Id','GrpLevel3Name');
	}

	public static function getPacks($proId='%') {
		$data = Product::model()->findAll(array(
				'condition'=>"ProductId LIKE '$proId'",
				'select'=>'PackLevel1',
				'distinct'=>true,
				'condition'=>'PackLevel1 IS NOT NULL AND length(trim(PackLevel1)) > 0'
				));
		$list = CHtml::listData($data,'PackLevel1','PackLevel1');

		$data = Product::model()->findAll(array(
				'condition'=>"ProductId LIKE '$proId'",
				'select'=>'PackLevel2',
				'distinct'=>true,
				'condition'=>'PackLevel2 IS NOT NULL AND length(trim(PackLevel2)) > 0'
				));
		$list = array_merge($list,CHtml::listData($data,'PackLevel2','PackLevel2'));

		$data = Product::model()->findAll(array(
				'condition'=>"ProductId LIKE '$proId'",
				'select'=>'PackLevel3',
				'distinct'=>true,
				'condition'=>'PackLevel3 IS NOT NULL AND length(trim(PackLevel3)) > 0'
				));
		$list = array_merge($list,CHtml::listData($data,'PackLevel3','PackLevel3'));

		$data = Product::model()->findAll(array(
				'condition'=>"ProductId LIKE '$proId'",
				'select'=>'PackLevel4',
				'distinct'=>true,
				'condition'=>'PackLevel4 IS NOT NULL AND length(trim(PackLevel4)) > 0'
				));
		return array_merge($list,CHtml::listData($data,'PackLevel4','PackLevel4'));
	}

	public static function formatQty($data,$name) {
		$qty = '';
		if ($data[$name.'1'] > 0)
			$qty = empty($qty) ? $data[$name.'1'].' '.$data['PackLevel1'] :  $qty.' '.$data[$name.'1'].' '.$data['PackLevel1'];
		if ($data[$name.'2'] > 0)
			$qty = empty($qty) ? $data[$name.'2'].' '.$data['PackLevel2'] :  $qty.' '.$data[$name.'2'].' '.$data['PackLevel2'];
		if ($data[$name.'3'] > 0)
			$qty = empty($qty) ? $data[$name.'3'].' '.$data['PackLevel3'] :  $qty.' '.$data[$name.'3'].' '.$data['PackLevel3'];
		if ($data[$name.'4'] > 0)
			$qty = empty($qty) ? $data[$name.'4'].' '.$data['PackLevel4'] :  $qty.' '.$data[$name.'4'].' '.$data['PackLevel4'];
		if (empty($qty))
			$qty = '-';
		return $qty;
	}

	public static function getQtyOptions($max, $pack) {
		$qty = array(0=>'-');
		if (empty($pack))
			return $qty;
		for ($i = 1; $i <= $max; $i++)
			$qty += array($i=>"$i $pack");
		return $qty;

	}

	public function getPacksList() {
		$packs = array();
		if (!empty($this->PackLevel1))
			$packs[$this->PackLevel1] = $this->PackLevel1;
		if (!empty($this->PackLevel2))
			$packs[$this->PackLevel2] = $this->PackLevel2;
		if (!empty($this->PackLevel3))
			$packs[$this->PackLevel3] = $this->PackLevel3;
		if (!empty($this->PackLevel4))
			$packs[$this->PackLevel4] = $this->PackLevel4;
		return $packs;
	}
}