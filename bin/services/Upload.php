<?php

namespace bin\services;

use bin\models\mysql\Mysql;
use bin\models\Node;


/**
* @pattern Singleton
*/
final class Upload {

    /**
    * @var Object Upload()
    *
    */
    private static $instance;

    /**
    * @var Array $checkFile
    *
    */
    private static $checkFile;

    /**
    * @var Array $fileInfo
    *
    */
    private static $fileInfo;

    /**
    * @var Object Node()
    *
    */
    private static $node;

    private static function _getInstance ()
    {
        if(is_null(self::$instance)) {
            self::$instance = new Upload();
        }
    }

    private function __construct ()
    {
        self::$node = new Node();
    }

    private static function _createTmpFile ($file, $filename)
    {
        self::_getInstance();

        $contentFile = substr($file, strpos($file, "base64,")+7);
        $tmpName = md5(uniqid()).".".substr(strrchr($filename, '.'), 1);
        file_put_contents(FILETMPDIR.$tmpName, base64_decode($contentFile));

        return [
            'ext' => pathinfo(FILETMPDIR.$tmpName)['extension'],
            'tmp_name' => FILETMPDIR.$tmpName,
            'name' => $filename,
            'size' => filesize(FILETMPDIR.$tmpName)
        ];
    }

    /**
    * @param array $file (base64 file)
    * @param string $filename
    * @return instance
    */
    public static function checkFile ($file, $filename)
    {
        self::$fileInfo = $file = self::_createTmpFile($file, $filename);

        /*if(count($files) >= MAX_FILE_NUMBER) {
            self::$checkFile = ['success' => false, 'message' => "Vous ne pouvez uploader que ".MAX_FILE_NUMBER." fichiers à la fois"];
        }
        */
        $fileTypes = explode(',', FILE_TYPES);
        if(($length = $file['size']) > MAX_FILE_SIZE) {
            self::$checkFile = ['success' => false, 'message' => "La taille du fichier est trop grande $length pour ".MAX_FILE_SIZE." autorisé"];
        } else if(
            !in_array($file['ext'], $fileTypes)
            && !preg_match("/(".implode(')|(',$fileTypes).")/", mime_content_type($file['tmp_name']))
          ) {
            self::$checkFile = ['success' => false, 'message' => "Type de fichier ".mime_content_type($file['tmp_name'])." non autorisé"];
        }

        self::$checkFile = ['success' => true];
        return self::$instance;
    }

    /**
    * @param Int $parentNodeId
    * @return array
    */
    public static function moveFile ($parentNodeId)
    {
        if(self::$checkFile['success']) {
            if(($token = Mysql::getSession()['APITOKEN']) != "") {
                $newNode = self::$node->setNode($parentNodeId, self::$fileInfo['name'], false);
                if(!$newNode['success']) {
                    return ['success' => false, 'message' => "Erreur à la création du node"];
                }
                rename(self::$fileInfo['tmp_name'], USERDIR.$newNode['path']);
                return $newNode;
            }
        }
        return self::$checkFile;
    }
}
