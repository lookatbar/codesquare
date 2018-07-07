<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 11:45
 */

namespace app\services;


use app\models\cs\records\UserRecord;

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

}