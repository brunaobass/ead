<form class="form-questionario" method="POST" 
          action="<?=BASE_URL.'aulas/editarQuestionario/'.$questionario['id']?>">
    <h2 class="form-group titulo-secundario">
        <span><?=$questionario['nome']?></span>
        <a href="javascript:;" onclick="editarQuestionario(this)" class="btn-editar-alternativa" 
            data-id-questionario ="<?=$questionario['id']?>">
             <i class="far fa-edit editar"></i>
         </a>
        <input type="text" name="nome-questionario" class="input-hidden" value="<?=$questionario['nome']?>">
        
    </h2>

    <h3></h3>
    <div class="form-edit-aula">
    
        <div id="areaquestao">
            <?php
            if(count($questionario['questoes'])>0):
                foreach($questionario['questoes'] as $questao):
            ?>
            <div class="questao">
                <div class="form-group">
                    <strong>
                    <span><?=$questao['id']?> - </span>
                    <span class="enunciado"><?=$questao['pergunta']?></span></strong>
                    
                    <a href="javascript:;" onclick="editarQuestao(this)" class="btn-editar-alternativa" 
                        data-id-questao ="<?=$questao['id']?>">
                         <i class="far fa-edit editar"></i>
                     </a>
                <input type="text" name="questao<?=$questao['id']?>" class="input-hidden" value="<?=$questao['pergunta']?>">
                <input type="hidden" name="id-questao<?=$questao['id']?>" value="<?=$questao['id']?>">
            </div><!--questao-->
            <ul class="lista lista-opcoes" id="opcoes-questao<?=$questao['id']?>">
                <?php
                    foreach($questao['alternativas'] as $alternativa):

                ?>

                <li class="form-group" id="<?='quest'.$questao['id'].'alt'.$alternativa['id']?>">
                    <input type="radio" name="resposta-questao<?=$questao['id']?>" value="<?=$alternativa['id']?>"
                           <?=($questao['resposta']==$alternativa['id'] ? 'checked="checked"' : '')?>>
                    <span><?=$alternativa['texto']?></span>

                    <a href="javascript:;" onclick="editarAlternativa(this)" class="btn-editar-alternativa" 
                       data-id-questao ="<?=$questao['id']?>" data-id-alternativa="<?=$alternativa['id']?>">
                       <i class="far fa-edit editar"></i>
                    </a>
                    <input type="text" name="quest<?=$questao['id']?>-alt<?=$alternativa['id']?>" class="input-hidden"
                           value="<?=$alternativa['texto']?>">
                    <input type="hidden" name="id-quest<?=$questao['id']?>-alt<?=$alternativa['id']?>" 
                           value="<?=$alternativa['id']?>">
                </li>
                
                <?php
                    endforeach;
                ?>
            </ul>
        
            </div>
        <?php
            endforeach;
        endif; 
        ?>
        </div><!--areaquestao-->
        <input type="hidden" name="id-ultima-questao-prev" value="<?=(isset($questao) ? $questao['id'] : 0)?>">
        <input type="hidden" name="id-ultima-questao" value="<?=(isset($questao) ? $questao['id'] : 0)?>">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
    
    <a href="javascript:;" onclick="adicionarQuestao(this)" class="btn btn-primary" 
       data-id-ultima-questao="<?=(isset($questao) ? $questao['id'] : 0)?>">Nova Questão</a>
</div><!--form-edit-aula-->