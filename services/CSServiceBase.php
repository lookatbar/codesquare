<?php
namespace app\services;
use app\common\context\UserContext;

/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 11:27
 * 基本数据类型
 */
class CSServiceBase
{

    protected $userContext = NULL;
    public function __construct(UserContext $userContext){
        $this->userContext = $userContext;
    }
}