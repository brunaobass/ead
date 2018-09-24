<?php

class cursosController extends Controller{
    private $curso;
    private $usuario;
    private $aula;
    private  $logado = false;
    public function __construct() {
        $this->curso = new Curso();
        $this->usuario = new Usuario();
        $this->aula = new Aula();
        if($this->usuario->logado()){
            $this->usuario->setUsuario($_SESSION['logado']);
            $this->logado = true;
        }
        
    }
    public function index(){

        $pagina_atual = $this->getPaginaAtual();

        $dados = [
            'title' => 'Cursos',
            'css'   => 'home',
            'titulo_principal' => 'Cursos',
            'cursos' => $this->curso->getCursos($pagina_atual),
            'num_paginas' => $this->curso->getNumPaginas(),
            'logado' => $this->logado
        ];
        $this->loadTemplate('cursos',$dados);
    }
    /********************
     * CURSOS DO ALUNO
     ********************/
    public function entrar($id){
        $aluno = new Aluno();
        
        if(($aluno->logado())){
            $aluno->setUsuario($_SESSION['logado']);
            $this->logado = true;
            $dados['info'] = $aluno->getInfo();
        }
        
        $dados = array(
            'logado' => $this->logado
        );

        $dados['css'] = 'curso';
        
        $curso = new Curso(); 
        $curso->setCurso($id);

        $modulo = new Modulo();

        $dados['title'] = $curso->getNome();
        $dados['titulo_principal'] = $curso->getNome();
        $dados['curso'] = $curso->getInfo();
        $dados['modulos'] = $modulo->getModulosComAulas($id);

        if($aluno->isInscrito($id) && $aluno->logado()){            
            $this->loadTemplate("curso", $dados);  
        }
        else {
            $this->loadTemplate("curso2", $dados);
        }
        
    }
    
    public function aula($id_aula){
        $aluno = new Aluno();
        
        if(!($aluno->logado())){
            header("Location:".BASE_URL."login");
        }
        
        $dados = array();
        $aluno->setUsuario($_SESSION['logado']);
        
        $dados['logado'] = true;
        $dados['info'] = $aluno->getInfo();
        $dados['css'] = 'curso';
        
        $aula = new Aula();
        $id_curso = $aula->getCursoAula($id_aula);
        $dados['id_curso'] =$id_curso ; 
        
        if($aluno->isInscrito($id_curso)){
            $curso = new Curso(); 
            $curso->setCurso($id_curso);
            
            $modulo = new Modulo();
            
            $dados['title'] = $curso->getNome();
            $dados['titulo_principal'] = $curso->getNome();
            $dados['curso'] = $curso->getInfo();
            $dados['modulos'] = $modulo->getModulosComAulas($id_curso);
            $dados['aula'] = $aula->getAula($id_aula);

            
            if($dados['aula']['tipo'] == 1){
                $view = "aula_video";
                $mensagem = filter_input(INPUT_POST, 'mensagem',FILTER_SANITIZE_STRING);
                $this->salvar($aluno->getID(),$dados['aula']['video']['id'],$mensagem);                
            }
            else{
                $view = 'aula_questionario';
                $quest = new Questionario();
                $questionario = $quest->getQuestionarioAula('id_aula',$id_aula);
                
                if(isset($_POST) && !empty($_POST)){
                    $dados['questoes'] = $this->preencheAlternativas($questionario['questoes']);
                    $aula->marcarAssistido($id_aula);
                }
                else{
                    $dados['questoes'] = $questionario['questoes'];
                }               
            }

            $this->loadTemplate($view, $dados);
            
        }
        else {
            header("Location: ".BASE_URL);
            exit;
        }
    }
    public function pesquisar(){
        $cursos = array();
        if(isset($_POST) && !empty($_POST)){
            $pesquisa = filter_input(INPUT_POST, 'pesquisar',FILTER_SANITIZE_STRING);
            $cursos = $this->curso->getCursosPesquisa($pesquisa);
        }
        $dados = [
            'title' => 'Cursos',
            'css'   => 'home',
            'titulo_principal' => 'Cursos',
            'cursos' => $cursos,
            'logado' => $this->logado
        ];
 
        $this->loadTemplate('cursos',$dados);
    }
    private function salvar($id_aluno,$id_video,$mensagem){
        $resposta = "";
        
        if((!empty($mensagem))){
            $comentario = new Comentario();
            
            $inserir = $comentario->inserir($id_aluno,$id_video,$mensagem); 

            if($inserir){
                $_SESSION['success'] = "Comentário realizado com sucesso!";
            }
            else{
                $_SESSION['erro'] = "Erro ao realizar comentário!Tente novamente!";
            }
        }
    }
    
