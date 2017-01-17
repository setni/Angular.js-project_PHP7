<?php

/***********************************************************************************************
 * Angular->php standard REST API  - Full native php REST API Angular friendly
 *   AjaxController.php Controller for all Ajax request
 * Copyright 2016 Thomas DUPONT
 * MIT License
 ************************************************************************************************/

namespace bin\controllers;

use bin\models\Cart;
use bin\models\Order;
use bin\models\Node;
use bin\models\User;
use bin\services\Upload;

/**
* @pattern Command, VMC
*/
final class AjaxController extends Controller implements APIInterface {

    public function __construct()
    {
        parent::__construct();
    }

    /**
    * @return JSON || false
    *
    */
    public function execute ()
    {
        $funct = "_".$this->request->action;
        $functWhiteList = [
          '_SENDCONTACT',
          '_LOGIN',
          '_GETCART',
          '_GETHOME',
          '_UPLOAD',
          '_CHECKUSER',
          '_REGISTER',
          '_DISCONNECT',
          '_DELETENODE',
          '_CREATEFOLDER'
        ];
        return in_array($funct, $functWhiteList) ? $this->$funct($this->request) : false;
    }

    private function _SENDCONTACT ($request)
    {
        return $request->text;
    }

    private function _LOGIN ($request)
    {
        $user = new User();
        return json_encode($user->login((string) $request->login, (string) $request->password));
    }

    private function _GETCART ($request)
    {
        $cart = new Cart($this->mysql);
        $myCart = $cart->getCart();
        //.....
    }
    private function _GETHOME ()
    {
        $node = new Node();
        return json_encode($node->getNodes());
    }

    private function _UPLOAD ($request)
    {
        return json_encode(
            Upload::checkFile($request->file, $request->filename)->moveFile($request->pNodeId)
        );
    }

    private function _CREATEFOLDER ($request)
    {
        $node = new Node();
        return json_encode($node->setNode($request->nodeId, $request->name, true));
    }

    private function _DELETENODE ($request)
    {
        $node = new Node();
        return json_encode($node->unsetNode($request->nodeId));
    }

    private function _CHECKUSER ()
    {
        $user = new User();
        return json_encode($user->checkUser());
    }

    private function _REGISTER ($request)
    {
        $user = new User();
        $createUser = $user->register((string) $request->login, (string) $request->password);
        return $createUser['success'] ? json_encode($createUser) : "Cet utilisateur éxiste déjà";
    }

    private function _DISCONNECT ()
    {
        $user = new User();
        return json_encode($user->disconnect());
    }
}
