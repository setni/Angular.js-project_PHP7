<?php

namespace models;

use models\mysql\Mysql;
use models\mysql\SessionManager;
use models\mysql\Role;

class Node {

    /**
    * @var Object Mysqli connect
    *
    */
    private $mysql;

    public function __construct ()
    {
        $this->mysql = Mysql::getInstance();
    }

    public function getNodes ()
    {
        $dataSet = $this->mysql->getDBDatas("
          SELECT node_ID, parentNode_ID, path, record_name, authUsers, lastModif FROM nodes
        ")->toArrayAssoc();
        if($dataSet['success']) {
            if(Role::checkRoles((array) str_split($dataSet['session']["roles"]))) {
                $id = $dataSet['session']["id"];
                $arrayReturn = [];
                foreach($dataSet['result'] as $key => $value) {
                    $authUsers = explode("|", $value['authUsers']);
                    if(in_array($id, $authUsers)) {
                        unset($value['authUsers']);
                        $arrayReturn[] = $value;
                    }
                }
                return ['success' => true, 'result' => $arrayReturn];
            } else {
                return ['success' => false, 'message' => 'You have not the permission'];
            }
        }
        return ['success' => false, 'message' => 'You have not the permission'];
    }

    /**
    * @param int $nodeId
    * @return array detail
    *
    */
    public function getNode ($nodeId)
    {
        $dataSet = $this->mysql->getDBDatas("
          SELECT node_ID, parentNode_ID, path, record_name, authUsers, lastModif FROM nodes WHERE node_ID = ?
        ", [$nodeId])->toObject();

        if($dataSet['success']) {
            //var_dump( $dataSet['session']);
            if(Role::checkRoles((array) str_split($dataSet['session']["roles"]))) {

                unset($dataSet['session']);
                return ['success' => true, 'result' => $dataSet['result']];
                //Action sur les roles
            } else {
                return ['success' => false, 'message' => 'You have not the permission'];
            }
        }
        return ['success' => false, 'message' => 'You have not the permission'];
    }

    /**
    * @param int $parentNodeId
    * @param string $name
    * @param Boolean $isDirectory
    * @return array $path (of parentNode)
    *
    */
    public function setNode ($nodeId, $name, $isDir = false)
    {
        $check = $this->getNode($nodeId);

        if($check['success']) {
            $nodePath = ($nodeId == 0) ? "/".$name : $check['result']->path.$name;
        } else {
            return $check;
        }
        if($isDir) {
            $paramArray = [$nodeId, $nodePath."/", $name, SessionManager::getSession()['id']."|"];
            $this->_createDir($nodePath);
        } else {
            $paramArray = [$nodeId, $nodePath, $name, SessionManager::getSession()['id']."|"];
        }

        $nodeId = $this->mysql->setDBDatas(
            "nodes",
            "(parentNode_ID, path, record_name, authUsers, lastModif) VALUE (?,?,?,?, NOW())",
            $paramArray
        );
        return $nodeId ? ['success' => true, 'result' => ['path' => $nodePath, 'nodeId' => $nodeId]]
            : ['success' => false, 'message' => "erreur à la création du node"];
    }

    /**
    * @param int $nodeId
    * @return Boolean
    * This function check if the nodeID exist, if the user has the power of this nodeId and if the deletion works fine
    */
    public function unsetNode ($nodeId)
    {
        $nodeInfo = $this->getNode($nodeId);

        if($nodeInfo['success']) {
            $userId = SessionManager::getSession()['id'];
            $authUsers = explode("|", $nodeInfo['result']->authUsers);
            if(in_array($userId, $authUsers)) {
                //var_dump($nodeId);
                if($this->mysql->unsetDBDatas(
                        "nodes",
                        "node_ID = ? OR parentNode_ID = ?",
                        [$nodeId, $nodeId]
                    )
                ){
                    if(is_dir(USERDIR.$nodeInfo['result']->path)) {
                        $this->_rrmdir(USERDIR.$nodeInfo['result']->path);
                    } else {
                        unlink(USERDIR.$nodeInfo['result']->path);
                    }
                    return ['success' => true];
                }
                return ['success' => false];
            }
            return ['success' => false];
        }
        return ['success' => false];
    }

    private function _rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                     if (is_dir($dir."/".$object))
                       $this->_rrmdir($dir."/".$object);
                     else
                       unlink($dir."/".$object);
                }
            }
            rmdir($dir);
        }
    }

    private function _createDir (&$nodePath)
    {
        $nodePath .= "/";
        $oldmask = umask(0);
        mkdir(USERDIR.$nodePath, 0777);
        umask($oldmask);
    }
}
