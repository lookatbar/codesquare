<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 22:01
 */

namespace app\models\cs\records;

/**
 * Class OfferAwardRecord 悬赏记录
 * @package app\models\cs\records
 */
class OfferAwardRecord  extends  CSBaseRecord
{
    /**
     * 查询分页
     * @param null $topicType
     * @param $pageIndex
     * @param $pageSize
     * @return array
     */
    public function queryOfferAwardList($pageIndex=CSConstant::PAGE_INDEX,$pageSize=CSConstant::PAGE_SIZE){
        $fields = "offer_award_id,title,max_amount,create_time";
        $countSql = 'SELECT COUNT(1) FROM cs_offer_award';
        $limitSql = "SELECT $fields FROM cs_offer_award  ".$this->_getLimitSql([$pageIndex,$pageSize]);

        $list = self::getDb()->createCommand($limitSql)->query()->readAll();
        $count = self::getDb()->createCommand($countSql)->queryScalar();

        return $this->retPage($list,$count);
    }
}