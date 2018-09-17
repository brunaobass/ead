
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
                        
                        <a href="<?=BASE_URL.'cursos/aula/'.$aula_modulo['id']?>">
                            <li>
                                <div class="aula-left">
                                   <i class="<?=$icon?>"></i> <?=$aula_modulo[$aula_modulo['tipo_nome']]['nome']?> 
                                </div>
                                <div class="aula-right">
                                    <span>5:00</span>
                                    <button class="btn-check-aula <?=(($aula_modulo['finalizada'] ) ? 'checked' : 'not-checked')?>" 
                                            id="aula-check<?=$aula_modulo['id']?>" 
                                            onclick="checkAula(this)" data-id-aula="<?=$aula_modulo['id']?>">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                
                            </li></li></a>
                    
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

