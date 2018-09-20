<?php

class aulasController extends Controller{

    private $usuario;
    private $aula;
    private $logado = false;
    private $curso;
    private $modulo;
    public function __construct() {
        
        $this->curso = new Curso();
        $this->usuario = new Usuario();
        $this->aula = new Aula();
        $this->modulo = new Modulo();
        
        if($this->usuario->logado()){
            $this->usuario->setUsuario($_SESSION['logado']);
            $this->logado = true;
        }
    }

    public function index(){
        
    }
    public function adicionar(){
        
        $id_curso = filter_input(INPUT_POST, 'id_curso',FILTER_VALIDATE_INT);
        
        if(empty($id_curso) || $id_curso === false){
            header('Location:'.BASE_URL);
            exit;
        }
        if(isset($_POST['aula']) && !empty($_POST['aula'])){

            $this->curso->autorizaAcessoInstrutor($id_curso);
            
            $nome_aula = filter_input(INPUT_POST, 'aula',FILTER_SANITIZE_STRING);
            $modulo_aula = filter_input(INPUT_POST, 'modulo-aula',FILTER_VALIDATE_INT);
            $tipo = filter_input(INPUT_POST, 'tipo',FILTER_VALIDATE_INT);
            if($tipo != 1 && $tipo != 2){
                $_SESSION['erro'] = 'Tipo inválido';                
            }
            else if(!$this->modulo->existeModulo($modulo_aula)){
                $_SESSION['erro'] = 'Modulo Inexistente';
            }
            else {
                $_SESSION['success'] = 'Aula criada com sucesso';
                $this->aula->addAula($id_curso, $nome_aula, $modulo_aula,$tipo);
            }
            
        }
        else{
            $_SESSION['erro'] = 'Digite o nome da aula';
        }

        header('Location:'.BASE_URL.'cursos/atualizar/'.$id_curso);
        exit;
        
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
            //'modulos' => $modulo->getModulos($dados_aula['id_curso'])
        );
        if($dados_aula['tipo'] == 1){
            $view = 'editar_aula_video';
            $dados['video'] = $dados_aula['video'];
            $dados['titulo_principal'] = 'Editar Vídeo Aula - '.$dados['video']['nome'];
        }
        else if($dados_aula['tipo'] == 2){
            $view = 'editar_aula_questionario';
            $dados['questionario'] = $dados_aula['questionario'];
            $dados['titulo_principal'] = 'Editar Questionário - '.$dados['questionario']['nome'];
        }
        else{
            $_SESSION['erro'] = 'Tipo de aula inválido';
            header('Location:'.BASE_URL.'editar/'.$dados_aula['id_curso']);
            exit;
        }
        $dados['logado'] = $this->logado;

        $this->loadTemplate($view,$dados);
    }
    
    public function editarVideo($id_aula){

        $curso = $this->aula->getCursoAula($id_aula);        
        $aula = $this->aula->getAula($id_aula);
        
        if(isset($_POST)){
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao',FILTER_SANITIZE_STRING);
            $url =  filter_input(INPUT_POST, 'url',FILTER_SANITIZE_STRING);
            
            if(empty($nome)){
                $nome = $aula['nome'];
            }
            else if(empty($descricao)){
                $descricao = $aula['descricao'];
            }
            else if(empty($url)){
                $url = $aula['url'];               
            }
            
            else{
                $aula_video = new Video();            
                $aula_video->atualizar($id_aula,$nome,$descricao,$url);
                $_SESSION['success'] = 'Aula atualizada com sucesso...';  
            } 

        }
        else{
            $_SESSION['erro'] = 'Falha ao atualizar aula...';
        }
        header('Location:'.BASE_URL.'aulas/editar/'.$id_aula);
        exit;
        
    }
    
    public function editarQuestionario($id_questionario){

        $num_questoes = filter_input(INPUT_POST, 'id-ultima-questao',FILTER_VALIDATE_INT);
        $num_questoes_prev = filter_input(INPUT_POST, 'id-ultima-questao-prev',FILTER_VALIDATE_INT);
        $nome_questionario = filter_input(INPUT_POST, 'nome-questionario',FILTER_SANITIZE_STRING);
        
        $questionario = new Questionario();
        $id_aula = $questionario->getIdAula($id_questionario);
        
        
        $questoes = array();
        $alternativas = array();
        
        for( $i=0; $i<$num_questoes;$i++){
            $questoes[$i]['id-delete'] = filter_input(INPUT_POST, 'id-delete'.($i+1),FILTER_VALIDATE_INT);            
            $questoes[$i]['id'] = filter_input(INPUT_POST, 'id-questao'.($i+1),FILTER_VALIDATE_INT);
            if(isset($questoes[$i]['id-delete']) && $questoes[$i]['id-delete'] != false){
                continue;
            }
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
                if(empty($questao['id-delete'])){
                   $quest->atualizar($id_questionario,$questao); 
                }
                else{   
                    $quest->excluir($questao['id'],$id_questionario);
                }
                
            }
            else{
               $quest->inserir($id_questionario,$questao); 
            }
        }
        
        $alt = new Alternativa();
        foreach ($alternativas as $alternativa){
            if($alternativa['id_questao']<=$num_questoes_prev){
                $alt->atualizar($id_questionario,$alternativa);
            }
            else{
               $alt->inserir($id_questionario,$alternativa); 
            }
        }
        
        
        $questionario->atualizar($id_questionario,$nome_questionario);
        $questionario_aula = $questionario->getQuestionarioAula('id', $id_questionario);
        //echo 'ID Questionario:'.$id_questionario;
        
        $_SESSION['success'] = 'Questionário atualizado com sucesso';
        header('Location:'.BASE_URL.'aulas/editar/'.$questionario_aula['id_aula']);
        exit;
    }
    
    private function verificaModuloCurso($id_modulo,$id_curso){
        $mod = new Modulo();
        
        $modulo = $mod->getModulo($id_modulo);
    }
}
