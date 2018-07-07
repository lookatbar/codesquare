<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/3
 * Time: 20:01
 */

namespace app\controllers\codesquare;

use app\controllers\BaseController;


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
        // 如果是入口，不需要作校验，否则都需要 token 校验

        if(\Yii::$app->request->pathInfo == 'codesquare/site/index'){
            return ;
        }

        $user_id = \Yii::$app->request->post("user_id");
        if($user_id === NULL){
            $user_id = \Yii::$app->request->get('user_id');
        }

        if($user_id === NULL){
            $msg = json_encode($this->error('请重新进入'),TRUE);
            exit($msg);
        }

        //获取用户信息
        $this->userInfo = null;

    }
}