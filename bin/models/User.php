<?php

/***********************************************************************************************
 * Angular->php standard REST API  - Full native php REST API Angular friendly
 *   User.php User model
 * Copyright 2016 Thomas DUPONT
 * MIT License
 ************************************************************************************************/

namespace bin\models;

use bin\models\mysql\Mysql;
use bin\models\mysql\SessionManager;

/**
* To do the interface with the Mysql sub-service for user management
*
*/
class User {

     /**
     * @var Object Mysqli connect
     *
     */
     private $mysql;

     public function __construct ()
     {
         $this->mysql = Mysql::getInstance();
     }

     /**
     * @param $login
     * @param $pwd password
     * @param $roles (Admin, Owner folder, Read, Write)
     */
     public function register (string $login, string $password, string $roles = "0111")
     : array
     {
        $token = md5(uniqid());
        $this->mysql->setUser(true);
        if(($id = $this->mysql->setDBDatas(
                "users",
                "(login, password, API_key, roles, creationDate) VALUE (?, ?, ?, ?, NOW())",
                [$login, $password, $token, $roles]
            ))
        ) {
            SessionManager::setSession($token, $roles, $id);
            return ['success' => true];
        }
        return ['success' => false];
     }

     /**
     * @param $login
     * @param $pwd
     */
     public function login (string $login, string $password)
     : array
     {

        $this->mysql->setUser(true);
        $dataSet = $this->mysql->getDBDatas(
            "SELECT * FROM users WHERE login = ?",
            [$login]
        )->toObject();

        if($dataSet['success']) {
            if(password_verify($password, $dataSet['result']->password)) {
              SessionManager::setSession($dataSet['result']->API_key, $dataSet['result']->roles, $dataSet['result']->id);
              return ['success' => true, 'name' => $dataSet['result']->login];
            } else {
              return ['success' => false];
            }
        }
        return ['success' => false];
     }

     public function disconnect ()
     : array
     {
         SessionManager::unsetSession();
         return ['success' => true];
     }

     public function checkUser ()
     : array
     {
         return $this->mysql->getCurrentUser();
     }

 }
