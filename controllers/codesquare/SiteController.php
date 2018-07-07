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
use Yii;


/**
 * 代码广场首页:q
 * Class CSSiteControllerls
 * @package app\controllers
 */
class SiteController extends CSBaseController
{

//    public function actionIndex1(){
//
//        $tk = new AccessToken(134);
//        //echo "hello code square";
//        echo $tk->getCode();echo $_GET['code'];die;
//        if(isset($_GET['state'])){
//
//            $code =   $_GET['code'];
//            $access_token = 'zdd-Q8IkhpdiCVh8g3txxfVt-rOn-zQhBP0yJqI3ps8diBkZBPXbfppTqjoxoyu5w7xM-coph1OT36FC8BG4rw';
//            $url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token={$access_token}&code={$code}";
//            urlencode($code);
//        }
//    }


<<<<<<< HEAD
       //获取用户信息
    //    $userInfoUrl = ""

        $this->redirect('/build/index.html?user_id=xxxx');
    }






=======
    public  function actionIndex(){



        $tk = new AccessToken(134);
        $token = $tk->getAccessToken();
        echo $token;die;
//        $tk->getCode();
        if(isset($_GET['state'])){

            $code = $_GET['code'];
            $token = $tk->getAccessToken();


//            $tk->getUserInfo($token,$code);die;

            $url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token={$token}&code=$code&agentid=134";
            header("Location:".$url);

//            urlencode($code);
        }
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
            return  $this->userInfo($token,$res->UserId);
         }
     }

     public function actionGetUserInfo(){
         $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxfe3aa6c1dd22f053&redirect_uri=http://jkds.cracher.top/codesquare/site/info&response_type=code&scope=snsapi_userinfo&agentid=134&state=abcdefg#wechat_redirect";
         header("Location:".$url);
     }

     public function userInfo($token,$userId){
         $url = "https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token=$token&userid=$userId";
         $helper = new helper();
         $res = json_decode($helper->http_get($url)["content"]);
         return $res;
     }
>>>>>>> c6559679373b032a7ea5d87d8ed980c3ceab7aae
}