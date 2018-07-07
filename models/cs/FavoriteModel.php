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
        return FavoriteModel::find()->where(['user_id'=>$userId,'is_deleted'=>0])->count();
    }


    public function getFavList($userId){
        if(empty($userId)){
           return [];
        }

        $fields = ' cs_favorite.favorite_id,
                    cs_favorite.topic_id,
                    cs_topic.title,
                    cs_user. name AS user_name,
                    cs_topic.view_count,
                    cs_topic.good_count,
                    cs_topic.reply_count,
                    cs_topic.offer_award_id,
                    cs_topic.reward_money,
                    cs_offer_award.max_amount AS offer_award_max_amount,
                    cs_offer_award.title AS offer_award_title';
        $limitSql = "
           SELECT 
              $fields
            FROM
                cs_favorite
            LEFT JOIN cs_topic ON cs_favorite.topic_id = cs_topic.topic_id
            LEFT JOIN cs_user ON cs_favorite.user_id = cs_user.user_id
            LEFT JOIN cs_offer_award ON cs_offer_award.offer_award_id = cs_topic.offer_award_id
            WHERE
                cs_favorite.is_deleted = 0
            AND cs_topic.is_deleted = 0
            AND cs_favorite.user_id = 'zhugm'
            ORDER BY
                cs_favorite.update_time DESC ";

        $where = " cs_favorite.is_deleted = 0 AND cs_topic.is_deleted = 0 AND cs_favorite.user_id = '$userId'";
        $limitSql = str_replace('1=1',$where,$limitSql);
        $list = $this->db->createCommand($limitSql)->query()->readAll();

        return $list;


    }





}