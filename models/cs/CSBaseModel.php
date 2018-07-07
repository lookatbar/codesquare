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
    protected $db = null;

    public function __construct()
    {
        $this->db = \yii::$app->db;
    }
}
