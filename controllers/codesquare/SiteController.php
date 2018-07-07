<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/4
 * Time: 19:11
 */

namespace app\controllers\codesquare;
use app\common\context\UserContext;
use app\common\ErrorCode;
use app\common\utils\helper;
use app\common\utils\HttpHelper;
use app\common\weixin\AccessToken;
use app\models\cs\records\UserRecord;
use app\common\utils\CommonHelper;
use Yii;


/**
 * 代码广场首页
 * Class CSSiteControllerls
 * @package app\controllers
 */
class SiteController extends CSBaseController
{




    public  function actionIndex(){
        $token = isset($_GET['token'])?$_GET['token']:"";
        echo $token;die;
    }
     public function actionInfo(){
         if(isset($_GET['state'])){
             $tk = new AccessToken(134);
             $code = $_GET['code'];
             $token =  $tk->getAccessToken();
             $url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token={$token}&code=$code&agentid=134";
             $helper = new helper();
             $res = json_decode($helper->http_get($url)["content"]);
            if(empty($res->UserId)){
                return [];
            }
             $user = UserRecord::find()->where(['user_id'=>$res->UserId])->asArray()->One();
             if( empty($user) ){
                 $data =  $this->userInfo($token,$res->UserId);
                 $data->token = md5($data->user_id.time());
                 CommonHelper::response('ok',ErrorCode::$OK,$data->attributes);
             } else {
                  $user['token'] = md5($user['user_id'].time());
                  CommonHelper::response('ok',ErrorCode::$OK,$user);
             }

         }
     }

     public function actionCode(){
         if(empty($_GET['code'])){
             $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxfe3aa6c1dd22f053&redirect_uri=http://jkds.cracher.top/codesquare/site/code&response_type=code&scope=snsapi_userinfo&agentid=134&state=abcdefg#wechat_redirect";
             header('Location:'.$url);
         } else {
             $tk = new AccessToken(134);
             $code = $_GET['code'];
             $token =  $tk->getAccessToken();
             $data['code'] = $code;
             $data['access_token'] =$token;
             CommonHelper::response('ok',0,$data);
         }

     }

     public function actionGetUserInfo(){
         if(empty($_GET['code'])){
              $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxfe3aa6c1dd22f053&redirect_uri=http://jkds.cracher.top/codesquare/site/get-user-info&response_type=code&scope=snsapi_userinfo&agentid=134&state=abcdefg#wechat_redirect";
              header("location:".$url);
         }else{
             $cache = Yii::$app->cache;
             $tk = new AccessToken(134);
             $code = $_GET['code'];
             $access_token =  $tk->getAccessToken();
             $url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token={$access_token}&code=$code&agentid=134";
             $helper = new helper();
             $res = json_decode($helper->http_get($url)["content"]);
             if(empty($res->UserId)){
                 return [];
             }
             $user = UserRecord::find()->where(['user_id'=>$res->UserId])->One();
             if( empty($user) ){
                 $data =  $this->userInfo($access_token,$res->UserId);
                 $token = md5($data->user_id.time());
                 $this->setUserCache( $data->token,$data);
                 $url = "http://jkds.cracher.top/codesquare/site/index?token={$token}";
                 header('Location:'.$url);

             } else {
                 $token = md5($user->user_id.time());
                 $this->setUserCache( $token,$user);
                 $url = "http://jkds.cracher.top/codesquare/site/index?token={$token}";
                 header('Location:'.$url);
             }

         }

     }


     public function userInfo($token,$userId){
         $url = "https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token=$token&userid=$userId";
         $helper = new helper();
         $res = json_decode($helper->http_get($url)["content"]);
         $user = new UserRecord();
         $user->name = $res->name;
         $user->department = json_encode($res->department);
         $user->mobile = $res->mobile;
         $user->email = $res->email;
         $user->avatar = $res->avatar;
         $user->user_id =  $res->userid;
         $user->save();
         return $user;
     }

    /**
     * 设置用户缓存
     * @param $token
     * @param $user
     * @return bool
     */
    public function setUserCache($token,$user){
        $cache = Yii::$app->cache;
        $context = new UserContext();
        $context->userId = $user->user_id;
        $context->userName = $user->name;
        $context->mobile = $user->mobile;
        $context->avatar = $user->avatar;
        $context->email = $user->email;
        $context->department = $user->department;
        return   $cache->set($token,$user);

    }


}