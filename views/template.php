<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0, user-scalable=no">
        <title><?=(isset($title) && !empty($title))? $title : ''?></title>
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>assets/css/fontawesome-all.min.css">
        <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>assets/css/estilos.css">
        <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>assets/css/star-rating-svg.css">
        
        <?php
            if(!isset($logado) || $logado === false):
        ?>
            <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>assets/css/deslogado.css">
        <?php
            endif;
        ?>
        <?php
            if(isset($css) && !empty($css)){
                echo '<link rel="stylesheet" type="text/css" href="'.BASE_URL.'assets/css/'.$css.'.css">';
            }
        ?>
            
        
</head>
<body>  
    <header class="topo">
        <div class="conteudo"><!--CONTEÚDO-->
            <div class="topo-show"><!--TOPO SHOW-->
                <div class="logo"><!--LOGO-->
                    <a href="<?=BASE_URL?>"><h1>EAD</h1></a>
                </div><!--LOGO-->
                <div class="menu"><!--MENU-->
                    <nav class="menu-navegacao">
                        <ul>
                            <a href="<?=BASE_URL?>cursos">
                                <li class="dropdown first-li">Cursos</li>
                            </a>
                            <a href="<?=BASE_URL?>"><li>Como funciona</li></a>                       
                            <a href="<?=BASE_URL?>"><li>Suporte</li></a>
                            <li class="li-deslogado">
                                <div class="botoes-deslogado">
                                    <a href="<?=BASE_URL?>login" class="btn btn-secundario">ENTRAR</a>
                                    <a href="<?=BASE_URL?>login/cadastrar" class="btn btn-primary">CADASTRAR</a>
                                </div><!--BOTOES DESLOGADOS-->
                            </li>
                        </ul>
                    </nav>
                </div><!--MENU-->
                <form method="POST" class="form-pesquisa" action="<?=BASE_URL.'cursos/pesquisar'?>">
                    <input type="search" class="pesquisa" name="pesquisar" placeholder="Pesquisar curso">
                    <button type="submit"class="btn-icon icone-pesquisa"><i class="fas fa-search"></i></button>
                </form>
                <div class="topo-direita"> <!--TOPO DIREITA--> 
                    
                    <div class="botoes"><!--BOTOES-->
                        <button class="btn-icon" id="btn-show-menu"><i class="fas fa-bars"></i></button>
                        <button class="btn-icon" id="btn-close-menu"><i class="fa fa-times"></i></button>   
                        <?php
                            if(isset($logado) && $logado === true):
                        ?>
                        <div class="botoes-logado"><!--BOTOES-->
                            <button class="btn-icon" id="btn-perfil"><i class="fas fa-user-alt"></i></button>
                        </div><!--BOTOES DESLOGADOS-->
                        
                        <?php
                            else:
                        ?>
                        <div class="botoes-deslogado">
                            <a href="<?=BASE_URL?>login" class="btn btn-secundario">ENTRAR</a>
                            <a href="<?=BASE_URL?>login/cadastrar" class="btn btn-primary">CADASTRAR</a>
                        </div><!--BOTOES DESLOGADOS-->
                        <?php
                            endif;
                        ?>
                    </div><!--BOTOES-->
                </div><!--TOPO DIREITA-->  
            </div><!--TOPO SHOW-->
            
            
        </div><!--CONTEÚDO-->
        <div class="conteudo">
            
        
        
            
 
        </div>
    </header>
    <main>
        <?php
            if(isset($titulo_principal) && !empty($titulo_principal)):
        ?>
            <div class="titulo-principal">
                <div class="conteudo">
                    <h2><?=$titulo_principal?></h2> 
                    <ul class="menu-logado">
                        <li><a href="<?=BASE_URL?>perfil">Meus dados</a></li>
                        <li><a href="<?=BASE_URL?>home">Meus cursos</a></li>
                        <li><a href="<?=BASE_URL?>mensagens">Mensagens</a></li>
                        <li><a href="<?=BASE_URL?>ajuda">Ajuda</a></li>
                        <li><a href="<?=BASE_URL?>login/sair">Sair</a></li>
                    </ul>
                </div> 
                
            </div>
        <?php
            endif;
        ?>
        
        <div class="conteudo  coluna">
           <?php
                $this->loadViewInTemplate($viewName,$viewData);
            ?> 
        </div>
        
    </main>
    <footer class="rodape">
        <div class="conteudo"><!--CONTEÚDO-->
            
            <div class="coluna footer1">
                <div class="logo"><!--LOGO-->
                    <a href="<?=BASE_URL?>"><h1>EAD</h1></a>
                </div><!--LOGO-->
                <div class="socials">
                    <img src="<?=BASE_URL?>assets/images/icones/facebook.png">
                    <img src="<?=BASE_URL?>assets/images/icones/youtube.png">
                </div>
            </div>

            <div class="coluna">
                <ul class="menu-rodape">
                    <a href="<?=BASE_URL?>"><li>Para empresas</li></a>
                    <a href="<?=BASE_URL?>"><li>FAQ</li></a>
                    <a href="<?=BASE_URL?>"><li>Contato</li></a>
                </ul>
            </div>
            <div class="coluna">
                <ul class="menu-rodape">
                    <a href="<?=BASE_URL?>"><li>Termos de uso</li></a>
                    <a href="<?=BASE_URL?>"><li>Políticas de privacidade</li></a>
                    <a href="<?=BASE_URL?>"><li>Certificados</li></a>
                </ul>
            </div>

            
            <div class="coluna coluna-email">
                
                    <p>Deixe seu email e fique por dentro das novidades</p>
                    <form method="POST" class="form-email">
                        
                        <input type="email" name="email">
                        <button class="btn btn-primary">Enviar</button>
                    </form>
                
                
            </div>
            
        </div><!--CONTEÚDO-->
        <script src="<?=BASE_URL?>assets/js/jquery-3.2.1.min.js"></script>
        <script src="<?=BASE_URL?>assets/js/jquery.star-rating-svg.min.js"></script>
        <script src="<?=BASE_URL?>assets/js/script.js"></script>
    </footer>
</body>
</html>