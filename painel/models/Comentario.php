<?php

class Comentario extends Model{
    public function inserir($mensagem,$id_aluno){
        $sql = "INSERT INTO comentarios(id_aluno,mensagem) VALUES(:id_aluno,:mensagem)";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id_aluno",$id_aluno);
        $sql->bindValue(":mensagem",$mensagem);
        
        return $sql->execute();
    }
}
