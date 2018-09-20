<section class="cursos-container">

        <div class="cursos">
        <?php
            foreach ($cursos as $curso_item):
        ?>
            <a href="<?=BASE_URL.'cursos/entrar/'.$curso_item['id']?>">
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
        </div><!--cursos-->
        

    <ul class="pagination">
        <?php
            for($i = 1; $i<=$num_paginas;$i++):
        ?>
        <a href="<?=BASE_URL.'cursos/?p='.$i?>"><li><?=$i?></li></a>
        <?php
            endfor;
        ?>
    </ul>
</section>