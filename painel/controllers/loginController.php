<?php

class loginController extends Controller{
    public function index(){


        $admin = new Admin();

        $dados = array(
            'title' => 'Login do Admin',
            'css'=>'login',
            'titulo_principal'=>'Login do Administrador'
        );

        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = filter_input(INPUT_POST, "email",FILTER_VALIDATE_EMAIL);
            $senha = filter_input(INPUT_POST, "senha",FILTER_SANITIZE_STRING);

            if($admin->fazerLogin($email,$senha)){
                header("Location: ".BASE_URL."cursos");
            }
        }
        $this->loadTemplate("login",$dados);

    }

    public function cadastrar(){

        $dados = array(
                "aviso"=>""
        );
        $admin = new Admin();

        if(isset($_POST['nome']) && !empty($_POST['nome'])){
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
            $senha1 = filter_input(INPUT_POST, 'senha1',FILTER_SANITIZE_STRING);
            $senha2 = filter_input(INPUT_POST, 'senha2',FILTER_SANITIZE_STRING);
            if(!empty($nome) && !empty($email) && !empty($senha1) &&!empty($senha2)){
                if($senha1 === $senha2){
                    if($email != false){
                        $dados['aviso'] = "Digite um email válido...";
                    }
                    else if($admin->existeAdmin($email)){
                        $dados['aviso'] = "Este email já está cadastrado no sistema...";
                    }
                    else{
                        $senha = password_hash($senha1,PASSWORD_BCRYPT);
                        $_SESSION['lgadmin'] = $admin->inserirAdmin($nome,$email,$senha);
                        header("Location: ".BASE_URL);
                    }
                }
                else{
                    $dados['aviso'] = 'Digite duas senhas iguais!';
                }
                
            }
            else{
                $dados['aviso'] = "Preencha todos os campos...";
            }
        }

        $this->loadView("cadastro",$dados);

    }

    public function sair(){
            unset($_SESSION['lgadmin']);

            header("Location:".BASE_URL."login");
    }
}
