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
    /**
     * 查询分页
     * @param null $topicType
     * @param $pageIndex
     * @param $pageSize
     * @return array
     */
    public function queryTopicList($topicType=NULL,$pageIndex=CSConstant::PAGE_INDEX,$pageSize=CSConstant::PAGE_SIZE){
        $fields = " cs_topic.topic_id,cs_topic.title,cs_topic.topic_type,substring(cs_topic.content,1,2) as content,cs_topic.user_id,cs_user.name as user_name,cs_topic.images_list,cs_topic.view_count,cs_topic.good_count,cs_topic.reply_count,cs_topic.create_time";
        $countSql = 'SELECT COUNT(1) FROM cs_topic WHERE 1=1';
        $limitSql = "SELECT $fields FROM cs_topic LEFT JOIN cs_user ON cs_topic.user_id=cs_user.user_id WHERE 1=1 ".$this->_getLimitSql([$pageIndex,$pageSize]);
        if($topicType !== NULL){
            $where = "topic_type = $topicType";
            $countSql = str_replace('1=1',$where,$countSql);
            $limitSql = str_replace('1=1',$where,$limitSql);
        }
        $list = self::getDb()->createCommand($limitSql)->query()->readAll();
        $count = self::getDb()->createCommand($countSql)->queryScalar();

        return $this->retPage($list,$count);
    }


    /**
     * 添加阅读量
     * @param $topicId
     * @return int
     */
    public function increaseViewCount($topicId){
        $sql = "UPDATE cs_topic SET view_count=view_count+1 WHERE topic_id=$topicId";
        return self::getDb()->createCommand($sql)->execute();
    }



}