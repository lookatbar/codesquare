<?php
/**
 * Created by PhpStorm.
 * User: huangcf
 * Date: 2018/7/8
 * Time: 0:02
 */

namespace app\models\cs;


use app\models\RecordBase;

class FavoriteModel extends  RecordBase
{
    /**
     * 重写读取表名方法
     * @return string
     */
    public static function tableName()
    {
        return 'cs_favorite';
    }

    /**
     * 获取我的收藏数量
     * @param $userId
     */
    public function getFavoriteCount($userId)
    {
        return FavoriteModel::find()->where(['user_id'=>$userId])->count();
    }

}