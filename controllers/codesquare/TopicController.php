<?php
/**
 * 主题控制类
 */

namespace app\controllers\codesquare;


use app\common\CSConstant;
use app\common\ErrorCode;
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
        $wxMediaList = [];
        if(!empty($wxMediaStr)){
            $wxMediaList = json_decode($wxMediaStr,TRUE);
        }
        $localImageList = [];
        $wxService = new WxService();
        foreach ($wxMediaList as $wxMediaId){
            $localImagePath =$wxService->getFile($wxMediaId);
            if(!empty($localImagePath)){
                $localImageList[] = $localImagePath;
            }
        }

        //添加话题数据
        $form->user_id = $this->userContext->userId;
        $form->images_list = json_encode($localImageList,TRUE);
        $form->title = \Yii::$app->request->post('title');
        $form->content = \Yii::$app->request->post('content');
        $form->topic_type = \Yii::$app->request->post('topic_type');
        //$form->setScenario(TopicSaveRequestFrom::SCENARIO_SUBMIT);

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
        
        $replySrv = new TopicService($this->userContext);
        $data = [
                    'topic_id' => $params['topic_id']
                    , 'content' => $params['content']
                    , 'image_list' => $params['image_list']
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
        
        $cancel = \Yii::$app->request->post('is_cancel');
        $topicSrv = new TopicService($this->userContext);
        $topicSrv->collect($topicId, $cancel ? true : false);
        
        return $this->response();
    }

    /**
     * 点赞/取消点赞
     */
    public function actionLike()
    {
        $params = \Yii::$app->request->post();
        $form = new \app\models\cs\forms\GoodForm();
        $form->setAttributes($params);
        if (!$form->validate()) {
            $error = $form->getFirstErrors();
            return $this->error(json_encode($error, JSON_UNESCAPED_UNICODE));
        }
               
        $topicSrv = new TopicService($this->userContext);
        $topicSrv->like($form->topic_id, $form->is_cancel);
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