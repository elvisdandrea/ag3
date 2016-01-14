<?php

class FinanciamentoController extends Zend_Controller_Action {

    public function indexAction() {

        $this->view->bodyClass = 'pg-interna';
        $vista = Services::get('vista_rest');
        $this->view->listas = $vista->getListasBusca();


    }
}