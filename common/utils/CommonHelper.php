<?php
/**
 * Created by PhpStorm.
 * User: huangcf
 * Date: 2018/7/7
 * Time: 12:07
 */

namespace app\common\utils;


use Yii;
use yii\web\Response;

class CommonHelper
{
    /**
     * 返回格式化接口数据
     * @param $success 1成功 0失败
     * @param string $status TRUE|FALSE 成功TRUE,失败FALSE
     */
    public static function response($msg ="",$success = 0,$data=[],$code ="")
    {
        //设置JSON返回
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = [
            "success" => $success,
            "message" => $msg,
            "data" => $data
        ];
        if( $success == 0 ){
            $response->data['code'] = $code;
        }
        die(json_encode($response->data, JSON_UNESCAPED_UNICODE));
    }

}