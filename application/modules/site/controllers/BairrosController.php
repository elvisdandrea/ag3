<?php

class BairrosController extends Zend_Controller_Action {


    public function indexAction() {

        $this->view->bodyClass = 'pg-interna';

        $vista = Services::get('vista_rest');
        $this->view->listas = $vista->getListasBusca();

        $bairro = Gravi_Service_ImochatService::getBairros($this->getRequest()->getParam('id'));
        $this->view->bairro = $bairro['hoods'];

        $refs = explode(PHP_EOL, $bairro['hoods']['refs']);
        $this->view->refs = $refs;

        $imgs = json_decode($bairro['hoods']['imgs']);
        $this->view->images = $imgs;

    }

    public function listagemAction() {

        $this->view->bodyClass = 'pg-interna';

        $vista = Services::get('vista_rest');
        $this->view->listas = $vista->getListasBusca();

        $bairros = Gravi_Service_ImochatService::getBairros();
        $this->view->bairros = $bairros['hoods'];


    }


}