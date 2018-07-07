<?php
namespace app\services;
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/7
 * Time: 11:27
 * 基本数据类型
 */
class CSServiceBase
{

    protected $userInfo = NULL;
    public function __construct(array $userInfo){
        $this->userInfo = $userInfo;
    }
}