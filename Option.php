<?php
/**
 * by JC.2016.01.29
 *  ECharts的option对象
 */

class Option {
    /**
     * ECharts配置项对象
     */
    private $option = [];

    /**
     * 构造函数,可使用模板初始化
     * @param null $tpl
     */
    public function __construct($tpl = null) {
        $this->option = call_user_func(['\Option\Template', $tpl]);
    }

    /**
     * 初始化,进行option构造
     * @param $builder [] | closure \ builder
     * @return $this
     */
    public function init($builder) {
        if ($builder instanceof \Closure) {
            $callback = $builder;
            $builder = new \Option\Builder($this->option);
            $callback($builder);
        }

        if (is_array($builder)) {
            $this->option = $builder;
        }

        if($builder instanceof \Option\Builder) {
            $this->option = $builder->getOption();
        }

        return $this;

    }

    /**
     * 根据饼图的series数据来生成legend的数据
     * @return $this
     */
    public function autoLegend() {
        $legend = [];
        if ($this->option['series']) {
            foreach ($this->option['series'] as $s) {
                if ($s['type'] == 'pie') {
                    foreach ($s['data'] as $k => $v) {
                        $legend[] = $v['name'];
                    }
                }
            }
            $this->option['legend']['data'] = $legend;
        }

        return $this;
    }

    /**
     * 遍历数组,将其中的function替换为md5值,留作之后格式化
     * @param $arr  待处理数组
     * @param $map  待处理的映射
     */
    private function handleFunc(&$arr, &$map) {
        foreach ($arr as $k => &$v) {
            // 这里粗略的可以判断是一个function
            if (is_array($v)) {
                $this->handleFunc($v, $map);
            } elseif (strpos($v, 'function(') === 0) {
                $key = md5($v);
                $map[$key] = $v;
                $v = $key;
            }
        }
    }

    /**
     * 返回最终的option的JSON数据
     * @param bool|false $format    true时处理function
     * @return mixed|string
     */
    public function getOptionJson($format = false) {
        if ($format) {
            $this->handleFunc($this->option, $map);
            $re = json_encode($this->option, JSON_UNESCAPED_UNICODE);
            foreach ($map as $k => $v) {
                $re = str_replace('"'. $k .'"', $v, $re);
            }
        } else {
            $re = json_encode($this->option, JSON_UNESCAPED_UNICODE);
        }
        return $re;
    }

    /**
     * 返回option数据
     * @return array|mixed
     */
    public function getOption() {
        return $this->option;
    }
}