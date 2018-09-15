<section class="add-curso">
    <section class="esquerda">
    <?php
        require 'alerts.php';
        if(isset($curso)):
    ?>
    
        <form method="POST" action="<?=BASE_URL.'cursos/atualizar/'.$curso['id']?>" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$curso['id']?>">
            <?php
                else:
            ?>  
            <form method="POST" action="<?=BASE_URL.'cursos/cadastrar'?>" enctype="multipart/form-data" 
                  class="form-add-curso">
            <?php
                endif;
            ?>
            <fieldset class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" 
            <?php 
                if(isset($nome)){ 
                    echo 'value="'.$nome.'"';
                }
                else if(isset($curso['nome'])){
                    echo 'value="'.$curso['nome'].'"';
                }
            ?>>
            </fieldset>
            
            <fieldset class="form-group">                
                <label for="imagem">Imagem</label>
                <div class="imagem-add-curso">
                    <?php 
                        if(isset($curso['imagem'])):
                    ?>
                    <img src="<?=BASE_URL.'/assets/images/cursos/'.$curso['imagem']?>" class="img-thumbnail">
                    <?php
                        endif;
                    ?>
                    <input type="file" name="imagem">       
                </div>
            </fieldset>
                
            <fieldset class="form-group">
                <label for="descricao">Descrição </label>
                <textarea name="descricao"><?php
                    if(isset($descricao)){ 
                            echo $descricao;
                        }
                        else if(isset($curso['descricao'])){
                            echo $curso['descricao'];
                        }
                    ?></textarea>
            </fieldset>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <?php
            if(isset($erro)):
        ?>
            <p class="alert alert-erro"><?=$erro?></p>
        <?php 
            endif; 
        ?>
        <?php
            if(isset($curso)):
        ?>
            
        <div class="form-add-modulo">
            <h4>Adicionar módulo</h4>
            <form method="POST" class="form-add add" action="<?=BASE_URL.'modulos/adicionar'?>">
                <fieldset class="form-group">   
                    <input type="text" name="modulo">
                    <input type="hidden" name="id_curso" value="<?=$curso['id']?>">
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </fieldset>
            </form>
        </div>
    </section>
    <section class="direita">
        <h4>Adicionar Aula</h4>
        <div class="form-add-aula">
            <form method="POST" class="form-add" action="<?=BASE_URL.'aulas/adicionar'?>">
                <div class="form-group">
                    <label for="aula">Título</label>
                    <input type="text" name="aula">      
                </div>
                <div class="form-group">
                    <label for="modulo-aula">Módulo</label>
                    <select name="modulo-aula">
                        <?php
                            foreach($modulos as $modulo):
                        ?>
                        <option value="<?=$modulo['id']?>"><?=$modulo['nome']?></option>
                        <?php
                            endforeach
                        ?>
                    </select> 
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo</label>    
                    <select name="tipo">
                        <option value="1">Vídeo</option>
                        <option value="2">Questionário</option>
                    </select> 
                </div>

                <input type="hidden" name="id_curso" value="<?=$curso['id']?>">
                <button type="submit" class="btn btn-primary">Adicionar</button>
            </form>
        </div><!--form-add-aula-->
        <?php
            if(isset($modulos) && !empty($modulos)):
        ?>
        <ul class="lista-modulos" id="lista-modulos">
            <h4>Módulos</h4>
            <?php
                foreach($modulos as $modulo):
            ?>
            <li class="modulo">
                <div class="container-li li-modulo">
                    <span class="nome-modulo"><?=$modulo['nome']?></span>
                    <div class="icon-buttons">
                        <a href="javascript:;" onclick="editForm(this)" data-modulo-id="<?=$modulo['id']?>"><i class="far fa-edit editar"></i></a>
                        <a href="javascript:;" onclick="deleteModulo(this)" data-modulo-id="<?=$modulo['id']?>">
                            <i class="far fa-trash-alt excluir"></i>
                        </a>
                    </div>
                </div>
                <form method="POST" class="form-edit-modulo" id="editar<?=$modulo['id']?>" 
                      action="<?=BASE_URL.'modulos/editar/'.$modulo['id']?>">
                    <legend>Editar módulo</legend>
                    <fieldset class="form-group">
                        <input type="text" name="modulo">
                        <button type="submit" class="btn btn-primary" id="btn-editar">Editar</button>
                    </fieldset>
                </form>
                <ul class="lista-aulas" id="lista-aulas<?=$modulo['id']?>">
                    <?php
                        foreach ($modulo['aulas'] as $aula):
                            //var_dump($aula);
                            //exit;
                    ?>
                    <li class="container-li">
                        <span class="nome"><?=(($aula['tipo'] == 1 ) ? $aula['video']['nome'] : $aula['questionario']['nome']  )?></span>
                        <div class="icon-buttons">
                            <a href="<?=BASE_URL.'aulas/editar/'.$aula['id']?>"><i class="far fa-edit editar"></i></a>
                            <a href="javascript:;" onclick="deleteAula(this)" data-aula-id="<?=$aula['id']?>">
                                <i class="far fa-trash-alt excluir"></i>
                            </a>
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
        <?php
            endif;
        ?>
    <?php
        endif;
    ?>
    </section>
</section>