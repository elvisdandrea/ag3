<?php

class Admin_Model_AdminModel{

    private $_dbAdapter = null;

    public function __construct(){
        $this->_dbAdapter = Zend_Db_Table::getDefaultAdapter();
    }

    public function find($id){
        $select = $this->_dbAdapter->select()->from('test_table');

        if(!empty($id))
            $select->where('id = ?', $id);

        //exit($select->assemble());
        $data = $this->_dbAdapter->fetchRow($select);
        return !empty($data) ? $data->toArray() : null;
    }

    public function insert($id, $field){
        $data = array(
            'id' => $id,
            'data_field' => $field,
        );

        $this->_dbAdapter->insert('test_table', $data);

    }

    public function update($id, $field){
        $update = array(
            'data_field' => $field
        );

        $where = array();
        $where[] = $this->_dbAdapter->quoteInto('id = ?', $id);

        $rowsCount = $this->_dbAdapter->update('test_table', $update, $where);

        return $rowsCount;
    }

    public function delete($id){
        $where = $this->_dbAdapter->quoteInto('id = ?', $id);

        $rowsCount = $this->_dbAdapter->update('test_table', $where);

        return $rowsCount;
    }

    public function findLimiteIngressosUsuarioEvento($eveCodigo, $usuCodigo){
        $statusIngressosResevadosVendidosUsados = new Zend_Db_Expr('(2,3,5)');
        $countIngressos = new Zend_Db_Expr('COUNT(ing.ing_codigo)');

        $select = $this->_dao->select()->setIntegrityCheck(false)->from(array('ing' => 'ingresso'), array('reservados' => $countIngressos))
            ->joinInner(array('eve' => 'evento'), 'eve.eve_codigo = ing.eve_codigo', array('total' => 'eve_qtd_ingressos'))
            ->where('sti_codigo IN ?', $statusIngressosResevadosVendidosUsados)
            ->where('ing.eve_codigo = ?', $eveCodigo)
            ->where('ing.usu_codigo = ?', $usuCodigo)
            ->group('eve.eve_qtd_ingressos');

        $dados = $this->_dao->fetchRow($select);
        return !empty($dados) ? $dados->toArray() : null;
    }

}