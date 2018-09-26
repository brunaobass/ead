<?php

class Model{

    protected $db;
    private $itemPorPagina = 8;
    public function __construct(){
            global $db;
            $this->db = $db; 
    }
    protected function query($sql){
        $resultado = $this->db->query($sql);
        
        if($resultado->rowCount()> 0 ){
            $resultado = $resultado->fetchAll();
        }

        return $resultado;
    }
    protected function all($tabela){
        $resultado = array();
        $sql = "SELECT * FROM ".$tabela;
        
        $sql = $this->db->query($sql);
        
        if($sql->rowCount() > 0){
            $resultado = $sql->fetchAll();
        }
        
        return $resultado;
    }
    protected function getTotalItens($tabela){

        $sql = "SELECT COUNT(*) as total FROM ".$tabela;
        
        $sql = $this->db->query($sql);      
        $resultado = $sql->fetch();
  
        return $resultado['total'];
    }

    public function pagination($pagina_atual,$tabela){
        $limit = $this->itemPorPagina;
        
        $offset = ($pagina_atual*$limit)-$limit;
        $sql = 'SELECT * FROM '.$tabela.' LIMIT '.$offset.','.$limit;
        $resultado = array();
        $query = $this->db->query($sql);
        if($query->rowCount() > 0){
            $resultado = $query->fetchAll();
        }

        return $resultado;        
    }
    public function getNumPaginas(){
        $total_cursos = $this->getTotalCursos();
        $num_paginas = ceil($total_cursos/ $this->itemPorPagina);
        
        return $num_paginas;
    }
    protected function where($campo,$condicao,$valores,$tabela){
        
        $resultado = array();
        $campos = implode(',',$campo);
        $cond = "";   
        $num_condicoes = count($condicao);
        
        for($i=0;$i<$num_condicoes;$i++){
            
            $cond .= $condicao[$i]." = :".$condicao[$i];
            if($i<($num_condicoes-1)){
                $cond .= " AND ";
            }
        }
        $sql = "SELECT ".$campos." FROM ".$tabela." WHERE ".$cond;
        $sql = $this->db->prepare($sql);
        
        for($i=0;$i<count($condicao);$i++){
            $sql->bindValue(':'.$condicao[$i],$valores[$i]);
        }
        
        $sql->execute();
        
        if($sql->rowCount() > 0){
            $resultado = $sql->fetchAll();
        }
        
        return $resultado;   
    }
    protected function insert($campo,$valor_campo,$tabela){

        $set = $this->getSET($campo);
        $sql = "INSERT INTO ".$tabela.' SET '.$set;

        $sql = $this->db->prepare($sql);
        for($i=0;$i<count($campo);$i++){
            $sql->bindValue(':'.$campo[$i],$valor_campo[$i]);
        }
        
        $sql->execute();
        
        $id_aula = $this->db->lastInsertId();
        return $id_aula;
          
    }
    protected function update($campo,$valor_campo,$condicao,$valor_condicao,$tabela){

        $set = $this->getSET($campo);
        $cond = $this->getCondicao($condicao);
        $sql = "UPDATE ".$tabela.' SET '.$set." WHERE ".$cond;

        $sql = $this->db->prepare($sql);
        for($i=0;$i<count($campo);$i++){
            $sql->bindValue(':'.$campo[$i],$valor_campo[$i]);
        }
        for($i=0;$i<count($condicao);$i++){
            $sql->bindValue(':'.$condicao[$i],$valor_condicao[$i]);
        }
        
        $sql->execute();
            
    }
    
    protected function delete($condicao,$valor_condicao,$tabela){

        $cond = $this->getCondicao($condicao);
        $sql = "DELETE FROM ".$tabela." WHERE ".$cond;      
        $sql = $this->db->prepare($sql);
        
        for($i=0;$i<count($condicao);$i++){
            $sql->bindValue(':'.$condicao[$i],$valor_condicao[$i]);
        }
        $sql->execute();
            
    }
    private function getSET($campo){
        $num_campos = count($campo);
        $query = '';
        
        for($i=0;$i< $num_campos;$i++){
            $query.=$campo[$i].' = :'.$campo[$i];
            if($i<($num_campos-1)){
                $query.=',';
            }          
        }
        
        return $query;
    }
    
    private function getCondicao($condicao){
       $cond = "";
       $num_condicoes = count($condicao);
        for($i=0;$i<$num_condicoes;$i++){
            $cond .= $condicao[$i]." = :".$condicao[$i];
            if($i<($num_condicoes-1)){
                $cond .= " AND ";
            }
        }
        
        return $cond;
    }
}