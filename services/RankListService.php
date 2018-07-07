<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 21:54
 */

namespace app\services;


use app\common\CSConstant;
use app\models\cs\records\OfferAwardRecord;
use app\models\cs\records\TopicRecord;

class RankListService extends CSServiceBase
{

    public function getRankList($rankType,$pageIndex=CSConstant::PAGE_INDEX,$pageSize=CSConstant::PAGE_SIZE){

        if($rankType == CSConstant::RANK_TYPE__OFFER_AWARD){
            return $this->getOfferAwardList($pageIndex,$pageSize);
        }else if($rankType == CSConstant::RANK_TYPE__REWARD){
            return $this->getRewardList($pageIndex,$pageSize);
        }
        return ['total'=>0,'data'=>[]];
    }


    public function getOfferAwardList($pageIndex=CSConstant::PAGE_INDEX,$pageSize=CSConstant::PAGE_SIZE){
        $model = new OfferAwardRecord();
        return $model->queryOfferAwardList($pageIndex,$pageSize);
    }

    public function getRewardList($pageIndex=CSConstant::PAGE_INDEX,$pageSize=CSConstant::PAGE_SIZE){
        $model = new TopicRecord();
        return $model->queryRewardList($pageIndex,$pageSize);
    }



}