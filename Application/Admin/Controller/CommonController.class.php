<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller{

	public function __construct(){
		parent::__construct();
		$this->_init();
	}
	/**
	 * 初始化
	 * @return [type] [description]
	 */
	public function _init(){
		/*//测试号
		define("APPID","wxf946b4b27507f208");
		define("APPSECRET","838cddabbaafcb5778cddc0c4997b963");*/

		
		//微金
		define("APPID","wx1b74bb6c2de083d0");
		define("APPSECRET","12d5a6b10af98f5fc3cc539373964d4b");
		
		define("TOKEN","weijin");
		define("KEFU","@gh_18c688b2fdbf");
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
		$this->addButton();
		$this->valid();
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
	 * 添加公众号菜单
	 */
	public function addButton(){
		$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN;
		$data = '{
			"button":[{
				"name":"进入首页",
				"type":"view",
				"url":"http://crm.infomarket.cn/sdsxuanshangarticle/public/fenxiao/fenxiao/firstpage"
			},
			{
				"name":"征信助手",
				"type":"view",
				"url":"https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzUyNjgzNDM2MQ==#wechat_redirect"
			}]
		}';
		
		$result = $this->curl_data($url,true,$data);
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
	/**
	 * 微信消息验证
	 * @return [type] [description]
	 */
	public function valid(){
		$echoStr = $_GET['echostr'];
		if($echoStr){
			if($this->signature()){
				echo $echoStr;
				exit;
			}
		}else{
			$this->responseMsg();
		}
	}
	/**
	 * 微信签名验证
	 * @return [type] [description]
	 */
	public function signature(){
		//微信加密签名
		$signature = $_GET['signature'];
		$timestamp = $_GET['timestamp'];
		$nonce = $_GET['nonce'];
		$token = TOKEN;
		$tmpArr = array($token,$timestamp,$nonce);
		sort($tmpArr,SORT_STRING);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1($tmpStr);
		if($tmpStr == $signature){
			return true;
		}else{
			return false;
		}
	}
}