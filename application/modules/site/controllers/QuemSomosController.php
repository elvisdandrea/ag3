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
        $vista = Services::get('vista_rest');
        $users = $vista->getDadosUsuarios();

        $grouped = array();
        array_walk($users, function($user) use(&$grouped){
            $group = String::RemoveIndex($user['Equipesite']);
            $grouped[$group][] = $user;
        });

        $title      = 'Equipe AG3 Imóveis';
        if ($this->getRequest()->getParam('t') == 'corretores') {
            $title = 'Corretores';
            $grouped = array(
                'Corretores' => $grouped['Corretores']
            );
        }

        $this->view->showGroups = $this->getRequest()->getParam('t') != 'corretores';
        $this->view->title = $title;
        $this->view->users = $grouped;
    }

    public function empresaAction() {


    }
}