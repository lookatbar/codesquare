<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\cs;

/**
 * Description of CSBaseModel
 * @author ray-apple
 */
class CSBaseModel
{
    /**
     * 数据库连接
     * @var \yii\db\Connection
     */
    protected $db = null;

    public function __construct()
    {
        $this->db = \yii::$app->db;
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
