<?php

namespace models;

use models\mysql\Mysql;
use models\mysql\SessionManager;

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
     * @param string $login
     * @param string $pwd
     * @param string $roles (Admin, Owner folder, Read, Write)
     * @return Boolean
     */
     public function register ($login, $password, $roles = "0111")
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
     * @param string $login
     * @param string $pwd
     * @return Boolean
     */
     public function login ($login, $password)
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
     {
         SessionManager::unsetSession();
         return ['success' => true];
     }

     public function checkUser ()
     {
         return $this->mysql->getCurrentUser();
     }

 }
