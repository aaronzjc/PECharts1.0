<?php
namespace series;

class bar {
    public $series = null;

    public static $defaultTpl = [
        'barWidth' => 5,
        'type' => 'bar'
    ];

    public function __construct() {

    }

    public function handleData($name, $data) {
        self::$defaultTpl['name'] = $name;
        foreach ($)
        return $data;
    }
}