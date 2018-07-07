<?php

namespace app\common;
/**
 * 定义各种场景类型
 * User: zhugm
 *
 */
class CSConstant
{
    /**
     * 系统管理员用户ID
     */
    const SYS_ADMIN_ID = 1;

    /**
     * 打赏-话题
     */
    const SCENE_TYPE__REWARD_TOPIC = 1;

    /**
     * 打赏-话题回复
     */
    const SCENE_TYPE__REWARD_TOPIC_REPLY = 2;

    /**
     * 打赏-话题悬赏榜
     */
    const SCENE_TYPE_REWARD_TOPIC_OFFER_AWARD = 3;

    /**
     * 打赏-每日任务（官方打赏）
     */
    const SCENE_TYPE_REWARD_TASK = 4;


    /**
     * 点赞-话题
     */
    const SCENE_TYPE__LIKE_TOPIC = 101;

    /**
     * 点赞-话题回复
     */
    const SCENE_TYPE__LIKE_TOPIC_REPLY = 102;

    /**
     * 统计-话题
     */
    const SCENE_TYPE__STAT_TOPIC = 201;

    /**
     * 统计-话题回复
     */
    const SCENE_TYPE__STAT_TOPIC_REPLY = 202;


    /**
     * 悬赏-话题
     */
    const SCENE_TYPE__OFFER_AWARD_TOPIC = 301;


    /**
     * 收支明细-悬赏
     */
    const SCENE_TYPE__PAYMENT_REAWARD = 401;


    /**
     * 财富类型（奖品类型）
     */
    const WEALTH_TYPE__MB = 1;

    /**
     * 任务类型-回复
     */
    const TASK_TYPE__REPLY = 1;

    /**
     * 任务类型-点赞
     */
    const TASK_TYPE__LIKE = 2;


    const TOPIC_TYPE_PROD = 1;

    const TOPIC_TYPE_DEV = 2;

    const PAGE_SIZE = 10;

    const PAGE_INDEX = 1;

    const RANK_TYPE__OFFER_AWARD = 'offer_award';

    const  RANK_TYPE__REWARD    = 'reward';

    static $TopicTypeList = [
        ['topic_type' => self::TOPIC_TYPE_PROD, 'topic_type_name' => '技术'],
        ['topic_type' => self::TOPIC_TYPE_DEV, 'topic_type_name' => '点子']
    ];

    public static function getTopicTypes()
    {
        return static::$TopicTypeList;

    }

    public static function getTopicTypeByTopicTypeName($topTypeName){
        foreach (static::$TopicTypeList as $val){
            if ($val['topic_type_name'] == $topTypeName){
                return $val['topic_type'];
            }
        }
        return NULL;
    }




}