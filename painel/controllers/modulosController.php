<?php

class modulosController extends Controller{
    private $modulo;
    public function __construct() {
        $this->modulo = new Modulo();
    }

    public function index(){
        
    }
    public function adicionar(){
        $id_curso = filter_input(INPUT_POST, 'id_curso',FILTER_VALIDATE_INT);
        $nome_modulo = filter_input(INPUT_POST, 'modulo',FILTER_SANITIZE_STRING);
 
        $this->modulo->addModulo($nome_modulo,$id_curso); 
        $modulos = $this->modulo->getModulos($id_curso);
        
        echo json_encode($modulos);
    }

    public function deletar(){
        //echo "Deletando módulo:".$id;
        
        $id = filter_input(INPUT_POST, 'id',FILTER_VALIDATE_INT);
        $modulo = $this->modulo->getModulo($id);
        $id_curso = $modulo['id_curso'];
        $this->modulo->excluir($id);
        $modulos = $this->modulo->getModulos($id_curso);
        
        echo json_encode($modulos);

    }
    
    public function editar(){
        $id = filter_input(INPUT_POST, 'id',FILTER_VALIDATE_INT);
        $nome_modulo = filter_input(INPUT_POST, 'modulo',FILTER_SANITIZE_STRING);
        
        $id_curso = $this->modulo->getIDCurso($id);
        $this->modulo->editar($id, $nome_modulo);
        
        $modulos = $this->modulo->getModulos($id_curso);
        
        echo json_encode($modulos);
    }
}
