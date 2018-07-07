<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 11:30
 */

namespace app\services;

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
}