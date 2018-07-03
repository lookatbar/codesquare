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

}