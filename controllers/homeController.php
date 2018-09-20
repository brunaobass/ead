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
        
        $dados['cursos'] = $this->getCursos($usuario, $id_usuario);
     
        $usuario->setUsuario($id_usuario);
        $dados['logado'] = true;
        $dados['usuario'] = $usuario->getInfo();
             
        $this->loadTemplate("home",$dados);

    }
    
    private function getCursos($usuario,$id_usuario){
        $curso = new Curso();
        
        if($usuario->getNivel($id_usuario) == 1){          
            $usuario = new Aluno();
            $cursos = $curso->getCursosDoAluno($id_usuario);
            if(count($cursos)<=0){
                $_SESSION['semcurso'] = 'Você ainda não está matriculado em nenhum curso. '
                        . '<a href="'.BASE_URL.'/cursos'.'">Clique e conheça os nossos cursos!</a>';
            }
        }
        else{
            $cursos = $curso->getCursosDoInstrutor($id_usuario);
            if(count($cursos)<=0){
                $_SESSION['semcurso'] = 'Você ainda não criou nenhum curso';
            }
        }
        
        return $cursos;
    }
}