<?php

/**
 * Class VistaRest
 *
 * Implementation of Vista Requests
 */
class VistaRest extends Vista {

    /**
     * Class setup
     */
    public function __construct() {
        parent::__construct();
    }

    public function getDestaques() {

        $this->setVistaMethod('imoveis', 'destaques');
        $this->addFieldParam('Categoria');
        $this->addFieldParam('Codigo');
        $this->addFieldParam('Bairro');
        $this->addFieldParam('Cidade');
        $this->addFieldParam('Dormitorios');
        $this->addFieldParam('Destinacao');
        $this->addFieldParam('BanheiroSocialQtd');

        $this->execute();

    }

    public function getListasBusca() {

        $buscaSession = new Zend_Session_Namespace('buscas');

        if (isset($buscaSession->busca)) return $buscaSession->busca;

        $this->setVistaMethod('imoveis', 'listarConteudo');
        $this->addFieldParam('Categoria');
        $this->addFieldParam('Bairro');
        $this->addFieldParam('Cidade');
        $this->addFieldParam('Destinacao');

        $this->execute();

        $result = $this->getResult();

        asort($result['Cidade'], SORT_ASC);
        array_unshift($result['Cidade'], 'SÃO LEOPOLDO');

        $buscaSession->busca = $result;
        return $result;
    }

    public function buscaImoveis(array $filtros, array $pagination = array(), $order = array()) {

        $this->setVistaMethod('imoveis', 'listar');

        $this->addFieldParam('Codigo');
        $this->addFieldParam('Categoria');
        $this->addFieldParam('Bairro');
        $this->addFieldParam('Cidade');
        $this->addFieldParam('ValorVenda');
        $this->addFieldParam('ValorIptu');
        $this->addFieldParam('ValorLocacao');
        $this->addFieldParam('ValorCondominio');
        $this->addFieldParam('MostrarValorVenda');
        $this->addFieldParam('Dormitorios');
        $this->addFieldParam('BanheiroSocialQtd');
        $this->addFieldParam('Empreendimento');
        $this->addFieldParam('Suites');
        $this->addFieldParam('Vagas');
        $this->addFieldParam('AreaTotal');
        $this->addFieldParam('AreaPrivativa');
        $this->addFieldParam('AreaTerreno');
        $this->addFieldParam('DimensoesTerreno');
        $this->addFieldParam('FotoDestaque');
        $this->addFieldParam('FotoDestaquePequena');
        $this->addFieldParam('Destinacao');
        $this->addFieldParam('Latitude');
        $this->addFieldParam('Longitude');

        if (isset($pagination['pagina']) && isset($pagination['quantidade'])) {
            $this->setPaginationParam($pagination['pagina'], $pagination['quantidade']);
        }

        if (count($order) > 0) {
            foreach ($order as $field => $value) $this->addOrderParam($field, $value);
        }

        empty($filtros) || $this->addFilterParam($filtros);

        $this->execute();
    }

    public function getDadosImovel($imoCodigo){
        $this->setVistaMethod('imoveis', 'detalhes');

        $this->addParam('imovel', $imoCodigo);

        $this->addFieldParam('Codigo');
        $this->addFieldParam('Categoria');
        $this->addFieldParam('Bairro');
        $this->addFieldParam('Cidade');
        $this->addFieldParam('ValorVenda');
        $this->addFieldParam('ValorIptu');
        $this->addFieldParam('ValorLocacao');
        $this->addFieldParam('ValorCondominio');
        $this->addFieldParam('MostrarValorVenda');
        $this->addFieldParam('Dormitorios');
        $this->addFieldParam('Empreendimento');
        $this->addFieldParam('Descricao');
        $this->addFieldParam('BanheiroSocialQtd');
        $this->addFieldParam('Suites');
        $this->addFieldParam('Vagas');
        $this->addFieldParam('AreaTotal');
        $this->addFieldParam('AreaPrivativa');
        $this->addFieldParam('AreaTerreno');
        $this->addFieldParam('DimensoesTerreno');
        $this->addFieldParam(array('Foto'  => array('Foto', 'FotoPequena', 'Destaque')));
        $this->addFieldParam(array('Video' => array('Video', 'Descricao')));
        $this->addFieldParam('Caracteristicas');
        $this->addFieldParam('InfraEstrutura');
        $this->addFieldParam('Destinacao');
        $this->addFieldParam('Latitude');
        $this->addFieldParam('Longitude');

        $this->execute();
    }

    public function getAuthEmail() {

        $this->setVistaMethod(false, 'emailauth');
        $this->setEmptyBody(true);
        $this->execute();

    }

    public function getDadosAgencias() {

        $this->setVistaMethod('agencias', 'listar');
        $this->addFieldParam('Codigo');
        $this->addFieldParam('Nome');
        $this->addFieldParam('E-mail');
        $this->addFieldParam('Fone');

        $this->execute();
    }

    public function getDadosUsuarios() {

        $this->setVistaMethod('usuarios', 'listar');
        $this->addFieldParam('Nome');
        $this->addFieldParam('Fone');
        $this->addFieldParam('Celular');
        $this->addFieldParam('E-mail');
        $this->addFieldParam('Equipesite');
        $this->addFieldParam('Foto');
        $this->addFieldParam('CRECI');
        $this->addFilterParam(array('Equipesite' => array('!=','')));
        $this->addFilterParam(array('Exibirnosite' => 'Sim'));
        $this->addFilterParam(array('Inativo' => 'Nao'));
        $this->addOrderParam('Equipesite', 'asc');
        $this->setPaginationParam(1, 50);
        $this->execute();

        return $this->getResult();
    }

}