<?php
/**
 * Created by PhpStorm.
 * User: 不二进制
 * Date: 2018/6/9
 * Time: 上午9:59
 */

namespace JustFck\ApiDoc\service;

use JustFck\ApiDoc\base\Service;

/**
 * 管理员相关权限服务
 * Class AdminService
 *
 * @package JustFck\ApiDoc\service
 */
class AdminService extends Service {

    /**
     * @var string 密码保存,默认123。必须调用 setPassword程序修改
     */
    public $password = 'justfck';

    /**
     * @var string 保存在cookie中的auth信息的key
     */
    public static $authKey = 'auth';

    /**
     * @var string 加密串
     */
    private static $salt = 'sdfsis987(D&(*7jf;34';

    /**
     * 专门为web实现的auth
     * @return bool
     */
    public function authWeb() {
        if (!isset($_COOKIE[self::$authKey])){
            return false;
        }
        $authToken = $_COOKIE[self::$authKey];
        return $this->auth($authToken);
    }

    /**
     * 专门为web提供的登录方法
     * @param $password
     * @return bool
     */
    public function loginWeb($password) {
        $authToken = $this->login($password);
        if ($authToken === false){
            return false;
        }

        setcookie(self::$authKey, $authToken);
        return true;
    }

    /**
     * 验证是否登录
     *
     * @param $authToken
     *
     * @return bool
     */
    public function auth($authToken) {
        if (empty($authToken)){
            return false;
        }
        return $this->verifyAuth($authToken);
    }

    /**
     * 登录操作，简单做，只有密码
     * @param $password
     * @return bool | string
     */
    public function login($password) {
        // 简单匹配验证
        if ($password === $this->password){
            return $this->makeAuthToken();
        }

        return false;
    }

    /**
     * 设置密码
     * @param $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * 验证$authToken的正确性
     * @param $authToken
     * @return bool
     */
    public function verifyAuth($authToken) {
        $autoInfo = explode('|', $authToken);
        if (count($autoInfo) !== 2){
            return false;
        }

        $time = $autoInfo[1];

        $verifyToken = $this->makeAuthToken($time);
        if ($verifyToken !== $authToken){
            return false;
        }

        return true;
    }

    /**
     * 生成token
     * @param null $time
     * @return string
     */
    public function makeAuthToken($time = null) {
        if (is_null($time)){
            $time = time();
        }
        return md5($this->password.self::$salt.$time)."|".$time;
    }

}