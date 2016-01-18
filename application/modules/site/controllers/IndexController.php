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
class IndexController extends Zend_Controller_Action
{

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        $this->view->headScript()->appendFile($this->view->serverUrl().BASEDIR.'/res/js/imoveis.js');

        $vista = Services::get('vista_rest');

        $this->view->listas = $vista->getListasBusca();

        $vista->reset();

        $pagination = array(
            'pagina'     => 1,
            'quantidade' => 4
        );

        $banners = Gravi_Service_ImochatService::getBanners();
        $this->view->banners = $banners['banners'];

        $filtroWidget1 = array(
            'Destinacao'     => 'ALUGUEL',
            'EmDestaque'     => 'Sim'
        );

        $order = array('DataCadastro' => 'desc');

        $vista->buscaImoveis($filtroWidget1, $pagination, $order);

        $this->view->widget1      = $vista->getResult();

        $vista->reset();

        $filtroWidget2 = array(
            'Destinacao'     => 'VENDA',
            'EmDestaque'     => 'Sim'
        );

        $pagination = array(
            'pagina'     => 1,
            'quantidade' => 4
        );

        $vista->buscaImoveis($filtroWidget2, $pagination, $order);
        $this->view->widget2 = $vista->getResult();

    }

}
