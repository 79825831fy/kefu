<?php
namespace Admin\Controller;
use Think\Controller;

class KefuController extends CommonController{
	/**
	 * 获取客服列表
	 * @return [type] [description]
	 */
	public function getKefu(){
		$url = "https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=".ACCESS_TOKEN;
		$data = $this->curl_data($url);
		if(count($data['kf_list'])>0){
			echo json_encode($data);
		}else{
			echo json_encode(array('error'=>'fail','message' =>"没有客服信息"));
		}
	}
	/**
	 * 添加客服
	 */
	public function addKefu(){
		$data = file_get_contents("php://input");
		$url = "https://api.weixin.qq.com/customservice/kfaccount/add?access_token=".ACCESS_TOKEN;
		$method = true;
		$result = $this->curl_data($url,$method,$data);
		echo json_encode($result);
	}

	/**
	 * 绑定客服
	 */
	public function bindKefu(){
		$data = file_get_contents("php://input");
		$url = "https://api.weixin.qq.com/customservice/kfaccount/inviteworker?access_token=".ACCESS_TOKEN;
		$method = true;
		$result = $this->curl_data($url,$method,$data);
		echo json_encode($result);
	}

	/**
	 * 修改客服
	 */
	public function updateKefu(){
		$data = file_get_contents("php://input");
		$url = "https://api.weixin.qq.com/customservice/kfaccount/update?access_token=".ACCESS_TOKEN;
		$method = true;
		$result = $this->curl_data($url,$method,$data);
		echo json_encode($result);
	}

	/**
	 * 删除客服
	 */
	public function delKefu(){
		$data = file_get_contents("php://input");
		$data = json_decode($data,true);
		$url = "https://api.weixin.qq.com/customservice/kfaccount/del?access_token=".ACCESS_TOKEN."&kf_account=".$data['kf_account'];
		$result = $this->curl_data($url);
		echo json_encode($result);
	}
	public function responseMsg(){
		
	}
}