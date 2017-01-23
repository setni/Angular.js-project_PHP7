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
            self::$instance = new self;
        }
    }

    private function __construct ()
    {
        self::$node = new Node();
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
        self::$fileInfo = $file = self::_createTmpFile($file, $filename);

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
    * @param $parentNodeId
    */
    public static function moveFile (int $parentNodeId)
    : array
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
