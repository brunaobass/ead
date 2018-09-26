
<section class="cursos-container">
    <?php
        require 'alerts.php';
        if(isset($usuario) && $usuario['nivel'] == 2):
            $action = 'atualizar';
    ?>
        <div>           
            <a href="<?=BASE_URL.'cursos/cadastrar'?>" class="btn btn-primary" id="btn-criar-curso">Criar curso</a>            
        </div>
    <?php
        else:
            $action = 'entrar';
        endif;
    ?>

        
    <div class="cursos">
    
    <?php
        foreach ($cursos as $curso_item):
    ?>

        <a href="<?=BASE_URL.'cursos/'.$action.'/'.$curso_item['id']?>">
            <div class="cursoitem">
                <figure class="imagem_curso">
                    <img src="<?=BASE_URL.'assets/images/cursos/'.$curso_item['imagem']?>" alt="<?=$curso_item['descricao']?>">
                    <strong class="nome-curso"><figcaption>Curso de <?=$curso_item['nome']?></figcaption></strong>
                </figure>
                <p class="instrutor">Instrutor do curso</p></a>
                <div class="demo jq-stars"></div>

            </div>

    <?php    
        endforeach;
    ?>
    </div>

</section>