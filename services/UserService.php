<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 11:45
 */

namespace app\services;


use app\common\CSConstant;
use app\models\cs\FavoriteModel;
use app\models\cs\records\UserRecord;
use app\models\cs\ReplyModel;

/**
 * Class UserService    用户信息表
 * @package app\services
 */
class UserService
{

    /**
     * 获取用户信息
     * @param $userId
     *
     * @return null|array
     */
    public function getUserInfo($userId)
    {
        $data = UserRecord::findOne(['id' => $userId]);
        if(!empty($data)){
            $data = $data->toArray();
        }
        return $data;
    }

    /**
     * 收到回复列表
     * @param $userId
     * @param int $pageIndex
     * @param int $pageSize
     */
    public function getBeRepliedList($userId,$pageIndex=CSConstant::PAGE_INDEX,$pageSize=CSConstant::PAGE_SIZE){
        $replyModel = new ReplyModel();
        $ret = $replyModel->getBeRepliedListByUser($userId,$pageIndex,$pageSize);
        $list = $ret['data'];
        foreach ($list as &$val){
            $val['topic_type_name'] = $val['topic_type'];
            $val['topic_type'] = CSConstant::getTopicTypeByTopicTypeName($val['topic_type']);
        }
        $ret['data'] = $list;
        return $ret;
    }

    /**
     * 我的喜爱列表
     * @param $useId
     * @return array
     */
    public function  getFavList($useId){
        $favModel = new FavoriteModel();
        return $favModel->getFavList($useId);
    }




}