<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\cs\forms;

/**
 * Description of GoodForm
 *
 * @author ray-apple
 */
class GoodForm extends CSBaseForm
{
    public $topic_id;
    
    public $is_cancel = false;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['topic_id'],
                'required',
                'message' => '缺少参数'
            ]
        ]);
    }
}
