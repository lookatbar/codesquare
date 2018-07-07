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
    /**
     * 会话超时时间,单位秒
     */
    const SESSION_TIME_OUT = 7200;
        
    /**
     * 当前用户上下文
     * @var \app\common\context\UserContext
     */
    protected $userContext = null;
    
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
           return false;
        }
        
        // 检查token
        $cache = \Yii::$app->cache;
        $token = $this->getToken();
        if (!$token || !$cache->exists($token)) {
            \Yii::$app->response->data = $this->error('token无效', \app\common\ErrorCode::$InvalidToken, $token);
            \Yii::$app->end();
        }
        
        // 初始化用户上下文对象并刷新token有效期
        $userContext = $cache->get($token);
        if ($userContext !== false) {
           $this->userContext = $userContext;
           $cache->set($token, $userContext, static::SESSION_TIME_OUT);
        }
        
        return true;
    }
    
    /**
     * 获取token值
     * @return string
     */
    protected function getToken()
    {
        return \Yii::$app->request->post('token');
    }
}
