<?php


class Alternativa extends Model{
    public function where($campo, $condicao, $valores, $tabela = "alternativas") {
        $resultado = parent::where($campo, $condicao, $valores, $tabela);
        return $resultado;
    }
    public function insert($campo, $valor_campo, $tabela = 'alternativas') {
        parent::insert($campo, $valor_campo, $tabela);
    }
    public function update($campo, $valor_campo, $condicao, $valor_condicao, $tabela = 'alternativas') {
        parent::update($campo, $valor_campo, $condicao, $valor_condicao, $tabela);
    }
    public function all($tabela = 'alternativas') {
        parent::all($tabela);
    }
    public function delete($condicao, $valor_condicao, $tabela = 'alternativas') {
        parent::delete($condicao, $valor_condicao, $tabela);
    }
    public function getAlternativas($id_questao,$id_questionario){
        $alternativas = $this->where(
                ['*'], 
                ['id_questao','id_questionario'], 
                [$id_questao,$id_questionario]
            );

        return $alternativas;
    }
    public function inserir($id_questionario,$alternativa){

        foreach($alternativa as $option){
            if(!empty($option['id'])){
                $this->insert(
                    ['id','id_questao','id_questionario','texto'],
                    [$option['id'],$alternativa['id_questao'],$id_questionario,$option['texto']]
                );
            }    
        }
    }
    public function atualizar($id_questionario,$alternativa){

        foreach($alternativa as $option){
            if(!empty($option['id'])){
                $this->update(
                    ['texto'],
                    [$option['texto']], 
                    ['id','id_questao','id_questionario'], 
                    [$option['id'],$alternativa['id_questao'],$id_questionario]
                );
            }    
        }
    }
    public function excluir($id_questao,$id_questionario){
        $this->delete(['id_questao','id_questionario'], [$id_questao,$id_questionario]);
    }
    
}
