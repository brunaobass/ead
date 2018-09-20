<?php

class Questao extends Model {

    public function where($campo, $condicao, $valores, $tabela = "questoes") {
        $resultado = parent::where($campo, $condicao, $valores, $tabela);
        return $resultado;
    }
    public function insert($campo, $valor_campo, $tabela = 'questoes') {
        parent::insert($campo, $valor_campo, $tabela);
    }
    public function update($campo, $valor_campo, $condicao, $valor_condicao, $tabela = 'questoes') {
        parent::update($campo, $valor_campo, $condicao, $valor_condicao, $tabela);
    }
    public function all($tabela = 'questoes') {
        parent::all($tabela);
    }
    public function delete($condicao, $valor_condicao, $tabela = 'questoes') {
        parent::delete($condicao, $valor_condicao, $tabela);
    }
    public function getQuestoes($id_questionario){
        $questoes = $this->where(['*'],['id_questionario'],[$id_questionario]);
        
        $alt = new Alternativa();
        foreach($questoes as $chave =>$questao){
            $questoes[$chave]['alternativas'] = $alt->getAlternativas($questao['id'],$id_questionario);
        }
        return $questoes;
    }
    public function inserir($id_questionario,$questao){
        echo '<br><br><br>INSERINDO QUESTÃO<br>';
        var_dump($questao);

        $this->insert(
                ['id','id_questionario','pergunta','resposta'],
                [$questao['id'],$id_questionario,$questao['pergunta'],$questao['resposta']]
            );
    }
    public function atualizar($id_questionario,$questao){

        $this->update(
                ['pergunta','resposta'],
                [$questao['pergunta'],$questao['resposta']], 
                ['id','id_questionario'], 
                [$questao['id'],$id_questionario]
            );
    }
    public function excluir($id_questao,$id_questionario){

        $alt = new Alternativa();   
        $alternativas = $alt->getAlternativas($id_questao, $id_questionario);

        foreach ($alternativas as $alternativa){
            $alt->excluir($alternativa['id'],$id_questao, $id_questionario);
        }

        $this->delete(['id','id_questionario'], [$id_questao,$id_questionario]);
        
    }
    
}
