<?php

class Comentario extends Model{

    public function where($campo, $condicao, $valores, $tabela = "comentarios") {
        $resultado = parent::where($campo, $condicao, $valores, $tabela);
        return $resultado;
    }
    public function query($sql) {
        return parent::query($sql);
    }
    public function update($campo, $valor_campo, $condicao, $valor_condicao, $tabela = 'comentarios') {
        parent::update($campo, $valor_campo, $condicao, $valor_condicao, $tabela);
    }
    public function insert($campo, $valor_campo, $tabela = 'comentarios') {
        $id_comentario = parent::insert($campo, $valor_campo, $tabela); 
        
        return $id_comentario;
    }
    public function delete($condicao, $valor_condicao, $tabela = 'comentarios') {
        parent::delete($condicao, $valor_condicao, $tabela);
    }
    public function inserir($id_aluno,$id_video,$mensagem){
        return $this->insert(
                ['id_aluno','id_video','mensagem'], 
                [$id_aluno,$id_video,$mensagem]
            );
    }
    
    public function getComentarios($id_video){
        $sql = 'SELECT c.*,u.nome as autor FROM comentarios c INNER JOIN usuarios u ON c.id_aluno = u.id '
                . 'WHERE id_video =  '.$id_video.' ORDER BY data_duvida DESC';
        
        $comentarios = $this->query($sql);
        return $comentarios;
    }
    
    private function getAutor($id_aluno){
        $autor = $this->where(
                ['nome'], 
                ['id'], 
                [$id_aluno],
                'usuarios'
            );

        return $autor[0]['nome'];
    }
}