    private function preencheAlternativas($questoes){

        for($i = 0; $i<count($questoes); $i++){
            $alternativa = filter_input(INPUT_POST,'questao'.($i+1), FILTER_VALIDATE_INT);
            if(empty($alternativa)){
                $_SESSION['erro'] = 'Responda todas as questões';
                break;
            }
            $questoes[$i]['resposta_aluno'] = $alternativa;
        } 
        
        return $questoes;
    }
    /***********************************************
     * CURSOS DO PROFESSOR**************************
     ***********************************************/
    public function cadastrar(){
        
        if($this->usuario->getNivel($_SESSION['logado']) != 2){
            header('Location: '.BASE_URL);
        }
        
        $dados = [
            'title'=> 'Adicionar curso',
            'titulo_principal'=> 'Novo Curso',
            'css'=> 'curso',
            'logado' => $this->logado
        ];
        if(isset($_POST) && !empty($_POST)){
            
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao',FILTER_SANITIZE_STRING);
            $imagem = $_FILES['imagem'];
            
            if(empty($nome) || empty($descricao)){
                $_SESSION['erro'] = 'Preencha todos os campos!';                
            }
            else if(empty($_FILES['imagem']['tmp_name'])){
                $_SESSION['erro'] = 'Nenhuma imagem foi enviada';             
            }
            else{
                $url = $this->salvaImagem($imagem);
                if(!empty($url)){
                    $this->curso->insert(['instrutor_id','nome','imagem','descricao'], 
                            [$_SESSION['logado'],$nome,$url,$descricao]);
                    
                    $_SESSION['success'] = 'Curso cadastrado com sucesso';
                    header('Location:'.BASE_URL);
                    exit;
                }
                else{
                    $_SESSION['erro'] = 'Tipo de arquivo inválido...';
                }
            }
        }

        

        if(isset($_SESSION['erro'])){
            $dados['nome'] = $nome;
            $dados['descricao'] = $descricao;
            $dados['info'] = $this->usuario->getInfo();
        }
        
        $this->loadTemplate('add_curso',$dados);
        
    }
    
    public function editar($id){
        if($this->usuario->getNivel($_SESSION['logado']) != 2){
            header('Location: '.BASE_URL);
            exit;
        }
        
        $this->curso->autorizaAcessoInstrutor($id);
        
        $this->curso->setCurso($id);
        $modulo = new Modulo();
        
        if(isset($_POST['modulo']) && !empty($_POST['modulo'])){
            $mod = filter_input(INPUT_POST, 'modulo',FILTER_SANITIZE_STRING);
            $modulo->addModulo($mod, $id);
        }
        
        $curso = $this->curso->getInfo();
        $dados = array(
            'curso' => $curso,
            'modulos'=>$modulo->getModulos($id),
            'title' => 'Editar curso',
            'titulo_principal'=> 'Editar Curso - '.$curso['nome'],
            'css' => 'curso',
            'logado' => $this->logado
        );  

        //$dados['logado'] = $this->logado;
        $dados['info'] = $this->usuario->getInfo();
        $this->loadTemplate('add_curso',$dados);        
    }
    
    
    public function atualizar($id){
        
        if($this->usuario->getNivel($_SESSION['logado']) != 2){
            header('Location: '.BASE_URL);
        }
        
        //$this->curso->autorizaAcessoInstrutor($id);
        
        $this->curso->setCurso($id);
        $modulo = new Modulo();
        
        if(isset($_POST['modulo']) && !empty($_POST['modulo'])){
            $mod = filter_input(INPUT_POST, 'modulo',FILTER_SANITIZE_STRING);
            $modulo->addModulo($mod, $id);
        }
        $curso = $this->curso->getInfo();
        $dados = array(
            'curso' => $curso,
            'modulos'=>$modulo->getModulos($id),
            'title' => 'Editar curso',
            'titulo_principal'=> 'Editar Curso - '.$curso['nome'],
            'css' => 'curso',
            'logado' => $this->logado
        );  

        if(isset($_POST) && !empty($_POST)){
            
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao',FILTER_SANITIZE_STRING);
            $imagem = $_FILES['imagem'];
            
            if(empty($nome) || empty($descricao)){
                $_SESSION['erro'] = 'Os campos nome e descrição devem estar preenchidos!';                
            }
            else{
                $this->curso->update(['nome','descricao'], [$nome,$descricao],['id'],[$id]);
            }
            
            if(!empty($_FILES['imagem']['tmp_name'])){
                $url = $this->salvaImagem($imagem);
                if(!empty($url)){
                    $this->curso->update(['imagem'], [$url],['id'],[$id]);
                }
                else{
                    $_SESSION['erro'] = 'Tipo de arquivo inválido...';
                }             
            }
        }
        $this->curso->setCurso($id);
        $dados['curso'] = $this->curso->getInfo();
        $this->loadTemplate('add_curso',$dados);

    }
    private function salvaImagem($imagem){
        $tipos = ['image/jpg','image/png','image/jpeg'];
        $nome = md5(time(). rand(0, 9999)).'.jpg';
        
        if(in_array($imagem['type'], $tipos)){
            move_uploaded_file($imagem['tmp_name'],'assets/images/cursos/'.$nome);
            return $nome;
        }
        
        return '';
    }
    
    public function inscrever($id_curso){
        if(!($this->usuario->logado())){
            $_SESSION['erro'] = 'Você precisa estar logado para se inscrever em um curso';
            header("Location:".BASE_URL."login");
            exit;
        }
        $matricula = new Matricula();
        $matricula->inscrever($id_curso);
        
        $_SESSION['success'] = 'Matrícula realizada com sucesso';
        header('Location:'.BASE_URL);
        exit;
        
        
    }
    private function getPaginaAtual(){
        if(!empty($_GET['p'])){
            $pagina_atual = filter_input(INPUT_GET, 'p',FILTER_VALIDATE_INT);
            
            if($pagina_atual == false){
                header('Location:'.BASE_URL);
                exit;
            }  
        }
        else {
            $pagina_atual = 1;
        }
        
        return $pagina_atual;
    }
}

