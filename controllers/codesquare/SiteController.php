<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/4
 * Time: 19:11
 */

namespace app\controllers\codesquare;
use app\common\utils\helper;
use app\common\utils\HttpHelper;
use app\common\weixin\AccessToken;
use app\models\cs\records\UserRecord;
use Yii;


/**
 * 代码广场首页
 * Class CSSiteControllerls
 * @package app\controllers
 */
class SiteController extends CSBaseController
{




    public  function actionIndex(){


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
             $user = UserRecord::findOne(['user_id'=>$res->UserId])->toArray();
             if( empty($user) ){
                 return  $this->userInfo($token,$res->UserId);
             } else {
                 return json_encode($user);
             }

         }
     }

     public function actionGetUserInfo(){
         $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxfe3aa6c1dd22f053&redirect_uri=http://jkds.cracher.top/codesquare/site/info&response_type=code&scope=snsapi_userinfo&agentid=134&state=abcdefg#wechat_redirect";
         header("Location:".$url);
//         $helper = new helper();
//         $helper->http_get($url);
     }

//    public function actionGetUserInfo(){
//        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxfe3aa6c1dd22f053&redirect_uri=http://jkds.cracher.top/codesquare/site/info&response_type=code&scope=snsapi_userinfo&agentid=134&state=abcdefg#wechat_redirect";
//        header("Location:".$url);
//
//    }

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
         return $res;
     }
}