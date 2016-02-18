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

    public function __construct($tpl = null) {
        $this->option = call_user_func(['\Option\Template', $tpl]);
    }

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

    public function getOption() {
        return json_encode($this->option, JSON_UNESCAPED_UNICODE);
    }
}