<?php

class SiteMapController extends Zend_Controller_Action {


    public function indexAction() {

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $defaultItems = array(
            $this->view->serverUrl() . BASEDIR          => '1.00000',
            $this->view->serverUrl() . BASEDIR. '/fale-conosco'  => '0.80000',
            $this->view->serverUrl() . BASEDIR. '/quem-somos'    => '0.80000',
            $this->view->serverUrl() . BASEDIR. '/imoveis/listagem?oportunidades=Sim&e=oportunidades' => '0.80000',
            $this->view->serverUrl() . BASEDIR. 'imoveis/listagem?lancamento=Sim&e=lancamentos'       => '0.80000',
            $this->view->serverUrl() . BASEDIR. 'bairros/listagem'       => '0.80000'
        );

        $xml = new SimpleXMLElement('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
        foreach ($defaultItems as $urlItem => $priority) {
            $url = $xml->addChild('url');
            $url->addChild('loc', htmlentities($urlItem));
            $url->addChild('lastmod', date('Y-m-dTh:i:s+00:00'));
            $url->addChild('changefreq', 'monthly');
            $url->addChild('priority', $priority);
        }

        $vista = Services::get('vista_rest');
        $totalPages = 2;

        for ($page = 1; $page < $totalPages; $page++) {
            $vista->setPaginationParam($page, 50);
            $vista->buscaImoveis(array());
            $totalPages = intval($vista->getTotalPages());

            $result = $vista->getResult();

            foreach ($result as $row) {
                $url = $xml->addChild('url');
                $url->addChild('loc',  $this->view->serverUrl() . BASEDIR . '/imoveis/detalhes/codigo/' . $row['Codigo'] . '/' . $row['Categoria'] . '/' . $row['Bairro'] . (intval($row['Dormitorios']) > 0 ? '-' . $row['Dormitorios'] : '') . '/Zona+Sul-Porto+Alegre');
                $url->addChild('lastmod', date('Y-m-dTh:i:s+00:00'));
                $url->addChild('changefreq', 'monthly');
                $url->addChild('priority', '0.90000');
            }

        }

        file_put_contents(APPLICATION_PATH . '/../public/sitemap.xml', $xml->asXML());

    }

}