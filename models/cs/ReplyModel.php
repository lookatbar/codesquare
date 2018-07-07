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
     * @param type $data
     */
    public function insertReply($data)
    {
        $this->db->transaction(function() use($data) {
            $this->db->createCommand()->insert('cs_reply', $data)->execute();
            $this->db->createCommand("update cs_topic set reply_count=reply_count+1 where topic_id=:topic_id",
                [':topic_id' => $data['topic_id']])->execute();
        });
    }
}
