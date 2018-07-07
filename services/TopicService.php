<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 11:30
 */

namespace app\services;

use app\common\CSConstant;
use app\models\cs\forms\TopicSaveRequestFrom;
use app\models\cs\GoodModel;
use app\models\cs\records\TopicRecord;
use app\models\cs\records\UserRecord;

/**
 * Class TopicService  话题服务类
 * @package app\services
 */
class TopicService extends CSServiceBase
{
    /**
     * 回复
     * @param int $topicId
     * @param string $content
     * @param array $images
     */
    public function reply($topicId, $content, $images = [])
    {

    }

    /**
     * 点赞
     * @param int $topicId
     * @param string $userId
     */
    public function like($topicId, $userId, $userName)
    {
        $lockKey = 'topic_like_lock';
        $goodModel = new \app\models\cs\GoodModel();
        // 检查锁
        $cache = \yii::$app->cache;
        while (true) {
            $isLock = $cache->exists($lockKey);
            if ($isLock) {
                continue;
            }
            try {
                // 加锁
                $cache->set($lockKey, $userId, 60);
                $users = $goodModel->getUserList($topicId);
                if (!array_key_exists($userId, $users)) {
                    $users[$userId] = ['name' => $userName];
                    $goodModel->saveUserList($topicId, $users);
                }
                break;
            } finally {
                $cache->exists($lockKey) && $cache->delete($lockKey);
            }
        }
    }

    /**
     * 采纳回复
     * @param type $topicId
     * @param type $replyId
     */
    public function accept($topicId, $replyId)
    {

    }

    /**
     * 提交话题
     * @param TopicSaveRequestFrom $form
     * @return int
     */
    public function sumbitTopic(TopicSaveRequestFrom $form)
    {
        //$form->setScenario(TopicSaveRequestFrom::SCENARIO_SUBMIT);
        $record = new TopicRecord();

        $record['title'] = $form->title;
        $record['content'] = $form->content;
        $record['user_id'] = $form->user_id;
        $record['images_list'] = empty($form->images_list) ? json_encode([], true) : $form->images_list;
        $record['topic_type'] = $form->topic_type;
        $record->save();
        return $record['topic_id'];
    }

    /**
     * 查询话题列表
     * @param null $topicType
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     */
    public function queryTopList($topicType = NULL, $pageIndex = CSConstant::PAGE_INDEX, $pageSize = CSConstant::PAGE_SIZE)
    {

        $record = new TopicRecord();
        $ret = $record->queryTopicList($topicType, $pageIndex, $pageSize);
        $list = $ret['data'];
        foreach ($list as $key => &$val) {
            $val['topic_type'] = CSConstant::getTopicTypeByTopicTypeName($val['topic_type']);
        }
        $ret['data'] = $list;
        return $ret;
    }

    public function getTopicDetail($topicId)
    {
        $topicData = TopicRecord::findOne(['topic_id' => $topicId,'is_deleted'=>0]);
        if (empty($topicData)) {
            return [];
        }
        $topicData = $topicData->toArray();
        $topicData['user_name'] = '';
        $topicData['user_avatar'] = '';
        $topicData['topic_type_name'] = $topicData['topic_type'];
        $topicData['topic_type'] = CSConstant::getTopicTypeByTopicTypeName($topicData['topic_type']);
        $topicData['is_author'] = $this->userContext->userId == $topicData['user_id'] ? 1:0;
        $topicData['is_good'] = 0;

        $userInfo = UserRecord::findOne(['user_id' => $topicData['user_id']]);
        if (!empty($userInfo)) {
            $topicData['user_name'] = $userInfo['name'];
            $topicData['user_avatar'] = $userInfo['avatar'];
        }

        $goodModel = new GoodModel();
        $userList = $goodModel->getUserList($topicId);
        if(array_key_exists($this->userContext->userId,$userList)){
            $topicData['is_good'] = 1;
        }


        unset($topicData['is_deleted']);
        unset($topicData['update_time']);

        return $topicData;
    }


}