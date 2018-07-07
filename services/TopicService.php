<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 11:30
 */

namespace app\services;
use app\common\CSConstant;
use app\models\cs\FavoriteModel;
use app\models\cs\forms\TopicSaveRequestFrom;
use app\models\cs\GoodModel;
use app\models\cs\records\OfferAwardRecord;
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
     * @param array $data
     */
    public function reply($data)
    {
        $data['user_id'] = $this->userContext->userId;
        (new \app\models\cs\ReplyModel())->insertReply($data);
    }

    /**
     * 删除回复
     * @param type $replyId
     * @return type
     */
    public function delReply($replyId)
    {
        $replyModel = new \app\models\cs\ReplyModel();
        // 校验
        $replyInfo = $replyModel->getReplyById($replyId);
        if (!$replyInfo) {
            return;
        }
        
        // 不能删除别人的回复
        if ($replyInfo['user_id'] != $this->userContext->userId) {
            return;
        }
        
        $replyModel->delReply($replyInfo['topic_id'], $replyId);        
    }
    
    /**
     * 点赞或取消
     * @param int $topicId
     */
    public function like($topicId, $cancel = false)
    {
 
        $goodModel = new \app\models\cs\GoodModel();
        \app\common\utils\helper::lock("topic_like_lock_{$topicId}", function() use($topicId, $goodModel, $cancel){
            $userList = $goodModel->getUserList($topicId);
            $userList = is_array($userList) ? $userList : [];
            // 取消
            if ($cancel && array_key_exists($this->userContext->userId, $userList)) {
                unset($userList[$this->userContext->userId]);
                $goodModel->saveUserList($topicId, $userList);
            } elseif (!$cancel && !array_key_exists($this->userContext->userId, $userList)) {
                $userList[$this->userContext->userId] = ['name' => $this->userContext->userName];
                $goodModel->saveUserList($topicId, $userList);
            }
        });
    }
    
    /**
     * 采纳回复
     * @param int $topicId
     * @param int $replyId
     */
    public function accept($topicId, $replyId)
    {
        // 校验
        $topicModel = new \app\models\cs\TopicModel();
        $topic = $topicModel->getTopicById($topicId);
        if (!$topic) {
            return;
        }
        
        if ($topic['user_id'] != $this->userContext->userId) {
            return;
        }
        
        $replyModel = new \app\models\cs\ReplyModel();
        $reply = $replyModel->getReplyById($replyId);
        if (!$reply) {
            throw new \app\exceptions\BusinessException("回复不存在");
        }
        
        $topicModel->updateTopic($topicId, ['accept_reply_id' => $replyId]);
    }
    
    /**
     * 收藏或取消收藏
     * @param type $topicId
     * @param type $cancel
     * @return type
     */
    public function collect($topicId, $cancel = false)
    {
        $userModel = new \app\models\cs\UserModel();
        // 取消收藏
        if ($cancel) {
            $userModel->delFavorite($topicId, $this->userContext->userId);
            return;
        }
        
        // 收藏
        $userModel->addFavorite([
            'topic_id' => $topicId
           ,'user_id' => $this->userContext->userId]);
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
        if(!empty($form->offer_award_id)){
            $record['offer_award_id'] = $form->offer_award_id;
        }
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
        //增加阅读量
        $model = new TopicRecord();
        $model->increaseViewCount($topicId);

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
        $topicData['is_fav'] = 0;

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

        $favInfo =  FavoriteModel::findOne(['user_id'=>$this->userContext->userId,'topic_id'=>$topicId,'is_deleted'=>0]);
        if (!empty($favInfo)) {
            $topicData['is_fav'] = 1;
        }

        $topicData['offer_award'] = NULL;
        if($topicData['offer_award_id']>0){

            $offerAwardData = OfferAwardRecord::findOne(['offer_award_id'=>$topicData['offer_award_id']]);
            if(!empty($offerAwardData)){
                $offerAwardData = $offerAwardData->toArray();
                unset($offerAwardData['update_time']);
                $topicData['offer_award'] = $offerAwardData;
            }
        }





        unset($topicData['is_deleted']);
        unset($topicData['update_time']);

        return $topicData;
    }

    /**
     * 回复列表
     * @param type $topicId
     * @param type $pageIndex
     * @param type $pageSize
     * @return type
     */
    public function queryReplyList($topicId, $pageIndex, $pageSize)
    {
        $replyModel = new \app\models\cs\ReplyModel();
        return $replyModel->getReplyListByTopicId($topicId, $pageIndex, $pageSize);
    }
}