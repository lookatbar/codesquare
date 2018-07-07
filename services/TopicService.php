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
    public function like($topicId, $userId)
    {
        
    }
}