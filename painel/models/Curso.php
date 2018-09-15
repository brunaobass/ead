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
        
        foreach ($cursos as $chave => $curso){
            $cursos[$chave]['total_alunos'] = $this->getTotalAlunos($curso['id']);
        }      
        return $cursos;
    }
    
        public function setCurso($id){
        $sql = 'SELECT * FROM cursos WHERE id = '.$id;
        
        $sql = $this->db->query($sql);
        
        if( $sql->rowCount() > 0 ){
            $this->info = $sql->fetch();
        }
    }
    public function getCurso($id){
        $this->setCurso($id);
        return $this->info;
    }

    public function getInfo(){
        return $this->info;
    }
    
    public function getID(){
        return $this->info['id'];
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
    
    public function getTotalAlunos($id_curso){
        $total_alunos = $this->where(
            ['count(id_aluno) as total_alunos'],
            ['id_curso'],
            [$id_curso],
            'aluno_curso'    
        );
        
        return $total_alunos[0]['total_alunos'];
    }
}