<?php

/***********************************************************************************************
 * Angular->php standard REST API  - Full native php REST API Angular friendly
 *   Mysql.php Mysql interface full documented used as service
 * Copyright 2016 Thomas DUPONT
 * MIT License
 ************************************************************************************************/

namespace bin\models\mysql;

use bin\log\Log;
use bin\models\mysql\SessionManager;

/**
* @pattern Singleton
*/
class Mysql {

    /**
    * @var Object Mysqli connect
    *
    */
    private static $_mysqli;

    /**
    * @var Object Mysql()
    *
    */
    private static $_instance;

    /**
    * @var Object Query result
    *
    */
    private static $result;

    /**
    * @var Boolean
    * Used for connection and registration, false by default
    */
    public static $user = false;

    /**
    * @param Boolean
    */
    public static function setUser($bool)
    {
        self::$user = $bool;
    }

    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
             self::$_instance = new self;
        }
        return self::$_instance;
    }

    private function __construct ()
    {
        self::$_mysqli = mysqli_init();
        if (!self::$_mysqli) {
            throw new \Exception(Log::error("mysqli_init failed"), 503);
        }
        if (!self::$_mysqli->real_connect(SQLIP, SQLUSER, SQLPWD, DATABASE, SQLPORT)) {
            throw new \Exception(Log::error("Connect Error ({errno}) {error}", ['errno' => mysqli_connect_errno(), 'error' => mysqli_connect_error()]), 503);
        }
    }

    private function __destruct()
    {
        self::$_mysqli->close();
    }

    /**
    * All sql operation must be authorised
    * @return array
    */
    public static function getCurrentUser()
    {
        $sql = "SELECT * FROM users WHERE API_key = '".SessionManager::getSession()['APITOKEN']."'";
        $result = self::$_mysqli->query($sql);
        if($result->num_rows) {
            $dataSet = $result->fetch_array();
            $result->close();
            return ['success' => true, 'name' => $dataSet['login']];
        } else {
            $result->close();
            return ['success' => false];
        }

    }
    /**
    * @param string $sql
    * @param array $params
    * @return instance
    */
    public static function getDBDatas ($sql, array $params = [])
    {

        $stmt = self::_prepareRequest($sql, $params);
        /* Execute statement */
        self::_executeQuery($stmt);
        self::$result = $stmt->get_result();

        return self::$_instance;
    }

    public static function toArray()
    {
        $resultSet = MYSQLI_NUM;
        return self::_getResult($resultSet);
    }

    public static function toArrayAssoc()
    {
        $resultSet = MYSQLI_ASSOC;
        return self::_getResult($resultSet);

    }

    public static function toObject()
    {

        if((self::$user || self::getCurrentUser()['success']) && self::$result->num_rows) {
            $dataSet = self::$result->fetch_object();

            self::$result->close();
            return ['success' => true, 'result' => $dataSet, 'session' => SessionManager::getSession()];
        } else {
            self::$result->close();
            return ['success' => false];
        }
    }

    private static function _getResult($resultSet)
    {
        if((self::$user || self::getCurrentUser()['success']) && self::$result->num_rows) {
            $dataSet = self::$result->fetch_all($resultSet);
            self::$result->close();
            return ['success' => true, 'result' => $dataSet, 'session' => SessionManager::getSession()];
        } else {
            self::$result->close();
            return ['success' => false];
        }
    }

    /**
    * @param string $table
    * @param string $sql
    * @param array $params
    * @return Int insert_id
    */
    public static function setDBDatas($table, $sql, array $params = [])
    {
        if(self::$user || self::getCurrentUser()['success']) {
            $stmt = self::_prepareRequest("INSERT INTO ".$table." ".$sql, $params);
            return self::_executeQuery($stmt) ? self::$_mysqli->insert_id : 0;
            //return last ID
        }
        return 0;
    }

    /**
    * @param string $table
    * @param string $sql
    * @param array $params
    * @return Boolean
    */
    public static function unsetDBDatas($table, $sql, array $params = [])
    {
        if(self::$user || self::getCurrentUser()['success']) {
            $stmt = self::_prepareRequest("DELETE FROM ".$table." WHERE ".$sql, $params);
            return self::_executeQuery($stmt);
        }
        return false;
    }

    /**
    * @param string $table
    * @param string $sql
    * @param array $params
    * @return Boolean
    */
    public static function updateDBDatas($table, $sql, array $params = [])
    {
        if(self::$user || self::getCurrentUser()['success']) {
            $stmt = self::_prepareRequest("UPDATE ".$table." SET ".$sql, $params);
            return self::_executeQuery($stmt);
        }
        return false;
    }


    private static function _prepareRequest ($sql, $a_bind_params)
    {

        $type_st = ["integer" => 'i', "string" => 's', "double" => 'd', "blob" => 'b'];
        $type = [];
        foreach($a_bind_params as &$param) {
            $param = htmlspecialchars($param); //XSS securisation
            $type[] = $type_st[gettype($param)];
        }
        unset($param);
        $a_params = array();
        $param_type = '';
        $n = count($type);
        for($i = 0; $i < $n; $i++) {
            $param_type .= $type[$i];
        }
        $a_params[] = &$param_type;
        for($i = 0; $i < $n; $i++) {
            $a_params[] = &$a_bind_params[$i];
        }

        if(($stmt = self::$_mysqli->prepare($sql)) === false) {
            Log::error(
                "Wrong SQL: {query} error. {errno} {error}",
                ['query' => $sql, 'errno' => self::$_mysqli->errno, 'error' => self::$_mysqli->error]
            );
        }
        call_user_func_array(array($stmt, 'bind_param'), $a_params);
        return $stmt;
    }

    private static function _executeQuery (&$stmt)
    {
        if(!$stmt->execute()) {
            Log::error(
                "Error to execute SQL query {error}", ['error' => $stmt->error]
            );
            return false;
        }
        return true;
    }

}
