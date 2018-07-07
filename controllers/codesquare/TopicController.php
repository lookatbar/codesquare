<?php
/**
 * 主题控制类
 */

namespace app\controllers\codesquare;


class TopicController extends CSBaseController
{


    /**
     * 广场首页
     */
    public function actionIndex()
    {



        return $this->response();
    }


    /**
     * 查看详情页面
     */
    public function actionTopicDetail()
    {

    }


    /**
     * 保存
     */
    public function actionTopicSave()
    {

        $topicTitle = \Yii::$app->request->post('topic_title');
        $topicContent = \Yii::$app->request->post('topic_content');
        $topicImageList = \Yii::$app->request->post('topic_image_list');
        $topicTagId = \Yii::$app->request->post('topic_tag_id');


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