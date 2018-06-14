<?php
namespace Admin\Model;
use Think\Model;

class KefuModel extends Model{
	private $_db = "";
	public function __construct(){
		$this->_db = M('wyrecommendinfo');
	}
	//查询粉丝关联的客服
	public function getKefu($user=null){
		return $this->_db->where('recommendingopenid = "'.$user.'"')->find();
	}
}