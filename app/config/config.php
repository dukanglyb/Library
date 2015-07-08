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
    ),
    "mysetting" => "the-value"
);

$config = new Config($settings);