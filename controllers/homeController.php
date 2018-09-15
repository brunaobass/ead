<?php

class homeController extends Controller{
    public function index(){
        $dados = array(
            'title'=>'Home',
            'titulo_principal'=>'Meus Cursos',
            'css'=>'home'
        );
        $usuario = new Usuario();
        $id_usuario = $_SESSION['logado'];
        if(!($usuario->logado())){
            header("Location:".BASE_URL."login");
        }
        
        $curso = new Curso();

        if($usuario->getNivel($id_usuario) == 1){          
            $usuario = new Aluno();
            $dados['cursos'] = $curso->getCursosDoAluno($id_usuario);
        }
        else{
            $dados['cursos'] = $curso->getCursosDoInstrutor($id_usuario);
        }
               
        $usuario->setUsuario($id_usuario);
        $dados['logado'] = true;
        $dados['usuario'] = $usuario->getInfo();
             
        $this->loadTemplate("home",$dados);

    }
}