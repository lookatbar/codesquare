<?php
/**
 * 用户模块控制器
 */

namespace app\controllers\codesquare;


use app\common\ErrorCode;
use app\common\utils\CommonHelper;
use app\models\cs\records\UserRecord;

class UserController extends CSBaseController
{

    /**
     * 用户个人中心
     */
    public function actionIndex(){

    }


    public function actionMsgList(){

    }

    /**
     * 收到恢复
     */
    public function actionBeRepliedList(){

    }

    /**
     * 收到点赞
     */
    public function actionBeLikedList(){

    }

    /**
     * 收到的打赏
     */
    public function actionBeRewardList(){

    }

    /**
     * 收支明细
     */
    public function actionPaymentsList(){

    }

    /**
     * 发送的话题列表
     */
    public function actionTopicList(){

    }

    /**
     * 通讯录功能
     */
    public function actionAddressList(){
        $page_size = isset($_GET['page_size'])?$_GET['page_size']:20;
        $page_index = isset($_GET['page_index'])?$_GET['page_index']:1;
        $user =  new UserRecord();
        $list = $user->find()->select('user_id,name')->offset($page_size*$page_index)
            ->limit($page_size)->asArray()->all();
        CommonHelper::response("ok",ErrorCode::$OK,$list);
    }


}