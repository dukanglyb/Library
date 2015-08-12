<?php

use Phalcon\Config;

$settings = array(
    "database" => array(
        "adapter"    => "Mysql",
        "host"       => "localhost",
        "username"   => "root",
        "password"   => "",
        "dbname"     => "library",
    ),
    "application" => array(
        "controllersDir" => "app/controllers/",
        "modelsDir"      => "app/models/",
        "viewsDir"       => "app/views/",
        "pluginsDir" => "app/plugins/",
        "formsDir"      => "app/forms/",
        "libraryDir"       => "app/library/",
        "baseUri"       => "/",
    ),'server' => array(
        'redis'     => array(
            'ip'=>'10.10.101.33',
            'port'=>'6379',
            'auth'=>'redis'
        ),
        'tfs'=>array(
            'nginx-tfs'=>
                array(
                    'ip'=>'localhost',
                    'port'=>'7500',
                ),
            'appkey'=>'tappkey00001',
            'appid'=>1,
        )
    ),
    "mysetting" => "the-value"
);

$config = new Config($settings);