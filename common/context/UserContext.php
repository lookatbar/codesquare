<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\context;

/**
 * 用户上下文
 *
 * @author ray-apple
 */
class UserContext
{
     /**
     * 当前用户id
     * @var string
     */
    public $userId;
    
    /**
     * 当前用户名称
     * @var string
     */
    public $userName;
    /**
     * 用户头像
     */
    public $avatar;
    /**
     * 用户手机号
     */
    public $mobile;
    /**
     * 用户邮箱
     */
    public $email;
    /**
     * 用户部门
     */
    public $department;
}
