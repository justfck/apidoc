<?php
/**
 * Created by PhpStorm.
 * User: 不二进制
 * Date: 2018/6/9
 * Time: 下午1:34
 */

namespace JustFck\ApiDoc\service;

use JustFck\ApiDoc\base\Service;

class DataService extends Service {

    /**
     * 配置
     * @var array
     */
    private $config = [
        'path' => APP_ROOT.'/data',
    ];

    /**
     * @return mixed
     */
    public function getPath() {
        if (!is_dir($this->config['path'])){
            mkdir($this->config['path']);
        }
        return $this->config['path'];
    }


    public function getJsonListAndDetail() {
        $jsonList = $this->getJsonList();
        $data = [];
        foreach ($jsonList as $index => $item) {
            $data[] = $this->getJson($item, '');
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getJsonList() {
        $dirs = scandir($this->getPath());
        foreach ($dirs as $index => $dir) {
            if (substr($dir, -5) != '.json'){
                unset($dirs[$index]);
            }
        }

        return $dirs;
    }

    /**
     * @param $version
     * @param string $suffix
     *
     * @return array
     */
    public function getJson($version, $suffix='.json') {
        $json = file_get_contents($this->getPath().'/'.$version.$suffix);
        return json_decode($json, 1);
    }

    /**
     * 获取最后一个json数据
     */
    public function getLastJson() {
        $jsonList = $this->getJsonList();
        if (empty($jsonList)){
            return [];
        }

        $version = array_pop($jsonList);

        return $this->getJson($version, '');
    }

    /**
     * @param $data array 保存数据
     *
     * @return mixed
     */
    public function save($data) {
        $version = $data['version'];
        $fileName = $this->getPath()."/".$version.".json";
        file_put_contents($fileName, json_encode($data, 1));
        return $version;
    }
}