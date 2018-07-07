<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\cs;

/**
 * Description of ReplyModel
 *
 * @author ray-apple
 */
class ReplyModel extends CSBaseModel
{
    /**
     * 回复
     * @param array $data
     */
    public function insertReply($data)
    {
        $this->db->transaction(function() use($data) {
            $this->db->createCommand()->insert('cs_reply', $data)->execute();
            $this->db->createCommand("update cs_topic set reply_count=reply_count+1 where topic_id=:topic_id",
                [':topic_id' => $data['topic_id']])->execute();
        });
    }
    
    /**
     * 删除回复
     * @param int $topicId
     * @param int $replyId
     */
    public function delReply($topicId, $replyId)
    {
        $this->db->transaction(function() use($topicId, $replyId) {
            $isDel = $this->db->createCommand()->update('cs_reply', ['is_deleted' => 1], ['reply_id' => $replyId])->execute();
            if ($isDel) {
               // $count = (new \yii\db\Query())->from('cs_reply')->where(['topic_id' => $topicId, 'is_deleted' => 0])->sum('*', $this->db);
                $this->db->createCommand("update cs_topic set reply_count=if(reply_count>0,reply_count-1,0) where topic_id=:topic_id",
                [':topic_id' => $topicId])->execute();
            }
        });
    }
    
    /**
     * 获取回复详情
     * @param int $replyId
     * @return array|bool
     */
    public function getReplyById($replyId)
    {
        return (new \yii\db\Query())
                ->from('cs_reply')
                ->where(['reply_id' => $replyId, 'is_deleted' => 0])
                ->one($this->db);
    }


    public function getBeRepliedListByUser($userId,$pageIndex=CSConstant::PAGE_INDEX,$pageSize=CSConstant::PAGE_SIZE){
        return (new \yii\db\Query())
            ->from('cs_reply')
            ->where(['to_user_id' => $userId, 'is_deleted' => 0])
            ->limit($pageSize)
            ->offset($pageIndex)
            ->all($this->db);
    }

}
