<?php

class perfilController extends Controller{
    
    private $usuario;
    private  $logado = false;
    public function __construct() {
        
        $this->usuario = new Usuario();
        
        if($this->usuario->logado()){
            $this->usuario->setUsuario($_SESSION['logado']);
            $this->logado = true;
        }
        else{
            header('Location:'.BASE_URL.'login');
        }
        
    }
   public function index(){

       $dados = [
           'title' => 'perfil',
           'css'   => 'perfil',
           'titulo_principal' => 'Perfil',
           'usuario' => $this->usuario->getInfo(),
           'logado' => $this->logado,
           'edicao'=>1
        ];

       $this->loadTemplate('perfil',$dados);
   }
   
   public function editar(){
       $dados = array(
                'title' => 'Editar Perfil',
                'titulo_principal' => 'Atualização de Dados do Usuário',
                'css'=>'perfil',
                "aviso"=>"",
                'edicao'=>1,
                'logado' => $this->logado
        );
        $id = $_SESSION['logado'];
        $usuario = new Usuario();
        $usuario->setUsuario($id);
        $user = $usuario->getInfo();
        
        if(isset($_FILES['foto']['tmp_name'])&&(!empty($_FILES['foto']['tmp_name']))){
            $imagem = $usuario->salva_foto($_FILES['foto']);
            
            if($imagem === false){
                $_SESSION['erro'] = 'Tipo de imagem inválido';
                
                $dados['usuario'] = $user;
                header('Location:'.BASE_URL.'perfil/editar');
                exit;
            }
            else{
                $this->deleta_imagem($user['imagem']);
            }
        }
        else{
            $usuario->setUsuario($id);
            $imagem = $usuario->getInfo()['imagem']; 
        }
        if(isset($_POST) && !empty($_POST)){
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);
            $senha1 = filter_input(INPUT_POST, 'senha1',FILTER_SANITIZE_STRING);
            $senha2 = filter_input(INPUT_POST, 'senha2',FILTER_SANITIZE_STRING);
            
            if(empty($nome)){
                $nome = $user['nome'];    
            }
            if(empty($username)){
                $username = $user['username'];
            }

            if(($senha1 === $senha2)){ 
                if(!empty($senha1)){
                    $senha = password_hash($senha1,PASSWORD_BCRYPT);
                }
                else{
                    $senha = $user['senha']; 
                }
                
                $usuario->atualizarPerfil($id,$nome,$username,$senha,$imagem);
                
            }
            else{
                $_SESSION['erro'] = 'Digite duas senhas iguais!';
            }
        }
        $usuario->setUsuario($id);
        $dados['usuario'] = $usuario->getInfo();

        $this->loadTemplate("perfil",$dados);
   }
   
   private function deleta_imagem($imagem){
       unlink('assets/images/usuarios/'.$imagem);
   }
}
