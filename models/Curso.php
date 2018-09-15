<?php

class Curso extends Model{
    
    private $id;
    private $info;
    public function __construct($id = '') {
        parent::__construct();
        if(!empty($id)){			
            $this->id = $id;
        };
    }
    public function where($campo, $condicao, $valores, $tabela = "cursos") {
        $resultado = parent::where($campo, $condicao, $valores, $tabela);
        return $resultado;
    }
    public function all($tabela = "cursos") {
        $resultado = parent::all($tabela);
        return $resultado;
    }
    public function insert($campo, $valor_campo, $tabela = 'cursos') {
        parent::insert($campo, $valor_campo, $tabela);
    }

    public function delete($condicao, $valor_condicao, $tabela = 'cursos') {
        parent::delete($condicao, $valor_condicao, $tabela);
    }
    public function update($campo, $valor_campo, $condicao, $valor_condicao, $tabela = 'cursos') {
        parent::update($campo, $valor_campo, $condicao, $valor_condicao, $tabela);
    }

    public function getCursos(){
        $cursos = $this->all();     
        return $cursos;
    }
    public function getCursosDoAluno($id_aluno){
        $cursos = array();
        $sql = "SELECT ac.id_curso as id,c.nome,c.imagem,c.descricao FROM aluno_curso  ac LEFT JOIN cursos c ON ac.id_curso = c.id "
              ."WHERE ac.id_aluno = ".$id_aluno;
        
        $sql = $this->db->query($sql);
        if($sql->rowCount() > 0){
            $cursos = $sql->fetchAll();
            
        }
        
        return $cursos;
    }
    public function getCursosDoInstrutor($instrutor_id){
        $cursos = $this->where(
                ['*'], 
                ['instrutor_id'],
                [$instrutor_id]);
        
        return $cursos;
    }
    public function getInstrutorID($id){
        $resultado = $this->where(
                ['instrutor_id'],
                ['id'] , 
                [$id]
        );
        
        return $resultado[0]['instrutor_id'];
    }
    public function autorizaAcessoInstrutor($id_curso){
        $id_instrutor = $this->getInstrutorID($id_curso);

        if($id_instrutor != $_SESSION['logado']){
            $_SESSION['erro'] = 'Você não tem permissão para acessar essa bosta';
            header('Location:'.BASE_URL);
            exit;
        }
    }
    public function setCurso($id){
        $sql = 'SELECT * FROM cursos WHERE id = '.$id;
        
        $sql = $this->db->query($sql);
        
        if( $sql->rowCount() > 0 ){
            $this->info = $sql->fetch();
        }
    }
    public function getInfo(){
        return $this->info;
    }

    public function getNome(){
        return $this->info['nome'];
    }
    public function getImagem(){
        return $this->info['imagem'];
    }
    public function getDescricao(){
        return $this->info['descricao'];
    }
    
}