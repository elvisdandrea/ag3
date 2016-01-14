<?php

class QuemSomosController extends Zend_Controller_Action {


    public function indexAction() {

        $this->view->bodyClass = 'pg-interna';
        $vista = Services::get('vista_rest');
        $this->view->listas = $vista->getListasBusca();

        $form = new Site_Form_FaleConoscoForm();
        $this->view->form = $form;
        $params = $this->_request->getParams();

        $this->view->headScript()->appendFile($this->view->serverUrl().BASEDIR.'/res/js/quem-somos.js');

        $users = Gravi_Service_ImochatService::getUsers();

        $grouped = array();
        array_walk($users['users'], function($user) use(&$grouped){
            $grouped[$user['group_name']][] = $user;
        });

        $sorted = array(
            'Diretoria'             => $grouped['Diretoria'],
            'Gerência'              => $grouped['Gerência'],
            'Administrativo'        => $grouped['Administrativo'],
            'Recepção'              => $grouped['Recepção'],
            'Contratos/Pós Venda'   => $grouped['Contratos/Pós Venda'],
        );

        $corretores = $grouped['Corretores'];

        $this->view->groups     = $sorted;
        $this->view->corretores = $corretores;

    }
}