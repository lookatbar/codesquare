<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/3
 * Time: 20:01
 */

namespace app\controllers;


use yii\web\Controller;

/**
 * 代码广场基础类
 * Class CSBaseController
 * @package app\controllers
 */
class CSBaseController extends BaseController
{

    protected $userInfo = NULL;

    public function init()
    {
        //校验并且初始化用户数据

    }
}