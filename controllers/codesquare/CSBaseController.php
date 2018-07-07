<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/3
 * Time: 20:01
 */

namespace app\controllers\codesquare;

use app\common\context\UserContext;
use app\common\CSConstant;
use app\common\weixin\WxService;
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

    protected $pageSize = CSConstant::PAGE_SIZE;
    protected $pageIndex  = CSConstant::PAGE_INDEX;
    
    public function beforeAction($action)
    {

        $this->pageIndex    = \Yii::$app->request->post('page_index',CSConstant::PAGE_INDEX);
        $this->pageSize     = \Yii::$app->request->post('page_size',CSConstant::PAGE_SIZE);
        if (!parent::beforeAction($action)) {
           return false;
        }

//        $userContext = new UserContext();
//        $userContext->userId = 2;
//        $userContext->userName = "测试";
//
//        $this->userContext = $userContext;
//        return true;
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


    /**
     * 获取本地图片地址
     * @param $imageList
     */
    protected function getLocalImageList($wxMediaListJsonStr){
        $wxMediaList = [];
        if(!empty($wxMediaListJsonStr)){
            $wxMediaList = json_decode($wxMediaListJsonStr,TRUE);
        }
        $localImageList = [];
        $wxService = new WxService();
        foreach ($wxMediaList as $wxMediaId){
            $localImagePath =$wxService->getFile($wxMediaId);
            if(!empty($localImagePath)){
                $localImageList[] = $localImagePath;
            }
        }
        return $localImageList;
    }


}
