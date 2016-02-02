<?php
namespace Option;
/**
 * Created by PhpStorm.
 * User: memosa
 * Date: 16/2/2
 * Time: 14:17
 */

class Template{
    public static function pie(){
        return [
            'title' => [
                'text' => '饼图',
                'show' => True
            ],
            'tooltip' => [
                'trigger' => 'item',
                'formatter' => '{a} <br />'
            ],
            'legend' => [
                'show' => True,
                'orient' => 'vertical',
                'x' => 'left'
            ],
            'series' => []
        ];
    }
}