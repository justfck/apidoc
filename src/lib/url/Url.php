<?php
/**
 * Created by PhpStorm.
 * User: 不二进制
 * Date: 2018/6/9
 * Time: 上午11:28
 */

namespace JustFck\ApiDoc\lib\url;

/**
 * url相关
 * Url::init()->xxx()
 * Class Url
 *
 * @package JustFck\ApiDoc\lib\url
 */
abstract class Url {

    /**
     * 配置
     * @var array
     */
    private static $config = [
        'mode' => 'param',
    ];

    /**
     * 工厂
     * @return Url
     */
    public static function init() {
        switch (self::$config['mode']){
            case 'mode':
            default:
                return new UrlParam();
        }
    }

    /**
     * 生成url的方法
     *
     * @param $action
     * @param $param
     *
     * @return string
     */
    abstract public function make($action, $param=[]);

    /**
     * 解析url
     * @return mixed
     */
    abstract public function parse();
}