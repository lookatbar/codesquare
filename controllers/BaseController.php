<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/3
 * Time: 20:03
 */

namespace app\controllers;


use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\Response;

/**
 * 基础类
 * Class BaseController
 * @package app\controllers
 */
class BaseController extends Controller
{
    public $enableCsrfValidation = false;

    public function init()
    {

    }

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ]
        ];
    }

    public function error($msg, $code = '', $data = '')
    {
        return [
            'success' => 0,
            'code' => $code,
            'data' => $data,
            'message' => $msg
        ];
    }

    public function response($data = '', $current_ts = '', $msg = '')
    {
        return [
            'success' => 1,
            'data' => $data,
            'message' => $msg,
            'current_ts' => $current_ts
        ];
    }

    public function responsePagingData($data = '', $record_count = 0, $page_size = 0, $msg = '')
    {
        return [
            'success' => 1,
            'data' => $data,
            'message' => $msg,
            'record_count' => intval($record_count),
            'page_size' => intval($page_size) > 0 ? intval($page_size) : 10
        ];
    }



}