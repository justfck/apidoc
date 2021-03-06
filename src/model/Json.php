<?php
/**
 * Created by PhpStorm.
 * User:
 * Date: 2018/6/9
 * Time: 下午1:54
 */

namespace JustFck\ApiDoc\model;

class Json extends BaseEntity {
    private $version = '';
    private $description = '';
    /**
     * @var Api[]
     */
    private $apiList = [];

    /**
     * @param string $description
     *
     * @return Json
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $version
     *
     * @return Json
     */
    public function setVersion($version) {
        $this->version = $version;
        return $this;
    }

    /**
     * @param Api[] $apiList
     *
     * @return Json
     */
    public function setApiList($apiList) {
        $this->apiList = $apiList;
        return $this;
    }

    /**
     * @param Api $api
     * @return Json
     */
    public function addApi(Api $api) {
        $this->apiList[] = $api;
        return $this;
    }

    public function done($is_array=0) {
        $data = [
            'version' => $this->version,
            'description' => $this->description,
            'apiList' => $this->apiListToArr(),
        ];

        if ($is_array){
            return $data;
        }else{
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    private function apiListToArr(){
        $data = [];
        foreach ($this->apiList as $index => $item) {
            $data[] = $item->done(1);
        }
        return $data;
    }


    public static function formatFromArr($jsonArr) {
        $apiList = [];
        foreach ($jsonArr['apiList'] as $index => $item) {
            $apiList[] = Api::formatFromArr($item);
        }

        return (new self())
            ->setVersion($jsonArr['version'])
            ->setDescription($jsonArr['description'])
            ->setApiList($apiList);
    }
}