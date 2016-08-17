<?php
/**
 * Created by PhpStorm.
 * User: memosa
 * Date: 16/3/23
 * Time: 23:25
 */
spl_autoload_register(function($classname) {
    require(str_replace('\\', '/', $classname) . ".php");
});

$option = new Option('pie');

$optionArr = $option->init([])->addSeries('pie', ['fuck' => 'me ?'])->addSeries('pie', ['excuse' => 'me ?']);

$optionArr->series(1)['excuse'] = 'you';
$optionArr = $optionArr->getOption();
var_dump($optionArr);

$option->addSeries();