<?php
class myMD5 {
	private $salt;
	public function __construct() {
		$this->salt = '8A5XTHO7rJ&Yc#jchrpQZj0$d-mUcVKpVsVfS$@cEVXfOBU1o5_nnG3cg)Gj8)DY';
	}
	public function hash($input) {
		return md5($input.$this->salt);
	}
	public function verify($input, $existingHash) {
		return $this->hash($input) == $existingHash;
	}
}
?>