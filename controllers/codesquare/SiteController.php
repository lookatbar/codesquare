<?php
/**
 * Created by PhpStorm.
 * User: zhugm
 * Date: 2018/7/4
 * Time: 19:11
 */

namespace app\controllers\codesquare;
use app\common\context\UserContext;
use app\common\ErrorCode;
use app\common\utils\helper;
use app\common\utils\HttpHelper;
use app\common\weixin\AccessToken;
use app\common\weixin\jssdk;
use app\common\weixin\WxService;
use app\controllers\BaseController;
use app\models\cs\DepartmentModel;
use app\models\cs\records\UserRecord;
use app\common\utils\CommonHelper;
use Yii;


/**
 * 代码广场首页
 * Class CSSiteControllerls
 * @package app\controllers
 */
class SiteController extends BaseController
{
    const exprie_time  =  7200;



    public  function actionIndex(){
        $token = isset($_GET['token'])?$_GET['token']:"";
        header('Location:http://jkds.cracher.top/build/index.html?token='.$token);
    }



}