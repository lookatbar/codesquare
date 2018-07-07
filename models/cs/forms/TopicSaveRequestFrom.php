<?php

namespace app\models\cs\forms;

use app\models\cs\forms\CSBaseForm;

/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 9:42
 *
 * 话题
 */
class TopicSaveRequestFrom extends CSBaseForm
{

    const SCENARIO_SUBMIT = 'submit';

    public $topic_id;
    public $title;
    public $topic_type;
    public $images_list;
    public $content;
    public $view_count;
    public $good_count;
    public $reply_count;



    public function rules()
    {
        return [
            [['title', 'topic_type', 'content'], 'required']
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SUBMIT] = ['title', 'topic_type','content','images_list','user_id'];
        return $scenarios;
    }

}