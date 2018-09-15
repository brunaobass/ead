<section class="curso_info">
    <img src="<?=BASE_URL.'assets/images/cursos/'.$curso["imagem"]?>">
    <h3><?=$curso['nome']?></h3>
    <?php
        
    ?>
    
</section>
<section class="aulas">
    <div class="curso_left">
        <ul class="lista-modulos">
            <?php
                foreach($modulos as $modulo):
            ?>
            <li><span class="nome-modulo"><?=utf8_encode($modulo['nome'])?></span>
                    <ul class="lista-aulas">
                        <?php
                            foreach($modulo['aulas'] as $aula):
                        ?>
                        
                        <a href="<?=BASE_URL.'cursos/aula/'.$aula['id']?>"><li><?= utf8_encode($aula['nome'])?></li></a>
                    
                        <?php
                            endforeach;
                        ?>
                    </ul> 
                </li>
            <?php
                endforeach;
            ?>
        </ul>
    </div>
    <div class="curso_right">
        
    </div>
</section>
