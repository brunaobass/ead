<?php


class ajaxController extends Controller {
    public function __construct() {
        $aluno = new Aluno();
        if(!$aluno->logado()){
            header("Location:".BASE_URL."login");
        }
    }
    
    public function marcar_assistido(){
        
        if(isset($_POST['id'])){
            $id = filter_input(INPUT_POST, 'id',FILTER_VALIDATE_INT);
            $aula = new Aula();
            $aula->marcarAssistido($id);
        }
        else{
            echo 'Deu ruim';
        }
    }
}
