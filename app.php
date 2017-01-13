<?php

/***********************************************************************************************
 * Angular->php standard REST API  - Full native php REST API Angular friendly
 *   app.php destination of all API request
 *   Version: 0.1.1
 * Copyright 2016 Thomas DUPONT
 * MIT License
 ************************************************************************************************/

define("ROOTDIR", __DIR__."/");
session_start();

require_once("bin/config.php");
require_once("bin/Autoloader.php");

bin\Autoloader::register();
if(($post = json_decode(file_get_contents("php://input"))) === null) {
    exit("Merci de passer un objet JSON");
}

$http = bin\http\Http::getInstance()->setHttp($post);
$response = bin\ControllerFactory::load($http);

echo <<<JSON
{$response}
JSON;
