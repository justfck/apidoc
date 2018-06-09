<?php
/**
 * Created by PhpStorm.
 * User: 不二进制
 * Date: 2018/6/9
 * Time: 上午9:33
 */

namespace JustFck\ApiDoc;

use JustFck\ApiDoc\base\Controller;
use JustFck\ApiDoc\lib\url\Url;
use phpcmx\common\trait_base\SimpleSingleton;

class App {

    /**
     * @var Controller
     */
    private $controller = null;

    use SimpleSingleton;

    /**
     * 入口
     * @return App
     */
    public static function index() {
        // 加载常量
        self::_init();
        // 预备app变量
        $app = self::getInstance();

        try {
            $app->createController();
            $app->getController()->run();
        } catch (\Exception $e) {
            // TODO 报异常
            echo "<pre>";
            var_dump($e);
        }

        return $app;
    }

    /**
     * 加载初始化
     */
    public static function _init() {
        // 常量加载
        define('APP_ROOT', dirname(dirname(__FILE__)));
        // 默认模板变量
        if (!defined('TPL_THEME')){
            define('TPL_THEME', 'default');
        }
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    private function createController() {
        list($controller, $action) = Url::init()->parse();
        $controller = "JustFck\\ApiDoc\\controllers\\".$controller;
        /** @var Controller $controller */
        $this->controller = $controller::create($action);
        return $this->controller;
    }

    /**
     * @return Controller
     */
    public function getController() {
        return $this->controller;
    }
}