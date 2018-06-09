<?php
/**
 * Created by PhpStorm.
 * User: 不二进制
 * Date: 2018/6/9
 * Time: 上午11:34
 */

namespace JustFck\ApiDoc\lib\url;

use JustFck\ApiDoc\App;

class UrlParam extends Url {
    private $config = [
        'defaultController' => 'Index',
        'defaultAction' => 'index',
        'controller' => 'c',
        'action' => 'a'
    ];

    /**
     * 生成url的方法
     *
     * @param $action
     * @param array $param
     *
     * @return string
     * @throws \Exception
     */
    public function make($action, $param=[]) {
        if (is_scalar($action)){
            $controller = App::getInstance()->getController()->getControllerName();
        }else if (is_array($action) && count($action) === 2){
            $controller = $action[0];
            $action = $action[1];
        }else{
            throw new \Exception('参数action，期待是string或者2位元素的数组');
        }
        $param[$this->config['controller']] = $controller;
        $param[$this->config['action']] = $action;

        return '?'.http_build_query($param);
    }

    /**
     * 解析url
     *
     * @return mixed
     */
    public function parse() {
        $param = $_GET;
        if (isset($param[$this->config['controller']])){
            $controller = $param[$this->config['controller']];
        }else{
            $controller = $this->config['defaultController'];
        }

        if (isset($param[$this->config['action']])){
            $action = $param[$this->config['action']];
        }else{
            $action = $this->config['defaultAction'];
        }

        return [$controller, $action];
    }
}