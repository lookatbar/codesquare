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
class UserModel extends CSBaseModel
{
    /**
     * 添加收藏
     * @param type $data
     * @return type
     */
    public function addFavorite($data)
    {
        return $this->db->createCommand()->insert('cs_favorite', $data)->execute();
    }
    
    /**
     * 删除收藏
     * @param type $topicId
     * @param type $userId
     */
    public function delFavorite($topicId, $userId)
    {
        return $this->db->createCommand()
                ->update('cs_favorite', 
                    ['is_deleted' => 1]
                    , ['topic_id' => $topicId, 'user_id' => $userId])
                ->execute();
    }
    
    /**
     * 删除收藏
     * @param type $favoriteId
     * @return type
     */
    public function delFavoriteById($favoriteId)
    {
        return $this->db->createCommand()
                ->update('cs_favorite', 
                    ['is_deleted' => 0]
                    , ['favorite_id' => $favoriteId])
                ->execute();
    }

    public function findFavoriteByUserId($userId,$topicId){
//echo $userId."|".$topicId;die;
        $sql ="select * from cs_favorite where user_id = :user_id and topic_id = :topic_id and is_deleted = 0";
        return $this->db->createCommand($sql,[':user_id'=>$userId,':topic_id'=>$topicId])->queryAll();
//        var_dump($data);die;

    }
}
