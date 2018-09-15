<?php

class Modulo extends Model{
    public function __construct() {
        parent::__construct();
    }
    public function all($tabela = 'modulos') {
        return parent::all($tabela);
    }
    public function query($sql) {
        return parent::query($sql);
    }

    public function where($campo, $condicao, $valores, $tabela = 'modulos') {
        return parent::where($campo, $condicao, $valores, $tabela);
    }
    public function insert($campo, $valor_campo, $tabela = 'modulos') {
        parent::insert($campo, $valor_campo, $tabela);
    }
    public function delete($condicao, $valor_condicao, $tabela = 'modulos') {
        parent::delete($condicao, $valor_condicao, $tabela);
    }
    public function update($campo, $valor_campo, $condicao, $valor_condicao, $tabela = 'modulos') {
        parent::update($campo, $valor_campo, $condicao, $valor_condicao, $tabela);
    }

    public function getModulos($id){
        $campo = ['*'];
        $condicao = ['id_curso'];
        $valores = [$id];
        $modulos = $this->where(
                $campo, $condicao, $valores
            );
        
        if(count($modulos) > 0){
            $aula = new Aula();
            
            foreach ($modulos as $mChave => $mDados ){
                $modulos[$mChave]['aulas'] = $aula->getAulasModulo($mDados['id']);
            }
        }
        
        return $modulos;
    }
    public function getModulo($id){
        $modulo = $this->where(['*'], ['id'], [$id]);
        return $modulo[0];
    }
    public function getIDCurso($id){
        $modulo = $this->where(['id_curso'], ['id'], [$id]);
        return $modulo[0]['id_curso'];
    }
    public function addModulo($modulo,$id_curso){
        $this->insert(['nome','id_curso'], [$modulo,$id_curso]);
    }
    public function editar($id,$modulo){
        $this->update(['nome'], [$modulo], ['id'], [$id]);
    }
    public function excluir($id){
        $aula = new Aula();
        $aulas = $aula->getAulasModulo($id);
        
        foreach ($aulas as $aula_modulo){
            $aula->excluir($aula_modulo['id'], $aula_modulo['tipo']);
        }

        $this->delete(['id'], [$id]);
    }
    
    public function existeModulo($id){
        $resultado = $this->where(
                ['id'], 
                ['id'], 
                [$id]
            );
             
        if(!empty($resultado)){
            return true;
        }
        
        return false;
    }
}
