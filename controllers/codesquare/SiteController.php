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

        echo $_GET['code'];

    }

}