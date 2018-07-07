<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\cs;

/**
 * Description of newPHPClass
 *
 * @author ray-apple
 */
class TopicModel extends CSBaseModel
{
    /**
     * 获取主题详情
     * @param type $topicId
     * @return type
     */
    public function getTopicById($topicId)
    {
        return (new \yii\db\Query())->from('cs_topic')->where(['topic_id' => $topicId])->one($this->db);
    }
    
    /**
     * 更新主题
     * @param type $topicId
     * @param type $data
     * @return type
     */
    public function updateTopic($topicId, $data)
    {
        return $this->db->createCommand()->update('cs_topic', $data, ['topic_id' => $topicId])->execute();
    }

    public function getPublishCount($userId){
        $sql ="SELECT count(*) as count from cs_topic where user_id =:user_id";
        return $this->db->createCommand($sql,[':user_id'=>$userId])->queryColumn();
    }
    public function getReplyCount($userId){
        $sql ="SELECT count(*) as count from cs_topic where user_id =:user_id";
        return $this->db->createCommand($sql,[':user_id'=>$userId])->queryColumn();
    }
}
