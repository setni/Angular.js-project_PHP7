<?php

 namespace models\mysql;

 class Role {

     private static $write = false;

     private function _construct ()
     {

     }

     /**
     * @var Array $roles
     * @return Boolean
     */
     public static function checkRoles (Array $roles)
     {
         $implode = "";
         foreach ($roles as $type => $role) {
             switch ($type) {
               case 0: //admin
                 if($role) {
                     self::$write = true;
                 }
                 break;
               case 1: //Owner
                 if($role) {
                     self::$write = true;
                 }
                 break;
               case 2: //Read
                 if($role) {
                     self::$write = false;
                 }
                 break;
               case 3: //Write
                 if($role) {
                     self::$write = true;
                 }
                 break;
             }
             $implode = $implode.$role;
         }
         return ($implode == '0000') ? false : true;
         //var_dump($roles);
     }

 }
