<?php
/**
 * 主题控制类
 */

namespace app\controllers\codesquare;


use app\common\CSConstant;
use app\common\ErrorCode;
use app\common\utils\CommonHelper;
use app\models\cs\forms\TopicSaveRequestFrom;
use app\services\TopicService;

class TopicController extends CSBaseController
{

    /**
     * 广场首页
     */
    public function actionIndex()
    {
        $topic_type = \Yii::$app->request->post('topic_type', CSConstant::TOPIC_TYPE_PROD);

        $topServ = new TopicService($this->userContext);
        $list = $topServ->queryTopList($topic_type,$this->pageIndex,$this->pageSize);
        
        $pageData = $this->responsePagingData($list['data'], $list['total'], count($list));
        $pageData['topic_type_list'] = CSConstant::getTopicTypes();
        $pageData['current_topic_type'] = $topic_type;

        return $pageData;

    }


    /**
     * 查看详情页面
     */
    public function actionTopicDetail()
    {
        $topicId = \Yii::$app->request->post('topic_id');
        if($topicId === NULL){
            return $this->error('参数错误',ErrorCode::$ApiParamEmpty);
        }

        $serv = new TopicService($this->userContext);
        $ret = $serv->getTopicDetail($topicId);
        if(empty($ret)){
            return $this->error('话题不存在',ErrorCode::$DataNotFound);
        }

        return $this->response($ret);
    }


    /**
     * 提交
     */
    public function actionTopicSubmit()
    {
        $form = new TopicSaveRequestFrom();
        //$form->attributes = \Yii::$app->request->post();

        //获取微信图片
        $wxMediaStr = \Yii::$app->request->post('images_list');
        $localImageList = $this->getLocalImageList($wxMediaStr);
        // 通知人
        $noticeUserListStr = \Yii::$app->request->post('notice_user_list');
        $noticeUserList = [];
        if(!empty($noticeUserListStr)){
            $noticeUserList = json_decode($noticeUserListStr,TRUE);
        }


        //添加话题数据
        $form->user_id = $this->userContext->userId;
        $form->images_list = json_encode($localImageList,TRUE);
        $form->title = \Yii::$app->request->post('title');
        $form->content = \Yii::$app->request->post('content');
        $form->topic_type = \Yii::$app->request->post('topic_type');
        $form->offer_award_id = \Yii::$app->request->post('offer_award_id');


        if(!$form->validate()){
            return $this->error('参数错误',ErrorCode::$InvalidApiParam);
        }

        $topicServ  = new TopicService($this->userContext);
        $topicId = $topicServ->sumbitTopic($form);
        return $this->response(['topic_id'=>$topicId]);

//        try{
//            $topicId = $topicServ->sumbitTopic($form);
//            return $this->response(['topic_id'=>$topicId]);
//        }catch (\Exception $ex){
//            return $this->error($ex->getMessage(),$ex->getCode());
//        }

    }

    /**
     * 标签列表
     */
    public function actionTagList()
    {

    }


    /**
     * 回复
     */
    public function actionReply()
    {
        $params = \Yii::$app->request->post();
        $form = new \app\models\cs\forms\ReplyForm();
        $form->setAttributes($params);
        if (!$form->validate()) {
            $error = $form->getFirstErrors();
            return $this->error(json_encode($error, JSON_UNESCAPED_UNICODE));
        }

        $wxMediaStr = $form->image_list;
        $localImageList = $this->getLocalImageList($wxMediaStr);
        $form->image_list = json_encode($localImageList,TRUE);
        
        $replySrv = new TopicService($this->userContext);
        $data = [
                    'topic_id' => $params['topic_id']
                    , 'content' => $params['content']
                    , 'image_list' => $form->image_list
                ];
        $replySrv->reply($data);
        return $this->response();
    }


    /**
     * 删除回复
     */
    public function actionDelReply()
    {
        // 校验
        $replyId = \Yii::$app->request->post('reply_id');
        if (!$replyId) {
            return $this->error('无效的参数', ErrorCode::$InvalidApiParam);
        }
        
        $replySrv = new TopicService($this->userContext);
        $replySrv->delReply($replyId);
        
        return $this->response();
    }
    
    
    /**
     * 收藏
     * @return type
     */
    public function actionCollect()
    {
        $topicId = \Yii::$app->request->post('topic_id');
        if (!$topicId) {
            return $this->error('参数无效', ErrorCode::$ApiParamEmpty);
        }
        $topicSrv = new TopicService($this->userContext);
        $res = $topicSrv->collect($topicId);
        if($res){
            return CommonHelper::response('ok',ErrorCode::$OK);
        }else{
            return CommonHelper::response('fail',ErrorCode::$FAIL);
        }
        

    }
    
    /**
     * 取消收藏
     * @return type
     */
    public function actionCancelCollect()
    {
        $topicId = \Yii::$app->request->post('topic_id');
        if (!$topicId) {
            return $this->error('参数无效', ErrorCode::$ApiParamEmpty);
        }
        $topicSrv = new TopicService($this->userContext);
        $topicSrv->collect($topicId, true);
        
        return $this->response();
    }

    /**
     * 点赞
     */
    public function actionLike()
    {
        $topicId = \Yii::$app->request->post('topic_id');
        if (!$topicId) {
            return $this->error('参数无效', ErrorCode::$ApiParamEmpty);
        }    
        $topicSrv = new TopicService($this->userContext);
        $topicSrv->like($topicId);
        return $this->response();
    }
    
    /**
     * 取消点赞
     * @return type
     */
    public function actionCancelLike()
    {
        $topicId = \Yii::$app->request->post('topic_id');
        if (!$topicId) {
            return $this->error('参数无效', ErrorCode::$ApiParamEmpty);
        }    
        $topicSrv = new TopicService($this->userContext);
        $topicSrv->like($topicId, true);
        return $this->response();
    }
    
    /**
     * 采纳
     * @return type
     */
    public function actionAccept()
    {
        $topicId = \Yii::$app->request->post('topic_id');
        $replyId = \Yii::$app->request->post('reply_id');
        if (!$topicId || !$replyId) {
            return $this->error('参数无效', ErrorCode::$ApiParamEmpty);
        }
        
        $topicSrv = new TopicService($this->userContext);
        $topicSrv->accept($topicId, $replyId);
        
        return $this->response();
    }

    /**
     * 打赏
     */
    public function actionReward()
    {

    }





}