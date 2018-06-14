<?php
namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller{
	public function __construct(){
		parent :: __construct();
		$this->_init();
	}
	/**
	 * 初始化
	 * @return [type] [description]
	 */
	public function _init(){
		//微金
		define("APPID","wx1b74bb6c2de083d0");
		define("APPSECRET","12d5a6b10af98f5fc3cc539373964d4b");
		define("TOKEN","weijin");
		$access_token = D("Accesstoken")->getAccessToken();
		if($access_token){
			if($access_token[0]['out_time']>(time()+180)){
				//返回access_token
				define("ACCESS_TOKEN",$access_token[0]['access_token']);		
			}else{
				//更新access_token
				$id = $access_token[0]['id'];
				$data = $this->createAccessToken();
				$result = D('Accesstoken')->updateAccessToken($id,$data);
				define("ACCESS_TOKEN",$data['access_token']);
			}
		}else{
			//创建access_token
			$data = $this->createAccessToken();
			$result = D('Accesstoken')->addAccessToken($data);
			define("ACCESS_TOKEN",$data['access_token']);
		}
	}
	/**
	 * 创建access_token
	 * @return [type] [description]
	 */
	public function createAccessToken(){
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET;
		$result['create_time'] = time();
		$result['out_time'] = time()+7200;
		$data = $this->curl_data($url);
		$result['access_token'] = $data['access_token'];
		return $result;
	}
	/**
	 * curl获取数据
	 * @param  [type]  $url    [description]
	 * @param  boolean $method [description]
	 * @param  array   $data   [description]
	 * @return [type]          [description]
	 */
	public function curl_data($url=null,$method=false,$data=array()){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HEADER,false);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		if($method){
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		}
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		$data = curl_exec($ch);
		curl_close($ch);
		$data =json_decode($data,true);
		return $data;
	}
}