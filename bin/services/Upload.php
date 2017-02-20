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
    private static $_instance;

    /**
    * @var Array $_checkFile
    *
    */
    private static $_checkFile;

    /**
    * @var Array $_fileInfo
    *
    */
    private static $_fileInfo;

    /**
    * @var Object Node()
    *
    */
    private static $_node;

    private static function _getInstance ()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new self;
        }
    }

    private function __construct ()
    {
        self::$_node = new Node();
    }

    private static function _createTmpFile (string $file, string $filename)
    : array
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
    * @param $file (base64 file)
    * @param $filename
    */
    public static function checkFile ($file, $filename)
    : self
    {
        self::$_fileInfo = $file = self::_createTmpFile($file, $filename);

        $fileTypes = explode(',', FILE_TYPES);
        if(($length = $file['size']) > MAX_FILE_SIZE) {
            self::$_checkFile = ['success' => false, 'message' => "La taille du fichier est trop grande $length pour ".MAX_FILE_SIZE." autorisé"];
        } else if(
            !in_array($file['ext'], $fileTypes)
            && !preg_match("/(".implode(')|(',$fileTypes).")/", mime_content_type($file['tmp_name']))
          ) {
            self::$_checkFile = ['success' => false, 'message' => "Type de fichier ".mime_content_type($file['tmp_name'])." non autorisé"];
        }

        self::$_checkFile = ['success' => true];
        return self::$_instance;
    }

    /**
    * @param $parentNodeId
    */
    public static function moveFile (int $parentNodeId)
    : array
    {
        if(self::$_checkFile['success']) {
            if(($token = Mysql::getSession()['APITOKEN']) != "") {
                $newNode = self::$_node->setNode($parentNodeId, self::$_fileInfo['name'], false);
                if(!$newNode['success']) {
                    return ['success' => false, 'message' => "Erreur à la création du node"];
                }
                rename(self::$_fileInfo['tmp_name'], USERDIR.$newNode['path']);
                return $newNode;
            }
        }
        return self::$_checkFile;
    }
}
