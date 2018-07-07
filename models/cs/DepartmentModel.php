<?php
/**
 * Created by PhpStorm.
 * User: huangcf
 * Date: 2018/7/7
 * Time: 15:46
 */

namespace app\models\cs;




use app\models\RecordBase;

class DepartmentModel extends RecordBase
{
    /**
     * 重写读取表名方法
     * @return string
     */
    public static function tableName()
    {
       return 'cs_department';
    }
}