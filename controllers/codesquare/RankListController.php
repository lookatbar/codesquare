<?php
/**
 * 排行榜
 */

namespace app\controllers\codesquare;


use app\services\RankListService;

class RankListController extends CSBaseController
{

    /**
     * 榜单首页
     */
    public function actionIndex(){

    }


    /**
     * 榜单
     * @post rank_type 榜单类型,[offer_award:悬赏榜，wealth:财富榜,like:得赞榜]
     */
    public function actionList(){
        $rankType = \Yii::$app->request->post('rank_type');
        $serv = new RankListService($this->userContext);
        $ret = $serv->getRankList($rankType);
        return $this->responsePagingData($ret['data'],$ret['total'],$this->pageSize);
    }


}