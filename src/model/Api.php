<?php
/**
 * Created by PhpStorm.
 * User: 不二进制
 * Date: 2018/6/9
 * Time: 下午1:59
 */

namespace JustFck\ApiDoc\model;

class Api extends BaseEntity {

    private $id = '';
    private $name = '';
    private $description = '';
    private $url = '';
    private $method = 'get';
    private $body = 'kv';
    /**
     * @var Param[]
     */
    private $paramGet = [];
    /**
     * @var Param[]
     */
    private $paramBody = [];

    /**
     * @param int $is_array 是否返回数组 0 json  1 数组
     *
     * @return mixed
     */
    public function done($is_array = 0) {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'method' => $this->method,
            'body' => $this->body,
            'paramGet' => $this->paramGetToArr(),
            'paramBody' => $this->paramBodyToArr(),
        ];
        if ($is_array) {
            return $data;
        } else {
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    public function paramGetToArr() {
        $result = [];
        foreach ($this->paramBody as $index => $item) {
            $result[] = $item->done(1);
        }

        return $result;
    }

    public function paramBodyToArr() {
        $result = [];
        foreach ($this->paramBody as $index => $item) {
            $result[] = $item->done(1);
        }

        return $result;
    }

    /**
     * @param string $id
     *
     * @return Api
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $name
     *
     * @return Api
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $description
     *
     * @return Api
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $url
     *
     * @return Api
     */
    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    /**
     * @param string $method
     *
     * @return Api
     */
    public function setMethod($method) {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $body
     *
     * @return Api
     */
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    /**
     * @param Param[] $paramGet
     *
     * @return Api
     */
    public function setParamGet($paramGet) {
        $this->paramGet = $paramGet;
        return $this;
    }

    /**
     * @param Param[] $paramBody
     *
     * @return Api
     */
    public function setParamBody($paramBody) {
        $this->paramBody = $paramBody;
        return $this;
    }

    public static function formatFromArr($arr) {
        $paramGet = [];
        $paramBody = [];
        foreach ($arr['paramGet'] as $index => $item) {
            $paramGet[] = Param::formatFromArr($arr);
        }
        foreach ($arr['paramBody'] as $index => $item) {
            $paramBody[] = Param::formatFromArr($arr);
        }

        return (new self())
            ->setId($arr['id'])
            ->setName($arr['name'])
            ->setDescription($arr['description'])
            ->setUrl($arr['url'])
            ->setMethod($arr['method'])
            ->setBody($arr['body'])
            ->setParamGet($paramGet)
            ->setParamBody($paramBody);
    }
}