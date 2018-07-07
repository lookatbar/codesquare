<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\cs;

/**
 * Description of CSBaseModel
 * @property-read \yii\db\Connection $db Description
 * @author ray-apple
 */
class CSBaseModel
{
    protected $_db = null;
    
    /**
     * @return \yii\db\Connection
     */
    public function getdb()
    {
        if (is_null($this->_db)) {
            $this->_db = \yii::$app->db;
        }
        
        return $this->_db;
    }
}
