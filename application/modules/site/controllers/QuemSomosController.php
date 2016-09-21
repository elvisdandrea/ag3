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
        $groups  = array();

        array_walk($users, function($user) use(&$grouped, &$groups){
            $group    = String::RemoveIndex($user['Equipesite']);
            $groups[] = strtolower($group);
            $grouped[$group][] = $user;
        });

        $title       = 'Equipe AG3 Imóveis';
        $filterGroup = $this->getRequest()->getParam('t');

        if (in_array($filterGroup, $groups)) {
            $title   = ucwords($filterGroup);
            $grouped = array(
                $title => $grouped[$title]
            );
        }

        $this->view->showGroups = !in_array($filterGroup, $groups);
        $this->view->title = $title;
        $this->view->users = $grouped;
    }

    public function empresaAction() {


    }
}