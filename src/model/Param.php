<?php
/**
 * Created by PhpStorm.
 * User: 不二进制
 * Date: 2018/6/10
 * Time: 下午7:13
 */

namespace JustFck\ApiDoc\model;

class Param extends BaseEntity {
    private $name='';
    private $type='';
    private $need=0;
    private $description='';

    /**
     * 生成结果
     * @param int $is_array
     * @return array|string
     */
    public function done($is_array = 0) {
        $data = [
            'name' => $this->name,
            'type' => $this->type,
            'need' => intval($this->need),
            'description' => $this->description,
        ];

        if ($is_array){
            return $data;
        }else{
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    public static function formatFromArr($arr) {
        return (new self())
            ->setName($arr['name'])
            ->setType($arr['type'])
            ->setNeed($arr['need']);
    }

    /**
     * @param string $name
     *
     * @return Param
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $type
     *
     * @return Param
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * @param int $need
     *
     * @return Param
     */
    public function setNeed($need) {
        $this->need = $need;
        return $this;
    }

    /**
     * @param string $description
     *
     * @return Param
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

}
