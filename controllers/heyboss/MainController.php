<?php
/**
 * Created by PhpStorm.
 * User: wangj01
 * Date: 2018/7/4
 * Time: 14:14
 */
namespace app\controllers\heyboss;

use app\controllers\BaseController;

/**
 * HeyBoss 首页
 * Class CSSiteController
 * @package app\controllers
 */
class MainController extends BaseController
{

    public function actionIndex(){
       return $this->response('hey boss');
    }

}