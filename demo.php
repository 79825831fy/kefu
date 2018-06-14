<?php

$kefu = new Kefu();
$kefu->kefuList();

class Kefu{
	/**
     * 客服列表
     * @return [type] [description]
     */
    public function kefuList(){
    	$url = "http://crm.infomarket.cn/kfdemo/admin/kefu/getkefu";
    	$data = $this->curl_data($url);
    	var_dump($data);
    }
    /**
     * 添加客服
     * @return [type] [description]
     */
    public function addKefu(){
    	$url = "http://crm.infomarket.cn/kfdemo/admin/kefu/addKefu";
    	$data = '{
			      "kf_account" : "gejing@gh_18c688b2fdbf",
			      "nickname" : "客服1"
			   }';
		$method = true;
		$result = $this->curl_data($url,$method,$data);
		var_dump($result);
    }
    /**
     * 绑定客服
     * @return [type] [description]
     */
    public function bindKefu(){
    	$url = "http://crm.infomarket.cn/kfdemo/admin/kefu/bindKefu";
    	$data = '{
			      "kf_account" : "gejing@gh_18c688b2fdbf",
			      "invite_wx" : "guisu_007"
			   }';
		$method = true;
		$result = $this->curl_data($url,$method,$data);
		var_dump($result);
    }
    /**
     * 删除客服
     * @return [type] [description]
     */
    public function delKefu(){
    	$url = "http://crm.infomarket.cn/kfdemo/admin/kefu/delKefu";
    	$method = true;
    	$data = '{"kf_account":"kf2008@gh_18c688b2fdbf"}';
    	$result = $this->curl_data($url,$method,$data);
		var_dump($result);
    }

    /**
     * 修改客服信息
     * @return [type] [description]
     */
    public function updateKefu(){
    	$url = "http://crm.infomarket.cn/kfdemo/admin/kefu/updatekefu";
    	$data = '{
			    	"kf_account" : "gejing@gh_18c688b2fdbf",
			    	"nickname" : "葛晶"
			    }';
		$method = true;
		$result = $this->curl_data($url,$method,$data);
		var_dump($result);
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
