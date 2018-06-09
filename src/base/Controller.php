<?php
/**
 * Created by PhpStorm.
 * User: 不二进制
 * Date: 2018/6/9
 * Time: 上午9:52
 */

namespace JustFck\ApiDoc\base;

abstract class Controller {
    protected $_action = '';
    private $_tplVar = [];

    /**
     * 创建应用，然后执行
     *
     * @param $action
     *
     * @return static
     * @throws \Exception
     */
    public static function create($action) {
        $controller = new static($action);
        return $controller;
    }

    /**
     * Controller constructor.
     *
     * @param $action
     */
    public function __construct($action) {
        $this->_action = $action;

        $this->_init();
    }

    protected function _init() {}

    /**
     * 执行action
     *
     * @throws \Exception
     */
    public function run() {
        $actionName = $this->_action."Action";
        $actionTplName = $this->_action;
        // 执行
        $this->{$actionName}();

        $controllerName = $this->getControllerName();

        // 执行加载tpl模板
        $this->renderTpl($actionTplName, $controllerName);
    }

    /**
     * 加载模板
     *
     * @param string $action
     * @param string $controller
     *
     * @throws \Exception
     */
    private function renderTpl($action, $controller) {
        $path = implode(DIRECTORY_SEPARATOR, [
            APP_ROOT, 'src', 'tpl', TPL_THEME, $controller, $action.".phtml"
        ]);
        if (!file_exists($path)){
            throw new \Exception('未找到文件'.$path);
        }

        extract($this->_tplVar);

        include $path;
    }

    /**
     * 单个参数
     * @param $key
     * @param $value
     */
    protected function assign($key, $value){
        $this->_tplVar[$key] = $value;
    }

    /**
     * 多个参数
     * @param array $arr
     */
    protected function assignArr(array $arr){
        $this->_tplVar = array_merge($this->_tplVar, $arr);
    }

    /**
     * @return string
     */
    public function getControllerName() {
        return basename(str_replace('\\', '/', static::class));
    }

    /**
     * @return string
     */
    public function getActionName() {
        return $this->_action;
    }
}