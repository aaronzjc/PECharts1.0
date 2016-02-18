<?php
namespace Option;
/**
 * Created by PhpStorm.
 * User: memosa
 * Date: 16/1/29
 * Time: 19:54
 */

class Builder{

    public $option = [];

    public function __construct($option = []){
        $this->option = $option;
    }

    /**
     * @param $name 需要进行设置的变量名
     * @param $arg  设置的参数
     */
    public function specialAct($name, $arg) {
        if ($arg === '{}') {
            $this->option[$name] = new \stdClass();
        }
    }

    /**
     * @param $name
     * @param $val
     */
    public function __set($name, $val){
        $this->option[$name] = $val;
    }

    /**
     * @param 函数名
     * @param 魔术参数;0 => 匿名函数, 1 => 是否列表元素
     * @return $this
     */
    public function __call($name, $call) {
        $arg = $call[0];
        $type = $call[1]?True:false;
        // 如果参数是闭包, 则进行'递归'调用处理
        if ($arg instanceof \Closure) {
            $builder = new Static();
            $index = count($this->option[$name]);
            $builder->option = & $this->option[$name];
            if ($type) {
                $builder->option = & $this->option[$name][$index];
            }
            $arg($builder);
        }
        // 数组,则直接赋值
        if (is_array($arg)) {
            if ($type) {
                $this->option[$name][] = $arg;
            } else {
                $this->option[$name] = array_replace($this->option[$name],$arg);
            }
        }
        // 字符串, 则调用定义的函数进行一些特殊处理
        if (is_string($arg)) {
            call_user_func(array($this, 'specialAct'), $name, $arg);
        }

        return $this;
    }

    public function __toString() {
        return json_encode($this->option, JSON_UNESCAPED_UNICODE);
    }

    public function getOption() {
        return $this->option;
    }
}