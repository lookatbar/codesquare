<?php
use app\models\cs\forms\CSBaseForm;

/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 9:42
 *
 * 话题
 */
class TopicSaveRequestFrom extends  CSBaseForm
{

    public $title;
    public $conents;
    public $imageList;
    public $tagId ;
    public $isOfferAward;
    public $offerAwardCount;


    public function rules(){
        return [];
    }

}