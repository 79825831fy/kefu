<?php
namespace Home\Model;
use Think\Model;

class KefuModel extends Model{
	private $_db = "";
	public function __construct(){
		$this->_db = M("kefu");
	}
	//返回所有客服
	public function getKefu(){
		return $this->_db->where()->select();
	}
}