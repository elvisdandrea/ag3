<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 25/07/2015
 * Time: 20:55
 */

class ImoveisController extends Zend_Controller_Action{

    public function listagemAction(){
        if($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setRender('lista-imoveis');
        }
        else
            $this->view->headScript()->appendFile($this->view->serverUrl().BASEDIR.'/res/js/imoveis.js');

        $this->view->bodyClass = 'pg-interna';

        $vista = Services::get('vista_rest');
        $this->view->listas = $vista->getListasBusca();

        $vista->reset();

        $params = $this->_request->getQuery();

        if (!empty($params['codigo'])) {
            $this->redirect($this->view->serverUrl() . BASEDIR . '/imoveis/detalhes/codigo/' . $params['codigo']);
            return;
        }

        $filtros = array();

        empty($params['tipo'])       || $filtros['Categoria'] = $params['tipo'];
        empty($params['cidade'])     || $filtros['Cidade']    = $params['cidade'];
        empty($params['bairros'])    || $filtros['Bairro']    = $params['bairros'];
        empty($params['codigo'])     || $filtros['Codigo']    = $params['codigo'];
        empty($params['status'])     || $filtros['Status']    = $params['status'];
        empty($params['vagas'])      || $filtros['Vagas']     = $params['vagas'];
        empty($params['banheiros'])  || $filtros['BanheiroSocialQtd']    = $params['banheiros'];
        empty($params['lancamento']) || $filtros['Lancamento'] = $params['lancamento'];
        empty($params['oportunidades']) || $filtros['OfertaEspecial'] = $params['oportunidades'];

        empty($params['dormitorios']) || $filtros['Dormitorios'] = $params['dormitorios'];

        (empty($params['valor_min']) && empty($params['valor_max'])) || $filtros['ValorVenda'] = array($params['valor_min'], $params['valor_max']);
        (empty($params['area_min']) && empty($params['area_max'])) || $filtros['AreaUtil'] = array($params['area_min'], $params['area_max']);

        if (isset($params['salaofestas']) && $params['salaofestas'] == 'on') $filtros['SalaoFestas'] = 'Sim';
        if (isset($params['churrasqueira']) && $params['churrasqueira'] == 'on') $filtros['Churrasqueira'] = 'Sim';
        if (isset($params['vistapanoramica']) && $params['vistapanoramica'] == 'on') $filtros['VistaPanoramica'] = 'Sim';
        if (isset($params['piscina']) && $params['piscina'] == 'on') $filtros['Piscina'] = 'Sim';
        if (isset($params['piscinacond']) && $params['piscinacond'] == 'on') $filtros['PiscinaCondominio'] = 'Sim';
        if (isset($params['sotao']) && $params['sotao'] == 'on') $filtros['Sotao'] = 'Sim';
        if (isset($params['sacada']) && $params['sotao'] == 'on') $filtros['Sotao'] = 'Sim';
        if (isset($params['terrea']) && $params['terrea'] == 'on') $filtros['Terrea'] = 'Sim';


        if(!empty($params['order'])){

            switch ($params['order']) {
                case 'MaiorValor' :
                    $vista->addOrderParam('ValorVenda', 'desc');
                    break;
                case 'MenorValor' :
                    $vista->addOrderParam('ValorVenda', 'asc');
                    break;
                case 'PorBairro' :
                    $vista->addOrderParam('Bairro', 'asc');
                    break;
            }

        }

        $title = 'Resultado da busca';

        $titles = array(
            'favoritos'         => 'Meus Favoritos',
            'oportunidades'     => 'Grandes Oportunidades',
            'lancamentos'       => 'Lançamentos',
            'semelhantes'       => 'Imóveis Semelhantes'
        );

        if (isset($params['e'])) {

            if ($params['e'] == 'favoritos') {
                $favs = $this->getRequest()->getCookie('favs');
                if (!empty($favs)) {
                    $filtros['Codigo'] = json_decode(base64_decode($favs));
                } else {
                    $filtros['Codigo'] = 0;
                }

                $this->view->headScript()->appendFile($this->view->serverUrl().BASEDIR.'/res/js/favoritos.js');
                $this->view->fav = true;
            }

            !isset($titles[$params['e']]) || $title = $titles[$params['e']];

            if ($params['e'] == 'oportunidades') {
                $this->_helper->viewRenderer->setRender('listagem-op');
                $filtros['OfertaEspecial'] = 'Sim';
                $vista->addOrderParam('DataOferta', 'desc');
            }

        }

        $vista->addOrderParam('DataCadastro', 'desc');

        $this->view->title = $title;

        $page = empty($params['page']) ? 1 : $params['page'];

        $vista->setPaginationParam($page, 9);
        $vista->buscaImoveis($filtros);

        $this->view->params  = $params;
        $this->view->imoveis = $vista->getResult();

        Gravi_Service_ImochatService::SaveSearch($filtros, $params);

        $pagination = Zend_Paginator::factory((int)$vista->getTotalItems());
        $pagination->setItemCountPerPage((int)$vista->getResultsPerPage());
        $pagination->setCurrentPageNumber($page);

        $this->view->pagination = $pagination->getPages();
    }

