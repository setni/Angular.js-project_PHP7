<?php

use http\Http;
use log\Log;

define("ROOTDIR", __DIR__."/");
session_start();
require_once("bin/Autoloader.php");

Autoloader::register();
if(($post = json_decode(file_get_contents("php://input"))) === null) {
    exit("Merci de passer un objet JSON");
}

$http = Http::getInstance()->setHttp($post);
echo ControllerFactory::load($http);
