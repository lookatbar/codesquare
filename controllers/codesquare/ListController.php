<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\codesquare;

/**
 * Description of ListController
 *
 * @author ray-apple
 */
class ListController extends CSBaseController
{
    /**
     * 获取回复列表信息
     */
    public function actionReply()
    {
        $topicId = \Yii::$app->request->post('topic_id');
        if (!$topicId) {
            return $this->error('参数无效', ErrorCode::$ApiParamEmpty);
        }
        
        
        $topicSrv = new \app\services\TopicService($this->userContext);
        $ret = $topicSrv->queryReplyList($topicId, $this->pageIndex, $this->pageSize);
        
        return $this->responsePagingData($ret['list'], $ret['count'], $this->pageSize);
     }
    
}
