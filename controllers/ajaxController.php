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
            echo 'Falha ao marcar aula como assistida';
        }
    }
    
    public function desmarcar_assistido(){
        if(isset($_POST['id'])){
            $id = filter_input(INPUT_POST, 'id',FILTER_VALIDATE_INT);
            $aula = new Aula();
            $aula->desmarcarAssistido($id);
        }
        else{
            echo 'Falha ao desmarcar aula como assistida';
        }
    }
    
    public function verifica_assistido(){
        if(isset($_POST['id'])){
            $id = filter_input(INPUT_POST, 'id',FILTER_VALIDATE_INT);
            $aula = new Aula();
            echo $aula->verificaAulaAssistida($id);
        }
        else{
            echo 'Falha ao verificar se aula foi assistida';
        }
    }
}
