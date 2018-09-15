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
                                    <button class="btn-check-aula" id="aula-check<?=$aula_modulo['id']?>">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                
                            </li>
                    
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
        <h3>Questionário - <?=$aula[$aula['tipo_nome']]['nome']?></h3>
        <form class="form-questionario" method="POST">
            
            <?php
                foreach($questoes as $questao):
            ?>
            <div class="questao">
            <p><?=$questao['id'].' - '.$questao['pergunta']?></p>
                <?php
                    foreach($questao['alternativas'] as $alternativa):
                        
                        if(isset($questao['resposta_aluno']) && $questao['resposta_aluno']==$alternativa['id']){ 
                           if($questao['resposta_aluno'] == $questao['resposta']){
                                $class = 'resposta-correta';
                            }
                            else{
                                $class = 'resposta-errada';
                            }
                            
                        }
                        else{
                            $class ='';
                        }
                ?>
                <div class="alternativa <?=$class?>">
                    <input type="radio" name="questao<?=$questao['id']?>" value="<?=$alternativa['id']?>"
                           id="<?='quest'.$questao['id'].'alt'.$alternativa['id']?>"
                           <?=($alternativa['id'] == 1) ?'required' : ''?>>
                    <label for="<?='quest'.$questao['id'].'alt'.$alternativa['id']?>"><?=$alternativa['texto']?></label>
                </div>
                <?php
                    endforeach;
                ?>
            </div>

            <?php
                endforeach;
            ?>
            <button type="submit" class="btn btn-primary">Responder</button>
        </form>
    </div>
</section>
