<?php

class homeController extends Controller{
    private $curso;
    private $aula;
    public function __construct() {
        $admin = new Admin();
        if(!$admin->logado()){
            header("Location:".BASE_URL.'login');
        }
        $this->curso = new Curso();
        $this->aula = new Aula();
    }
    public function index(){
        $dados = array();
        $dados['cursos'] = $this->curso->getCursos();
        $dados['title'] = "Painel de Controle";
        $dados['titulo_principal'] = 'Cursos';
        $dados['css'] = 'home';
        $this->loadTemplate("home",$dados);
    }
    
    public function excluir($id_curso){
        
        $aulas = $this->curso->where(['id','tipo'], ['id_curso'], [$id_curso],'aulas');
        
        foreach ($aulas as $aula){
            $this->aula->delete(['id_aula'], [$aula['id']],'historico');
            if($aula['tipo'] == 1){
                $this->aula->delete(['id'], [$aula['id']],'videos');
            }
            else{
                $questionario = new Questionario();
                $questionario->excluir($aula['id']);
            }
            $this->aula->delete(['id'], [$aula['id']]);   
        }
        $this->$this->curso->delete(['id_curso'], [$id_curso],'modulo');
        $this->curso->delete(['id_curso'], [$id_curso],'aluno_curso');
        $this->curso->delete(['id'], [$id_curso]);
        header('Location:'.BASE_URL);
        
    }
    
    public function adicionar(){
        $dados = [
            'title'=>'Adicionar curso',
            'css'=>'curso'
        ];
        $this->loadTemplate('add_curso',$dados);
    }
    
    public function editar($id){
        $this->curso->setCurso($id);
        $modulo = new Modulo();
        
        $dados = array(
            'curso' => $this->curso->getInfo(),
            'modulos'=>$modulo->getModulos($id),
            'title' => 'Editar curso',
            'css' => 'curso'
        );
        
        $this->loadTemplate('add_curso',$dados);        
    }

    
    public function cadastrar_curso(){
        
        $dados = array();
        if(isset($_POST['nome']) && !empty($_POST['nome'])){
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao',FILTER_SANITIZE_STRING);
            $imagem = $_FILES['imagem'];
            
            if(!empty($_FILES['imagem']['tmp_name'])){
                $url = $this->salvaImagem($imagem);
                if(!empty($url)){
                    $this->curso->insert(['nome','imagem','descricao'], [$nome,$url,$descricao]);
                }
                else{
                    $dados['erro'] = 'Tipo de arquivo inválido...';
                }
            }
            else{
                $dados['erro'] = 'Nenhuma imagem foi enviada';
            }
        }
        if(isset($dados['erro'])){
            $dados['nome'] = $nome;
            $dados['descricao'] = $descricao;
            $this->loadTemplate('add_curso',$dados);
        }
        else {
            header('Location:'.BASE_URL);
        }
        
    }
    public function atualizar_curso(){
        $dados = array();
        if(isset($_POST['nome']) && !empty($_POST['nome'])){
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao',FILTER_SANITIZE_STRING);
            $id = filter_input(INPUT_POST, 'id',FILTER_VALIDATE_INT);
            $imagem = $_FILES['imagem'];
            
            $this->curso->update(['nome','descricao'], [$nome,$descricao],['id'],[$id]);
            
            if(!empty($_FILES['imagem']['tmp_name'])){
                $url = $this->salvaImagem($imagem);
                if(!empty($url)){
                    $this->curso->update(['imagem'], [$url],['id'],[$id]);
                }
                else{
                    $dados['erro'] = 'Tipo de arquivo inválido...';
                }
            }
        }
        if(isset($dados['erro'])){
            $dados['nome'] = $nome;
            $dados['descricao'] = $descricao;
            $dados['curso'] = $this->curso->getCurso($id);
            $this->loadTemplate('add_curso',$dados);
        }
        else {
            header('Location:'.BASE_URL);
        }
    }

    private function salvaImagem($imagem){
        $tipos = ['image/jpg','image/png','image/jpeg'];
        $nome = md5(time(). rand(0, 9999)).'.jpg';
        
        if(in_array($imagem['type'], $tipos)){
            move_uploaded_file($imagem['tmp_name'], '../assets/images/cursos/'.$nome);
            return $nome;
        }
        
        return '';
    }
}