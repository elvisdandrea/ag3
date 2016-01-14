<?php

/**
 * Class IndexController
 *
 * The Main Project starts here
 *
 * For everyone editing this, please check the rules:
 *
 * - Do not code PSR, it sucks
 * - Brackets are on the same line of the method
 * - If you don't sacrifice readability for brevity, you are a pussy
 * - Real code has real small methods reusing functions as much as possible
 * - This means that low level code must be on the core, not on your method
 *
 */
class Admin_IndexController extends Zend_Controller_Action
{

    public function indexAction() {


    }

    public function findAction(){
        //require_once '/admin/model/AdminModel.php';
        $id = $this->getRequest()->getParam('id');
        $model = new Admin_Model_AdminModel();
        $result = $model->find($id);
        echo'<pre>';print_r($result);exit;
    }

}

