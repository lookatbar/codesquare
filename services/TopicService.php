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
use app\models\cs\records\TopicRecord;

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
    public function sumbitTopic(TopicSaveRequestFrom $form){
        //$form->setScenario(TopicSaveRequestFrom::SCENARIO_SUBMIT);
        $record = new TopicRecord();

        $record['title'] = $form->title;
        $record['content'] = $form->content;
        $record['user_id'] = $form->user_id;
        $record['images_list'] = empty($form->images_list)?json_encode([],true):$form->images_list;
        $record['topic_type'] = $form->topic_type;
        $record->save();
        return $record['topic_id'];
    }


}