    public function detalhesAction(){
        $vista = Services::get('vista_rest');
        $this->view->listas = $vista->getListasBusca();

        $this->view->bodyClass = 'pg-interna';

        $this->view->headScript()->appendFile($this->view->serverUrl().BASEDIR.'/res/js/detalhes.js');

        $imoCodigo = $this->_request->getParam('codigo');

        Gravi_Service_ImochatService::SavePropertyView($imoCodigo);

        if(empty($imoCodigo)){
            //TODO -- Criar tela de imovel não encontrado
        }

        $vista = Services::get('vista_rest');
        $vista->getDadosImovel($imoCodigo);

        $dadosImovel = $vista->getResult();

        if (empty($dadosImovel['Codigo'])) {
            $this->_helper->viewRenderer('not-found');
        } else {
            $semelhantes = $this->getSemelhantes($dadosImovel);
            $this->view->semelhantes = $semelhantes;

            $form = new Site_Form_FaleConoscoForm();
            $form->mensagem->setValue('Tenho interesse no imóvel código ' . $dadosImovel['Codigo'] .', solicito contato por e-mail');
            $this->view->form = $form;
        }

        $this->view->fav = false;
        $favs = $this->getRequest()->getCookie('favs');
        if (!empty($favs) && in_array($imoCodigo, json_decode(base64_decode($favs)))) $this->view->fav = true;

        $this->view->imovel = $dadosImovel;

    }

    private function getSemelhantes($imovel) {

        $vista = Services::get('vista_rest');
        $vista->reset();

        $similarFields = array(
            'Categoria', 'Bairro', 'Status'
        );

        $filters = array();
        array_walk($similarFields, function($item) use (&$filters, $imovel) {
            !isset($imovel[$item]) ||
                $filters[$item] = $imovel[$item];
        });

        if ($imovel['Dormitorios'] > 0)
            $filters['Dormitorios'] = array('>=', $imovel['Dormitorios']);

        if ($imovel['Vagas'] > 0)
            $filters['Vagas'] = array('>=', $imovel['Dormitorios']);

        $min = (intval($imovel['ValorVenda']) - ((intval($imovel['ValorVenda']) * 20) / 100));
        $max = (intval($imovel['ValorVenda']) + ((intval($imovel['ValorVenda']) * 20) / 100));
        $filters['ValorVenda'] = array($min, $max);

        $filters['Codigo'] = array('!=', $imovel['Codigo']);

        $vista->setPaginationParam(1, 3);
        $vista->buscaImoveis($filters);



        $sem_filters = array(
            'tipo'          => $filters['Categoria'],
            'bairros'       => $filters['Bairro'],
            'valor_min'     => $filters['ValorVenda'][0],
            'valor_max'     => $filters['ValorVenda'][1],
            'codigo'        => $filters['Codigo']
        );

        !isset($filters['Dormitorios']) || $sem_filters['dormitorios'] = $filters['Dormitorios'];
        !isset($filters['Vagas'])       || $sem_filters['vagas'] = $filters['Vagas'];

        $this->view->filter_semelhantes = $sem_filters;

        return $vista->getResult();

    }

    public function addFavAction() {

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $favs = $this->getRequest()->getCookie('favs');

        if (empty($favs)) {
            $favs = array();
        }else{
            $favs = json_decode(base64_decode($favs));
        }

        if (!in_array($this->getRequest()->getParam('codigo'), $favs))
            $favs[] = $this->getRequest()->getParam('codigo');

        setcookie('favs', base64_encode(json_encode($favs)), time() + (2 * 365 * 24 * 60 * 60), '/');

        echo 'Este imóvel é um favorito!';
    }

    public function removeFavAction() {

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $favs = $this->getRequest()->getCookie('favs');

        if (empty($favs)) {
            exit;
        }else{
            $favs = json_decode(base64_decode($favs));
        }

        if (in_array($this->getRequest()->getParam('codigo'), $favs))
            unset($favs[array_search($this->getRequest()->getParam('codigo'), $favs)]);

        setcookie('favs', base64_encode(json_encode($favs)), time() + (2 * 365 * 24 * 60 * 60), '/');

        exit(true);
    }

}