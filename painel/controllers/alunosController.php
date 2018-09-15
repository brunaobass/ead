<?php

class alunosController extends Controller{

    private $aluno;
    private $logado;
    private $admin;
    public function __construct() {
        $admin = new Admin();
        if(!$admin->logado()){
            $this->logado = false;
            header("Location:".BASE_URL.'login');
        }
        $this->logado = true;
        $this->aluno = new Aluno();
        $this->admin = new Admin();
        $this->admin->setAdmin($_SESSION['lgadmin']);
    }
    public function index(){
        $dados = array();
        $dados['alunos'] = $this->aluno->getAlunos();
        $dados['title'] = "Painel de Controle - Alunos";
        $dados['css'] = 'home';
        $dados['logado'] = $this->logado;
        $dados['info'] = $this->admin->getInfo();
        
        $this->loadTemplate("alunos",$dados);
    }
    
    public function excluir($id_aluno){
        
        $this->$this->aluno->delete(['id_aluno'], [$id_aluno],'historico');
        $this->aluno->delete(['id_aluno'], [$id_aluno],'aluno_curso');
        $this->aluno->delete(['id_aluno'], [$id_aluno],'comentarios');
        $this->aluno->delete(['id'], [$id_aluno]);
        
        $_SESSION['success'] = 'Aluno excluído com sucesso!';
        header('Location:'.BASE_URL.'alunos');
        
    }
    
    public function adicionar(){
        $dados = [
            'title'=>'Cadastrar Aluno',
            'css'=>'curso'
        ];
        $dados['logado'] = $this->logado;
        $dados['info'] = $this->admin->getInfo();
        $this->loadTemplate('cadastra_aluno',$dados);
    }
    
    public function editar($id){
        $this->aluno->setAluno($id);
        $curso = new Curso();
        $dados = [
            'title'=>'Editar Aluno',
            'css'=>'curso',
            'aluno'=>$this->aluno->getInfo()
        ];
        
        $this->loadTemplate('cadastra_aluno',$dados);
        
        
    }

    
    public function cadastrar_aluno(){
        $dados = array();
        
        if(isset($_POST['nome']) && !empty($_POST['nome'])){
            
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
            $senha1 = filter_input(INPUT_POST, 'senha1',FILTER_SANITIZE_STRING);
            $senha2 = filter_input(INPUT_POST, 'senha2',FILTER_SANITIZE_STRING);
            
            if(!empty($nome) && !empty($email) && !empty($senha1) &&!empty($senha2)){
                if($senha1 === $senha2){
                    if($email == false){
                        $_SESSION['erro'] = "Digite um email válido...";
                    }
                    else if($this->aluno->existeAluno($email)){
                        $_SESSION['erro'] = "Este email já está cadastrado no sistema...";
                    }
                    else{
                        $senha = password_hash($senha1,PASSWORD_BCRYPT);
                        $this->aluno->inserirAluno($nome,$email,$senha);
                        $_SESSION['success'] = 'Aluno cadastrado com sucesso!';
                        
                        header("Location: ".BASE_URL.'alunos');
                    }
                }
                else{
                    $_SESSION['erro'] = 'Digite duas senhas iguais!';
                }
                
            }
            
            else{
                $_SESSION['erro'] = "Preencha todos os campos...";
            }
        }
            /*$imagem = $_FILES['imagem'];
            
            if(!empty($_FILES['imagem']['tmp_name'])){
                $url = $this->salvaImagem($imagem);
                if(!empty($url)){
                    $this->aluno->insert(['nome','imagem','descricao'], [$nome,$url,$descricao]);
                }
                else{
                    $dados['erro'] = 'Tipo de arquivo inválido...';
                }
            }
            else{
                $dados['erro'] = 'Nenhuma imagem foi enviada';
            }*/
        /*if(isset($dados['erro'])){
            $dados['nome'] = $nome;
            $dados['descricao'] = $descricao;
            $dados['logado'] = $this->logado;
            $dados['info'] = $this->admin->getInfo();
            $this->loadTemplate('cadastra_aluno',$dados);
        }*/

        
    }
    public function atualizar_aluno(){
        $dados = array();
        if(isset($_POST['nome']) && !empty($_POST['nome'])){
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao',FILTER_SANITIZE_STRING);
            $id = filter_input(INPUT_POST, 'id',FILTER_VALIDATE_INT);
            $imagem = $_FILES['imagem'];
            
            $this->aluno->update(['nome','descricao'], [$nome,$descricao],['id'],[$id]);
            
            if(!empty($_FILES['imagem']['tmp_name'])){
                $url = $this->salvaImagem($imagem);
                if(!empty($url)){
                    $this->aluno->update(['imagem'], [$url],['id'],[$id]);
                }
                else{
                    $dados['erro'] = 'Tipo de arquivo inválido...';
                }
            }
        }
        if(isset($dados['erro'])){
            $dados['nome'] = $nome;
            $dados['descricao'] = $descricao;
            $dados['aluno'] = $this->aluno->getAluno($id);
            $dados['logado'] = $this->logado;
            $dados['info'] = $this->admin->getInfo();
            $this->loadTemplate('add_aluno',$dados);
        }
        else {
            header('Location:'.BASE_URL);
        }
    }
}