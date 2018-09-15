<?php

class Aluno extends Usuario{
    
    public function isInscrito($id_curso){
        $campo = ['id'];
        $condicao = ['id_curso','id_aluno'];
        $valores = [$id_curso, $this->info['id']];
        $tabela = "aluno_curso";
        $inscrito = $this->where($campo, $condicao, $valores,$tabela);
        
        if(count($inscrito) > 0){
            return true;
        }
        
        return false;
    }
    
}
