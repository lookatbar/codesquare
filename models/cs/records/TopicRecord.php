<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 15:39
 */

namespace app\models\cs\records;


class TopicRecord extends  CSBaseRecord
{
    public function queryTopicList($topicType=NULL,$pageIndex=CSConstant::PAGE_INDEX,$pageSize=CSConstant::PAGE_SIZE){
        $countSql = 'SELECT COUNT(1) FROM cs_topic WHERE 1=1';
        $limitSql = 'SELECT * FROM cs_topic WHERE 1=1 '.$this->_getLimitSql([$pageIndex,$pageSize]);
        if($topicType !== NULL){
            $where = "topic_type = $topicType";
            $countSql = str_replace('1=1',$where,$countSql);
            $limitSql = str_replace('1=1',$where,$limitSql);
        }
        $list = self::getDb()->createCommand($limitSql)->query()->readAll();
        $count = self::getDb()->createCommand($countSql)->queryScalar();

        return ['total'=>$count,'data'=>$list];
    }
}