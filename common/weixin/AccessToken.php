<?php
/**
 * Created by PhpStorm.
 * User: huangcf
 * Date: 2018/7/6
 * Time: 16:19
 */
namespace app\common\weixin;
use app\common\utils\helper;
use Yii;

class AccessToken {
    private $corpId;
    private $secret;
    private $agentId;
    private $appConfigs;
    private $helper;
    /**
     * AccessToken构造器
     * @param [Number] $agentId 两种情况：1是传入字符串“txl”表示获取通讯录应用的Secret；2是传入应用的agentId
     */
    public function __construct($agentId) {
//        $this->appConfigs = loadConfig();
        $this->corpId = Yii::$app->params['cop_id'];
        $this->secret = Yii::$app->params['cop_secret'];
        $this->agentId = 134;


        //由于通讯录是特殊的应用，需要单独处理
        if($agentId == "txl"){
            $this->secret = $this->appConfigs->TxlSecret;
        }else{
//            $config = getConfigByAgentId($agentId);
//
//            if($config){
//                $this->secret = $config->Secret;
//            }
        }
    }

    public function getAccessToken() {
         $cache=Yii::$app->cache;
         $access_token = $cache->get('token');
        if( empty($access_token) ) {
            $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->corpId&corpsecret=$this->secret";
            $helper = new helper();
            $res = json_decode($helper->http_get($url)["content"]);
            $cache->set('token',$res->access_token, 7000);
            $access_token = $res->access_token;
        }
        return $access_token;
    }

    public function getCode(){
        $redirect_uri = Yii::$app->params['app_index'];
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->corpId&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&agentid=$this->agentId&state=abcdefg#wechat_redirect";
        return $url;
    }

}