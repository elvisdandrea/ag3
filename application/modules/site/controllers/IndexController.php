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

        $filtroBanner = array(
            'SuperDestaqueWeb' => 'Sim'
        );

        $pagination = array(
            'pagina'     => 1,
            'quantidade' => 5
        );


        $vista->buscaImoveis($filtroBanner, $pagination);
        $banners = Gravi_Service_ImochatService::getBanners();
        $this->view->banners = $banners['banners'];

        $vista->reset();

        $filtroWidget1 = array(
            'Lancamento'     => 'Sim',
        );

        $order = array('DataCadastro' => 'desc');

        $vista->buscaImoveis($filtroWidget1, $pagination, $order);

        $this->view->widget1      = $vista->getResult();
        $this->view->widget1Title = 'Lançamentos';

        $vista->reset();

        $filtroWidget2 = array(
            'OfertaEspecial'     => 'Sim'
        );

        $order = array('DataOferta' => 'desc');

        $pagination = array(
            'pagina'     => 1,
            'quantidade' => 6
        );

        $vista->buscaImoveis($filtroWidget2, $pagination, $order);
        $this->view->widget2 = $vista->getResult();

    }

}

