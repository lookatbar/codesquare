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

        $form->user_id = $this->userContext->userId;
        $form->images_list = \Yii::$app->request->post('images_list');
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

    }


    /**
     * 删除回复
     */
    public function actionDelReply()
    {

    }

    /**
     * 点赞/取消点赞
     */
    public function actionLike()
    {

    }

    /**
     * 打赏
     */
    public function actionReward()
    {

    }


}