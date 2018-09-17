<section class="aulas">
    <div class="curso_left">
        <h3>Módulos</h3>
        <ul class="lista-modulos">
            <?php
                foreach($modulos as $modulo):
            ?>
            <li class="modulo"><span class="nome-modulo"><?=$modulo['nome']?></span>
                    <ul class="lista-aulas">
                        <?php
                            foreach($modulo['aulas'] as $aula_modulo):
                                if($aula_modulo['tipo'] == 1){
                                    $icon = 'far fa-play-circle';
                                }
                                else{
                                   $icon = 'fas fa-clipboard-list'; 
                                }
                        ?>
                        
                        
                            <li>
                                <a href="<?=BASE_URL.'cursos/aula/'.$aula_modulo['id']?>">
                                    <div class="aula-left">
                                       <i class="<?=$icon?>"></i> <?=$aula_modulo[$aula_modulo['tipo_nome']]['nome']?> 
                                    </div>
                                </a>
                                <div class="aula-right">
                                    <span>5:00</span>
                                    <button class="btn-check-aula <?=(($aula_modulo['finalizada'] ) ? 'checked' : 'not-checked')?>" 
                                            id="aula-check<?=$aula_modulo['id']?>" 
                                            onclick="checkAula(this)" data-id-aula="<?=$aula_modulo['id']?>">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                
                            </li></li>
                    
                        <?php
                            endforeach;
                        ?>
                    </ul> 
                </li>
            <?php
                endforeach;
            ?>
        </ul>
    </div><!--curso_left-->
    
    <div class="curso_right">
        <h3>Video - <?=$aula['video']['nome']?></h3>
        
        <iframe id="video"src="//player.vimeo.com/video/<?=$aula['video']['url']?>" webkitallowfullscreen mozallowfulscreen
                allowfullscreen></iframe>     
        <p><?=$aula['video']['descricao']?></p>
        <?php
            if($aula['finalizada']):
        ?>
        <p>Esta aula já foi assistida</p>
        <?php
            else:
        ?>
        <button class="btn btn-secundario" onclick="concluirAula(this)" data-id="<?=$aula['id']?>" id="btn-assitido">
            Marcar como assistido</button>
        <?php
            endif;
        ?>
        <div class="comentarios">
            <h3>Comentários</h3>
 
            <form class="form-comentario" method="POST">
                <textarea class="form-group"  name="mensagem"></textarea>
                <button class="btn btn-primary">Comentar</button>
            </form>
            <?php
                    
                foreach ($aula['video']['comentarios'] as $comentario):
            ?>
                <span class="autor"><?=$comentario['autor']?></span>
                <span class="horario">dia <?= date('d/m/y - H:i',strtotime($comentario['data_duvida']))?></span>
                <p><?=$comentario['mensagem']?></p>
            <?php
                endforeach;
            ?>            
        </div>
    </div><!--curso_right-->
</section>
