<?php

class Aluno extends Model{
    
    private $info;
    
    public function __construct($id = '') {
        parent::__construct();
        if(!empty($id)){			
            $this->id = $id;
        };
    }
    public function where($campo, $condicao, $valores, $tabela = "alunos") {
        $resultado = parent::where($campo, $condicao, $valores, $tabela);
        return $resultado;
    }
    public function all($tabela = "alunos") {
        $resultado = parent::all($tabela);
        return $resultado;
    }
    public function insert($campo, $valor_campo, $tabela = 'alunos') {
        parent::insert($campo, $valor_campo, $tabela);
    }

    public function delete($condicao, $valor_condicao, $tabela = 'alunos') {
        parent::delete($condicao, $valor_condicao, $tabela);
    }
    public function update($campo, $valor_campo, $condicao, $valor_condicao, $tabela = 'alunos') {
        parent::update($campo, $valor_campo, $condicao, $valor_condicao, $tabela);
    }

    public function getAlunos(){
        $alunos = $this->all();
        
        foreach ($alunos as $chave => $aluno){
            $alunos[$chave]['total_cursos'] = $this->getTotalCursos($aluno['id']);
        }      
        return $alunos;
    }
    
    public function getTotalCursos($id_aluno){
        $total_cursos= $this->where(
            ['count(id_curso) as total_cursos'],
            ['id_aluno'],
            [$id_aluno],
            'aluno_curso'    
        );
        
        return $total_cursos[0]['total_cursos'];
    }
    
    public function existeAluno($email){
        $sql = "SELECT email FROM alunos WHERE email = :email";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":email",$email);

        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }

        return false;
    }
    
    public function inserirAluno($nome,$email,$senha){
        $this->insert(
            ['nome','email','senha'], 
            [$nome,$email,$senha]
        );
    }
    
    public function setAluno($id){
        if(isset($id)){
            $sql = 'SELECT * FROM alunos WHERE id = "'.$id.'"';
            $sql = $this->db->query($sql);
            
            if($sql->rowCount() > 0){
                $this->info = $sql->fetch();           
            }
        }
    }
    
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
    
    public function getCursosMatriculado($id_aluno){
        $curso = new Curso;
        
        $cursos = $curso->where(
                ['*'], 
                ['id_aluno'], $valores);
    }

    public function getNome(){
        return $this->info['nome'];
    }
    public function getID(){
        return $this->info['id'];
    }
    public function getInfo(){
        return $this->info;
    }
}
