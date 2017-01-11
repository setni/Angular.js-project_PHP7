<?php

use http\Http;
use controllers\AjaxController;
use log\Log;
use models\mysql\SessionManager;

/**
* @pattern Factory
* All controller call must be secure with the CSRF token validation
*/
class ControllerFactory {

    /**
    * @param Object Http()
    * @return string response
    */
    public static function load(Http $http)
    {
        $type = $http->getHttp()->controller;
        switch($type) {
            case "Ajax":
                if((!isset($http->getHttp()->csrf) || $http->getHttp()->csrf == "") || self::_CSRFToken($http->getHttp()->csrf) === false) return json_encode(['success' => false]);
                $exec = new AjaxController($http);
                break;
            case "Upload":
                if((!isset($http->getHttp()->csrf) || $http->getHttp()->csrf == "") || self::_CSRFToken($http->getHttp()->csrf) === false) return json_encode(['success' => false]);
                $exec = new UploadController($http);
                break;
            case "CSRF":
                return self::_CSRFToken();
                break;
            default:
                return json_encode([
                    'success' => false,
                    'message' => Log::debug("Controller exception : Pas de controlleur {class} trouvé", ['class' => $type])
                ]);
        }
        return $exec->execute();
    }

    private static function _CSRFToken ($test = false)
    {
        if($test) {
            return SessionManager::getCSRFToken() == $test;
        }
        $token = crypt(uniqid());
        SessionManager::setCSRFToken($token);
        return $token;
    }
}
