<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\cs\forms;

/**
 * Description of ReplyForm
 *
 * @author ray-apple
 */
class ReplyForm extends CSBaseForm
{
    public $topic_id;
    
    public $content;
    
    public $image_list;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['topic_id', 'content'],
                'required',
                'message' => '缺少参数'
            ]
        ]);
    }
}
