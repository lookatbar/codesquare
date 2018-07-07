<?php
/**
 * Created by PhpStorm.
 * User: huangcf
 * Date: 2018/7/7
 * Time: 18:43
 */

namespace app\common\weixin;


use app\common\ErrorCode;
use app\common\utils\CommonHelper;
use Yii;

class WxService
{

    public  function getFile($media_id = ""){
        $media_id = '1NJ8Liwq2-TW29Z2-2ak5bAqbS1lcKNxXkC054CIEj0AejF6I_p3xMf7FOlhvz5yrJzLyoOcnBj0S76dbsEdCag';
        if( empty($media_id)) {
            CommonHelper::response('缺少媒体ID',ErrorCode::$FAIL,[]);
        }
        $tk = new AccessToken(134);
        $token = $tk->getAccessToken();
        $url = "https://qyapi.weixin.qq.com/cgi-bin/media/get?access_token=$token&media_id=$media_id";
        $file = $this->downloadWeixinFile($url);
        return  $this->saveWeixinFile($media_id,$file);
    }

    /**
     * 下载微信文件
     * @param $url
     * @return array
     */
    function downloadWeixinFile($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        $imageAll = array_merge(array('header' => $httpinfo), array('body' => $package));
        return $imageAll;
    }

    function saveWeixinFile($filename, $file)
    {
        $path = 'uploads/'.date("Y").'/'.date("m").'/'.date('d').'/';
        if (!file_exists($path)) {
            $this->createDir($path);
        }
        if($file['header']['content_type'] == 'image/jpeg'){
            $ext ='.jpg';
        }else{
            $ext = "";
        }
        $local_file = fopen($path.$filename.$ext, 'w');
        if (false !== $local_file){
            if (false !== fwrite($local_file, $file['body'])) {
                fclose($local_file);
            }
        }
        $host = Yii::$app->params['host'];
        if($host){
            return $host.$path.$filename.$ext;
        }
        return $path.$filename.$ext;
    }

    /**
     * 递归：生成目录
     */
    private function createDir($str)
    {
        $arr = explode('/', $str);
        if(!empty($arr))
        {
            $path = '';
            foreach($arr as $k=>$v)
            {
                $path .= $v.'/';
                if (!file_exists($path)) {
                    mkdir($path, 0777);
                    chmod($path, 0777);
                }
            }
        }
    }

}