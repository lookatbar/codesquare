<?php
/**
 * Created by PhpStorm.
 * User: huangcf
 * Date: 2018/7/7
 * Time: 17:02
 */

namespace app\common\weixin;

use app\common\weixin\AccessToken;
use app\common\utils\helper;
use Yii;

class jssdk
{
    private $appId;
    private $accessToken;

    public function __construct($agentId) {
        $this->appId = Yii::$app->params['cop_id'];
        $this->accessToken = new AccessToken($agentId);
    }

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();
        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr  = helper::createNonceStr();

        //这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    /**
     * 获取jssdk票据
     * @return mixed
     */
    private function getJsApiTicket() {
        $accessToken = $this->accessToken->getAccessToken();
        echo $accessToken;die;
        $cache=Yii::$app->cache;
        $ticket = $cache->get('js_api_ticket');
        if(empty($ticket)){

            $accessToken = $this->accessToken->getAccessToken();
            echo $accessToken;die;
            $helper = new \app\common\utils\helper();
            $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $res = json_decode($helper->http_get($url)["content"]);
            $ticket = $res->ticket;
            if ($ticket) {

                $cache->set('js_api_ticket', $ticket, 7000);
            }
        }
        return $ticket;
    }
}