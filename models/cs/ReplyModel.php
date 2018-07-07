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
//        return (new \yii\db\Query())
//            ->from('cs_reply')
//            ->where(['to_user_id' => $userId, 'is_deleted' => 0])
//            ->limit($pageSize)
//            ->offset($pageIndex)
//            ->all($this->db);

        if(empty($userId)){
            return $this->retPage([],0);
        }

        $fields = ' cs_reply.reply_id
        ,cs_reply.topic_id
        ,cs_reply.content
        ,cs_reply.image_list
        ,cs_reply.create_time
        ,cs_topic.title
        ,cs_topic.topic_type
        ,cs_user.name as user_name
        ,cs_user.avatar as user_avatar ';
        $countSql = 'select COUNT(1) from cs_reply LEFT JOIN cs_topic ON cs_reply.topic_id=cs_topic.topic_id WHERE 1=1';
        $limitSql = "select $fields from cs_reply LEFT JOIN cs_topic ON cs_reply.topic_id=cs_topic.topic_id  LEFT JOIN cs_user ON cs_reply.user_id=cs_user.user_id WHERE 1=1 ".$this->_getLimitSql([$pageIndex,$pageSize]);

        $where = " cs_topic.user_id=$userId AND cs_reply.is_deleted=0 AND cs_topic.is_deleted=0 ";
        $countSql = str_replace('1=1',$where,$countSql);
        $limitSql = str_replace('1=1',$where,$limitSql);


        $list = $this->db->createCommand($limitSql)->query()->readAll();
        $count = $this->db->createCommand($countSql)->queryScalar();

        return $this->retPage($list,$count);
    }



}
