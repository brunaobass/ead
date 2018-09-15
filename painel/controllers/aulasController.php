<?php

class aulasController extends Controller{
    private $aula;
    public function __construct() {
        $this->aula = new Aula();
    }

    public function index(){
        
    }
    public function adicionar(){
        $id_curso = filter_input(INPUT_POST, 'id_curso',FILTER_VALIDATE_INT);
        $nome_aula = filter_input(INPUT_POST, 'aula',FILTER_SANITIZE_STRING);
 
        $this->aula->addAula($nome_aula,$id_curso); 
        $aulas = $this->aula->getAulas($id_curso);
        
        echo json_encode($aulas);
    }

    public function deletar(){

        $id = filter_input(INPUT_POST, 'id',FILTER_VALIDATE_INT);
        $aula = $this->aula->getAula($id);

        $id_modulo = $aula['id_modulo'];
        $this->aula->excluir($id,$aula['tipo']);
        $aulas = $this->aula->getAulasModulo($id_modulo);
        $aulas['id_modulo'] = $id_modulo;
        
        echo json_encode($aulas);
    }
    
    public function editar($id){
        $aula = new Aula();
        $modulo = new Modulo();
        
        $dados_aula = $aula->getAula($id);

        $dados = array(
            'title'=> 'Editar aula',
            'css'  => 'curso',
            'modulos' => $modulo->getModulos($dados_aula['id_curso'])
        );
        if($dados_aula['tipo'] == 1){
            $view = 'editar_aula_video';
            $dados['video'] = $dados_aula['video'];
        }
        else if($dados_aula['tipo'] == 2){
            $view = 'editar_aula_questionario';
            $dados['questionario'] = $dados_aula['questionario'];
        }
        else{
            $_SESSION['erro'] = 'Tipo de aula inválido';
            header('Location:'.BASE_URL.'editar/'.$dados_aula['id_curso']);
            exit;
        }
        

        $this->loadTemplate($view,$dados);
    }
    
    public function editarVideo($id_aula){
        $aula = new Aula();
        $curso = $aula->getCursoAula($id_aula);
        
        if(isset($_POST['nome']) && !empty($_POST['nome'])){
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao',FILTER_SANITIZE_STRING);
            $url =  filter_input(INPUT_POST, 'url',FILTER_SANITIZE_STRING);
            
            $aula_video = new Video();            
            $aula_video->atualizar($id_aula,$nome,$descricao,$url);
            
            $_SESSION['success'] = 'Aula atualizada com sucesso...';
            
        }
        else{
            $_SESSION['erro'] = 'Falha ao atualizar aula...';
        }
        
        header('Location:'.BASE_URL.'cursos/editar/'.$curso['id']);
        exit;
    }
    
    public function editarQuestionario($id_questionario){

        $num_questoes = filter_input(INPUT_POST, 'id-ultima-questao',FILTER_VALIDATE_INT);
        $num_questoes_prev = filter_input(INPUT_POST, 'id-ultima-questao-prev',FILTER_VALIDATE_INT);
        $nome_questionario = filter_input(INPUT_POST, 'nome-questionario',FILTER_SANITIZE_STRING);
        
        $questoes = array();
        $alternativas = array();
        
        for( $i=0; $i<$num_questoes;$i++){
            $questoes[$i]['id'] = filter_input(INPUT_POST, 'id-questao'.($i+1),FILTER_VALIDATE_INT);
            $questoes[$i]['pergunta'] = filter_input(INPUT_POST, 'questao'.($i+1),FILTER_SANITIZE_STRING);
            $questoes[$i]['resposta'] = filter_input(INPUT_POST, 'resposta-questao'.($i+1),FILTER_SANITIZE_STRING);
            
            $alternativas[$i]['id_questao'] = $questoes[$i]['id'];
            for( $j=0; $j<4; $j++){
                $alternativas[$i][$j]['id'] = filter_input(INPUT_POST,'id-quest'.($i+1).'-alt'.($j+1),FILTER_VALIDATE_INT);
                $alternativas[$i][$j]['texto'] = filter_input(INPUT_POST,'quest'.($i+1).'-alt'.($j+1),FILTER_SANITIZE_STRING);   
            }          
        }
        
        $quest = new Questao();
        foreach ($questoes as $questao){
            if($questao['id']<=$num_questoes_prev){
                $quest->atualizar($id_questionario,$questao);
            }
            else{
               $quest->inserir($id_questionario,$questao); 
            }
        }
        echo '<br>--------------------------------------------------<br>ALTERNATIVAS<br>';
        

        $alt = new Alternativa();
        foreach ($alternativas as $alternativa){
            if($alternativa['id_questao']<=$num_questoes_prev){
                $alt->atualizar($alternativa);
            }
            else{
               $alt->inserir($alternativa); 
            }
        }
        
        $questionario = new Questionario();
        $questionario->atualizar($id_questionario,$nome_questionario);
        $questionario_aula = $questionario->getQuestionarioAula('id', $id_questionario);
        //echo 'ID Questionario:'.$id_questionario;
        
        $_SESSION['success'] = 'Questionário atualizado com sucesso';
        header('Location:'.BASE_URL.'aulas/editar/'.$questionario_aula['id_aula']);
        exit;
    }  
}
