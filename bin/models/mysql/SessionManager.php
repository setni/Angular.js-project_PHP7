<?php
/***********************************************************************************************
 * Angular->php standard REST API  - Full native php REST API Angular friendly
 *   SessionManager.php Management of Session as service
 * Copyright 2016 Thomas DUPONT
 * MIT License
 ************************************************************************************************/

 namespace bin\models\mysql;

 class SessionManager {

     public static function unsetSession()
     : void
     {
         session_unset();
         session_destroy();
     }

     /**
     * @param $token
     * @param $roles
     * @param $id
     */
     public static function setSession (string $token, string $roles = "", int $id)
     : void
     {
         $_SESSION['APITOKEN'] = $token;
         $_SESSION['roles'] = $roles;
         $_SESSION['id'] = $id;
     }

     public static function getSession ()
     : array
     {
         return isset($_SESSION['APITOKEN']) ? $_SESSION : ['APITOKEN' => ""];
     }

     /**
     * @param $token
     * CSRF attack securisation
     */
     public static function setCSRFToken (string $token)
     : void
     {
         $_SESSION['CSRF'] = $token;
     }

     public static function getCSRFToken ()
     : string
     {
         return isset($_SESSION['CSRF']) ? $_SESSION['CSRF'] : "";
     }
 }
