<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/4
 * Time: 19:11
 */

namespace app\controllers\codesquare;


/**
 * 代码广场首页
 * Class CSSiteController
 * @package app\controllers
 */
class SiteController extends CSBaseController
{

    public function actionIndex(){
        //echo "hello code square";

        $code =   $_GET['code'];
        $access_token = 'Ik3kDatzL4KOLSQz0BiyjbB6t9LhnMd9QSCPLfDwUfvzTj4Fn00saB5qTSYjv8Al5KbrKEmgwQX7pooO47bZ3w';
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token={$access_token}&code={$code}";
        $user = file_get_contents($url);
        var_dump($user);die;

       //获取用户信息
    //    $userInfoUrl = ""

        $this->redirect('/build/index.html?user_id=xxxx');
    }






}