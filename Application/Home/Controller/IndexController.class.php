<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller{//CommonController {
    public function index(){
    	$this->init();
        $this->display();
    }
    /**
     * 初始化，客服列表
     * @return [type] [description]
     */
    public function init(){

		$url = "https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=".ACCESS_TOKEN;
		$data = $this->curl_data($url);
		if(count($data['kf_list'])>0){
			$this->assign('kefuList',$data['kf_list']);
		}else{
			$this->assign('kefuList',"");
		}  	
    }
    
}