<?php
namespace Option;
/**
 * User: memosa
 * Date: 16/2/2
 * Time: 14:17
 */

class Template{
    public static $tpl = [
        'title' => [
            'show' => True,
            'text' => 'PECharts@Memosa',
            'x' => 'center',
        ],
        'tooltip' => [],
        'toolbox' => [
            'show' => True,
            'orient' => 'horizontal',
            'feature' => [],
        ],
        'legend' => [],
    ];
    public static function pie(){
        // do your customs here
        return self::$tpl;
    }
}