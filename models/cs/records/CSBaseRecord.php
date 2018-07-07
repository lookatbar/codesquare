<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/3
 * Time: 19:07
 */

namespace app\models\cs\records;


use app\models\RecordBase;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/**
 * Class CSBaseRecord   代码广场数据库模型基础类
 * @package app\models\cs\records
 */
class CSBaseRecord extends RecordBase
{


    /**
     * 重写读取表名方法
     * @return string
     */
    public static function tableName()
    {

        $tableName = Inflector::camel2id(StringHelper::basename(get_called_class()), '_');
        if (StringHelper::endsWith($tableName, '_record')) {
            $tableName = substr($tableName, 0, strlen($tableName) - strlen('_record'));
        }
        return 'cs_' . $tableName ;
    }

    /**
     * 返回分页的sql片段
     * @param array $limit
     * @return string
     */
    protected function _getLimitSql($limit = array())
    {
        $sql = '';

        if (count($limit)) {
            $page = max(1, intval($limit[0]));
            $page_size = intval($limit[1]) > 0 ? intval($limit[1]) : 10;
            if (isset($limit[2])) {
                $move = $limit[2];
            } else {
                $move = 0;
            }
            $offset = ($page - 1) * $page_size + $move;
            $sql = ' LIMIT ' . ($offset > 0 ? $offset : 0) . ',' . $page_size;
        }

        return $sql;
    }

    /**
     * 返回分页信息
     * @param $list
     * @param $total
     * @return array
     */
    public function retPage($list,$total){
        return ['total'=>$total,'data'=>$list];
    }



}