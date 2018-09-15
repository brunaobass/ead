<?php

class Questionario extends Model{
    public function where($campo, $condicao, $valores, $tabela = "questionarios") {
        $resultado = parent::where($campo, $condicao, $valores, $tabela);
        return $resultado;
    }
    public function insert($campo, $valor_campo, $tabela = 'questionarios') {
        parent::insert($campo, $valor_campo, $tabela);
    }
    public function update($campo, $valor_campo, $condicao, $valor_condicao, $tabela = 'questionarios') {
        parent::update($campo, $valor_campo, $condicao, $valor_condicao, $tabela);
    }
    public function all($tabela = 'questionarios') {
        parent::all($tabela);
    }
    public function delete($condicao, $valor_condicao, $tabela = 'questionarios') {     
        parent::delete($condicao, $valor_condicao, $tabela);
    }

    public function getQuestionarioAula($campo_id,$valor_id){
        $questionario = $this->where(['*'],[$campo_id],[$valor_id]);
        
        $questao = new Questao();        
        $questionario[0]['questoes'] = $questao->getQuestoes($questionario[0]['id']);

        return $questionario[0];
    }
    public function atualizar($id,$nome){
        $this->update(
                ['nome'],
                [$nome],
                ['id'],
                [$id]
        );
    }
    public function excluir($id_aula){
        $questao = new Questao();
        $questionario = $this->getQuestionarioAula('id_aula',$id_aula);

        $questao->excluir($questionario['id']);
        $this->delete(['id'], [$questionario['id']]);
   
    }
    
    public function getIdAula($id){
        $id_aula = $this->where(['id_aula'],['id'],[$id]);
        
        return $id_aula[0]['id_aula'];
    }
}
