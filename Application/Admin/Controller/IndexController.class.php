<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        
    }
    public function responseMsg(){
		$postStr = file_get_contents("php://input");
		//判断是否接收信息
		if(!empty($postStr)){
			libxml_disable_entity_loader(true);
			$postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			define("OPENID",$fromUsername);
			$keyword = $postObj->Content;
			$event = $postObj->MsgType;
			$time = time();
			$textTpl="<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>0</FuncFlag>
			</xml>";
			switch ($event) {
				case 'event':
					if($postObj->Event == "subscribe"){
						$msgType = "text";
						$contentStr = '微金易家--在线银行导航专家
办理信用卡、小额贷款咨询、支付清算咨询、征信查询、提额咨询、账单管理等相关金融咨询业务！

点击进入以下功能：
<a href="http://crm.infomarket.cn/sdsxuanshangarticle/public/fenxiao/fenxiao/firstpage">进入首页>>></a>
<a href="http://crm.infomarket.cn/sdsxuanshangarticle/public/fenxiao/fenxiao/xinyongcard">申请信用卡>>></a>';
					}
					break;
				case 'text':
					$msgType = "text";
					if($keyword == "您好" || $keyword == "你好" || $keyword == "客服" ){
						$this->response($fromUsername,"客服转接中，请稍后！");
						//$kfaccount = $this->jumpKf($fromUsername);
						$kefuTpl="<xml>
						    <ToUserName><![CDATA[%s]]></ToUserName>
						    <FromUserName><![CDATA[%s]]></FromUserName>
						    <CreateTime>%s</CreateTime>
						    <MsgType><![CDATA[transfer_customer_service]]></MsgType>
							<TransInfo>
						        <KfAccount><![CDATA[%s]]></KfAccount>
						    </TransInfo>
					 	</xml>";
						$contentStr = sprintf($kefuTpl,$fromUsername,$toUsername,$time,$kfaccount.KEFU);
						echo $contentStr;
						
					}else{
	            		$contentStr = "你好，小编看到您的信息会第一时间回复，不要着急哟！";		
					}
					break;
				default:
					break;
			}
			$resultStr = sprintf($textTpl,$fromUsername,$toUsername,$time,$msgType,$contentStr);
			echo $resultStr;
		}else{
			echo "";
			exit;
		}
	}
	/**
	 * 客服接通中返回信息
	 * @param  [type] $openid [description]
	 * @param  [type] $msg    [description]
	 * @return [type]         [description]
	 */
	public function response($openid=null,$msg=null){
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".ACCESS_TOKEN;
		$method = true;
		$data = '{
		    "touser":"'.$openid.'",
		    "msgtype":"text",
		    "text":
		    {
		         "content":"'.$msg.'"
		    }
		}';
		$result = $this->curl_data($url,$method,$data);
	}
	 
	/**
	 * 关联销售的客服账号
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	public function jumpKf($user){
		$result = D("Kefu")->getKefu($user);
		if($result){
			if($result['kefuzhanghao']){
				return $result['kefuzhanghao'];
			}
		}
	}
}