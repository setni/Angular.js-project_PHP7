<?php

 namespace models\mysql;

 class SessionManager {

     public static function unsetSession()
     {
         session_unset();
         session_destroy();
     }

     /**
     * @param string $token
     * @param string $roles
     * @param Int $id
     */
     public static function setSession ($token, $roles, $id)
     {
         $_SESSION['APITOKEN'] = $token;
         $_SESSION['roles'] = $roles;
         $_SESSION['id'] = $id;
     }

     public static function getSession ()
     {
         return isset($_SESSION['APITOKEN']) ? $_SESSION : ['APITOKEN' => ""];
     }

     /**
     * @param string $token
     * CSRF attack securisation
     */
     public static function setCSRFToken ($token)
     {
         $_SESSION['CSRF'] = $token;
     }

     public static function getCSRFToken ()
     {
         return isset($_SESSION['CSRF']) ? $_SESSION['CSRF'] : false;
     }
 }
