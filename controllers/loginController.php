<?php

class loginController extends Controller{
    public function index(){


        $usuario = new Usuario();

        $dados = array(
            'title' => 'Login',
            'css'=>'login',
            'titulo_principal'=>'Login do Usuário'
        );

        if(isset($_POST['email']) || isset($_POST['senha'])){
            if(empty($_POST['email']) || empty($_POST['senha'])){
                $_SESSION['erro'] = 'Os dois campos devem estar preenchidos';
                $this->loadTemplate("login",$dados);
            }
            else{
                $email = filter_input(INPUT_POST, "email",FILTER_VALIDATE_EMAIL);
                $senha = filter_input(INPUT_POST, "senha",FILTER_SANITIZE_STRING);                
            }
            
            if($email !== false){
                if($usuario->fazerLogin($email,$senha)){                
                    header("Location: ".BASE_URL);
                    exit;
                }
            }
            else{
                $_SESSION['erro'] = 'Digite um email válido';
            }
            
        }
        
        $this->loadTemplate("login",$dados);

    }

    public function cadastrar(){

        $dados = array(
                'title' => 'Cadastrar',
                'titulo_principal' => 'Cadastro de Usuario',
                'css'=>'perfil',
                "aviso"=>""
        );
        
        $usuario = new Usuario();
        if(isset($_FILES['foto']['tmp_name']) && !empty($_FILES['foto']['tmp_name'])){
            $imagem = $usuario->salva_foto($_FILES['foto']);
            
            if(empty($imagem)){
                $_SESSION['erro'] = 'Tipo de imagem inválido';
            }
        }
        else{
            $imagem = null;
            
        }
  
        if(isset($_POST) && !empty($_POST)){

            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
            $nivel = filter_input(INPUT_POST, 'nivel',FILTER_VALIDATE_INT);
            $senha1 = filter_input(INPUT_POST, 'senha1',FILTER_SANITIZE_STRING);
            $senha2 = filter_input(INPUT_POST, 'senha2',FILTER_SANITIZE_STRING);
            
            $dados['usuario']['nome'] = $nome;
            $dados['usuario']['username'] = $username;
            $dados['usuario']['email'] = $email;
            if(!empty($nome) && !empty($username)  && !empty($email) && !empty($senha1) &&!empty($senha2)){
                if($senha1 === $senha2){
                    if(empty($nivel)){
                        $nivel = 1;
                    }
                    else{
                        if($nivel !== 1 && $nivel !== 2){
                            $_SESSION['erro'] = 'Nível de acesso inválido!';
                            $this->loadTemplate("perfil",$dados);
                        }
                    }
                    if($email === false){
                        $_SESSION['erro'] = "Digite um email válido...";
                    }
                    else if($usuario->existeEmail($email)){
                        $_SESSION['erro'] = "Este email já está cadastrado no sistema...";
                    }
                    else if($usuario->existeUsername($username)){
                        $_SESSION['erro'] = "Nome de usuário já está cadastrado no sistema...";
                    }
                    else{
                        $senha = password_hash($senha1,PASSWORD_BCRYPT);
                        $id = $usuario->inserirUsuario($nome,$username,$email,$nivel,$senha,$imagem);
                        $_SESSION['success'] = 'Verifique o seu email para confirmar o cadastro em nossa plataforma';
                        $this->enviaEmail($id,$email);
                        header("Location: ".BASE_URL);
                        exit;
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

        $this->loadTemplate("perfil",$dados);

    }
    public function confirma_cadastro($link){
        $usuario = new Usuario();
        $_SESSION['logado'] = $usuario->confirmaCadastro($link);
        header('Location:'.BASE_URL);
    }
    public function sair(){
            unset($_SESSION['logado']);

            header("Location:".BASE_URL."login");
    }
    
    
    
    private function enviaEmail($id,$email){
        $hash = md5($id);
        $link = BASE_URL.'login/confirma_cadastro/'.$hash;
        
        $assunto = 'Confirmaçao de cadastro na plataforma EAD';
        $msg = "Clique no link abaixo para realizar a confirmação do seu cadastro na plataforma EAD \n\n".$link;
        $header = "From: brunaobaixista@gmail.com\r\n"
                . "X-Mailer:PHP/". phpversion();
        
        mail($email, $assunto, $msg, $header);
        echo $link;
        exit;
    }
}
