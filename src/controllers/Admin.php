<?php
/**
 * Created by PhpStorm.
 * User: 不二进制
 * Date: 2018/6/9
 * Time: 上午9:51
 */

namespace JustFck\ApiDoc\controllers;

use JustFck\ApiDoc\base\Controller;
use JustFck\ApiDoc\lib\url\Url;
use JustFck\ApiDoc\model\Api;
use JustFck\ApiDoc\model\Json;
use JustFck\ApiDoc\model\Param;
use JustFck\ApiDoc\service\AdminService;
use JustFck\ApiDoc\service\DataService;

/**
 * 后台管理
 * Class Admin
 *
 * @package JustFck\ApiDoc\controllers
 */
class Admin extends Controller {

    /**
     * 不验证权限的页面
     * @var array
     */
    protected $_noAuth = [
        'login'
    ];

    /**
     * 构造调用函数
     */
    protected function _init() {
        // 验证是否登录
        if (!in_array($this->_action, $this->_noAuth)
            && !AdminService::getInstance()->authWeb()
        ) {
            $this->_action = 'login';
        }
    }

    /**
     * 登录
     */
    public function loginAction() {
        if (!empty($_POST) && isset($_POST['password'])){
            $password = $_POST['password'];
            if (AdminService::getInstance()->loginWeb($password)){
                header("location:".Url::init()->make('index'));
                return;
            }
        }
    }

    /**
     * 展示最新版本
     */
    public function indexAction() {
        $jsonList = DataService::getInstance()->getJsonListAndDetail();
        $jsonList = array_reverse($jsonList);
        $this->assign('jsonList', $jsonList);
    }

    /**
     * @return void|static
     */
    public function createAction(){
        if (!empty($_POST)){
            $param = $_POST;
            $version = $param['version'];
            $description = $param['description'];

            $json = new Json();
            $json->setVersion($version);
            $json->setDescription($description);
            $version = DataService::getInstance()->save($json->done(1));
            header("location:".Url::init()->make('detail', ['version'=>$version]));
            return;
        }

        $jsonObj = DataService::getInstance()->getLastJson();
        if (!empty($jsonObj)){
            $description = $jsonObj['description'];
        }else{
            $description = '';
        }

        $this->assign('form', [
            'version' => date('Ymd\THis'),
            'description' => $description,
        ]);
    }

    /**
     * api详情页面
     */
    public function detailAction() {
        if (empty($_GET['version'])){
            die('no version param');
        }
        $version = $_GET['version'];

        $json = DataService::getInstance()->getJson($version);
        $this->assign('json', $json);
    }

    /**
     * 更新接口描述信息
     */
    public function updateAction(){
        if (empty($_GET['version'])){
            die('no version param');
        }
        $version = $_GET['version'];
        $json = DataService::getInstance()->getJson($version);

        if (!empty($_POST)){
            $description = $_POST['description'];
            $json['description'] = $description;
            DataService::getInstance()->save($json);
            header('location:'.Url::init()->make('detail', ['version'=>$json['version']]));
            return;
        }

        $this->assign('form', $json);
    }

    /**
     * 接口添加
     */
    public function addApiAction() {
        if (!isset($_GET['version'])){
            die('no param version');
        }
        $version = $_GET['version'];

        $jsonArr = DataService::getInstance()->getJson($version);

        if (!empty($_POST)){
            [
                'apiget' => $_POST['apiget'] ?? [],
                'apibody' => $_POST['apibody'] ?? [],
            ];

            $paramGet = array_map(function($v){
                return (new Param())
                    ->setName($v['name'])
                    ->setType($v['type'])
                    ->setNeed($v['need'])
                    ->setDescription($v['description']);
            }, $_POST['apiget']??[]);
            $paramBody = array_map(function($v){
                return (new Param())
                    ->setName($v['name'])
                    ->setType($v['type'])
                    ->setNeed($v['need'])
                    ->setDescription($v['description']);
            }, $_POST['apibody']??[]);


            $api = (new Api())
                ->setId($_POST['id'])
                ->setName($_POST['name'])
                ->setDescription($_POST['description'])
                ->setUrl($_POST['url'])
                ->setMethod($_POST['method'])
                ->setBody($_POST['body'])
                ->setParamGet($paramGet)
                ->setParamBody($paramBody);

            $json = Json::formatFromArr($jsonArr)
                ->addApi($api);

            DataService::getInstance()->save($json->done(1));
            header("location:".Url::init()->make('detail', ['version' => $jsonArr['version']]));
            return;
        }

        $this->assign('json', $jsonArr);
        $api = new Api();
        $this->assign('api', $api->done(1));
    }
}