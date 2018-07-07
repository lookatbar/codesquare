<?php
/**
 * Created by PhpStorm.
 * User: huangcf
 * Date: 2018/7/7
 * Time: 13:18
 */

namespace app\common;


class ErrorCode
{
    public static $OK = 1;
    public static $WX_OK = 1;
    public static $FAIL = 0;
    public static $ValidateSignatureError = -40001;
    public static $ParseXmlError = -40002;
    public static $ComputeSignatureError = -40003;
    public static $IllegalAesKey = -40004;
    public static $ValidateCorpidError = -40005;
    public static $EncryptAESError = -40006;
    public static $DecryptAESError = -40007;
    public static $IllegalBuffer = -40008;
    public static $EncodeBase64Error = -40009;
    public static $DecodeBase64Error = -40010;
    public static $GenReturnXmlError = -40011;
    public static $InvalidToken = -40012;
    public static $InvalidApiParam     = -40013;
    public static $ApiParamEmpty     = -40014;
    public static $DataNotFound     = -40015;
}