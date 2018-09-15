<?php

class Video extends Model{
    public function where($campo, $condicao, $valores, $tabela = "videos") {
        $resultado = parent::where($campo, $condicao, $valores, $tabela);
        return $resultado;
    }
    public function update($campo, $valor_campo, $condicao, $valor_condicao, $tabela = 'videos') {
        parent::update($campo, $valor_campo, $condicao, $valor_condicao, $tabela);
    }
    public function insert($campo, $valor_campo, $tabela = 'videos') {
        return parent::insert($campo, $valor_campo, $tabela); 
    }
    public function delete($condicao, $valor_condicao, $tabela = 'videos') {
        parent::delete($condicao, $valor_condicao, $tabela);
    }
    public function getVideoAula($id_aula){
        $video = $this->where(['*'],['id_aula'],[$id_aula]);
        
        return $video[0];
    }
    
    public function atualizar($id_aula,$nome,$descricao,$url){
        $this->update(
                ['nome','descricao','url'],
                [$nome,$descricao,$url], 
                ['id_aula'],
                [$id_aula]
            );  
    }
}
