<?php
namespace Admin\Model;
use Think\Model;

class AccesstokenModel extends Model{
	private $_db = "";
	public function __construct(){
		$this->_db = M('access_token');
	}
	//获取access_token
	public function getAccessToken(){
		return $this->_db->where()->select();
	}
	//添加access_token
	public function addAccessToken($data=array()){
		return $this->_db->add($data);
	}
	//修改access_token
	public function updateAccessToken($id=null,$data=array()){
		return $this->_db->where("id=".$id)->save($data);
	}
}