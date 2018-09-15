<?php

class modulosController extends Controller{
    private $modulo;
    private $instrutor;
    private  $curso;
    public function __construct() {
        $this->modulo = new Modulo();
        $this->instrutor = new Usuario();
        $this->curso = new Curso();
    }

    public function index(){
        
    }
    public function adicionar(){
        $id_curso = filter_input(INPUT_POST, 'id_curso',FILTER_VALIDATE_INT);
        $this->curso->autorizaAcessoInstrutor($id_curso);

        $nome_modulo = filter_input(INPUT_POST, 'modulo',FILTER_SANITIZE_STRING);
        
        if(!empty($nome_modulo)){
            $this->modulo->addModulo($nome_modulo,$id_curso); 
            $_SESSION['success'] = 'Módulo criado com sucesso!';
        }
        else{
            $_SESSION['erro'] = 'Digite o módulo antes de adicionar!';
        }
        //$modulos = $this->modulo->getModulos($id_curso);
        
        //echo json_encode($modulos);
        header('Location:'.BASE_URL.'cursos/atualizar/'.$id_curso);
        exit;
    }

    public function deletar(){
        //echo "Deletando módulo:".$id;
        
        $id = filter_input(INPUT_POST, 'id',FILTER_VALIDATE_INT);
        $modulo = $this->modulo->getModulo($id);
        $id_curso = $modulo['id_curso'];
        
        $this->curso->autorizaAcessoInstrutor($id_curso);
        
        $this->modulo->excluir($id);
        $modulos = $this->modulo->getModulos($id_curso);
        
        echo json_encode($modulos);

    }
    
    public function editar($id_modulo){
        $id = filter_var($id_modulo,FILTER_VALIDATE_INT);
        $nome_modulo = filter_input(INPUT_POST, 'modulo',FILTER_SANITIZE_STRING);
        
        $id_curso = $this->modulo->getIDCurso($id);
        $this->curso->autorizaAcessoInstrutor($id_curso);
        
        if(!empty($nome_modulo)){
            $this->modulo->editar($id, $nome_modulo);
            $_SESSION['success'] = 'Módulo editado com sucesso!';
        }
        
        header('Location:'.BASE_URL.'cursos/atualizar/'.$id_curso);
        exit;
        //$modulos = $this->modulo->getModulos($id_curso);
        
        //echo json_encode($modulos);
    }
    
    
}
