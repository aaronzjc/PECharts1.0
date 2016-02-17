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
     * 初始化时,加载模板
     */
    public function __construct($tpl = null) {
        $this->option = call_user_func(['\Option\Template', $tpl]);
    }

    /**
     * 构造入口
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
     * 根据option来自动生成legend的图例数据.
     * 目前在饼图中用到.
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
     * 返回option的JSON串.如果参数为True,则转化JS中的function使之能够执行.
     * @return string
     */
    public function getOption($anoyFunc = false) {
        if ($anoyFunc) {

        }
        return json_encode($this->option, JSON_UNESCAPED_UNICODE);
    }

    public function funcHandle($arr = []) {
        $option = $arr;
        if ($arr) {
            $funcMap = [];
            foreach ($option as $k => &$v) {
                if ($v instanceof \Closure) {
                    $hash = md5($k);
                    $option[$k . '_' . $hash] = '{%function%}';
                    $funcMap[$hash] = $v;
                    unset($option[$k]);
                } elseif (is_array($v)) {
                    $this->funcHandle($v);
                }
            }
            return $option;
        }
    }
}
