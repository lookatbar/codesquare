<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\cs;

use yii\db\Query;

/**
 * Description of GoodModel
 *
 * @author ray-apple
 */
class GoodModel extends CSBaseModel
{
    /**
     * 点赞
     * @param int $topicId
     * @param array $userList
     */
    public function saveUserList($topicId, $userList)
    {
        $this->db->transaction(function() use($topicId, $userList){
            $existRecord = (new Query())->from('cs_good')->where(['topic_id' => $topicId])->exists($this->Db);
            if ($existRecord) {
                $this->db->createCommand()->update('cs_good', [
                    'user_list' => json_encode($userList)],
                    ['topic_id' => $topicId])->execute();
            } else {
                $this->db->createCommand()->insert('cs_good', [
                    'topic_id' => $topicId,
                    'user_list' => json_encode($userList)
                ])->execute();
            }

            $this->db->createCommand()->update('cs_topic', [
                'good_count' => count($userList)],
                    ['topic_id' => $topicId])->execute();
        } );
    }
    
    /**
     * 获取点赞用户列表
     * @param int $topicId
     * @return type
     */
    public function getUserList($topicId)
    {
        $userList = (new Query())->from('cs_good')->where(['topic_id' => $topicId])->createCommand($this->db)->queryScalar();
        return $userList === false ? [] : json_decode($userList, true);
    }
}
