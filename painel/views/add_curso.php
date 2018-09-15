<h2>Novo curso</h2>
<?php
    require 'alerts.php';
    if(isset($curso)):
?>
<form method="POST" action="<?=BASE_URL.'home/atualizar_curso'?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$curso['id']?>">
<?php
    else:
?>  
    <form method="POST" action="cadastrar_curso" enctype="multipart/form-data">
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
        <input type="file" name="imagem">
        <?php 
            if(isset($curso['imagem'])):
        ?>
        <img src="<?=BASE_URL.'../assets/images/cursos/'.$curso['imagem']?>" class="img-thumbnail"> 
        <?php
            endif;
        ?>
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
    <hr>
    <div class="form-add-modulo">
        <h4>Adicionar módulo</h4>
        <form method="POST" class="form-add add">
            <fieldset class="form-group">   
                <input type="text" name="modulo">
                <input type="hidden" name="id_curso" value="<?=$curso['id']?>">
                <button type="submit" class="btn btn-primary">Adicionar</button>
            </fieldset>
        </form>
    </div>
    <div class="form-add-aula">
        <h4>Adicionar Aula</h4>
        <form method="POST" class="form-add">
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
        <?php
            foreach($modulos as $modulo):
        ?>
        <li><span class="nome-modulo"><?=$modulo['nome']?></span>
            <a href="javascript:;" onclick="editForm(this)" data-modulo-id="<?=$modulo['id']?>"><i class="far fa-edit editar"></i></a>
            <a href="javascript:;" onclick="deleteModulo(this)" data-modulo-id="<?=$modulo['id']?>">
                <i class="far fa-trash-alt excluir"></i>
            </a>
            <form method="POST" class="form-add-modulo form-edit-modulo" id="editar<?=$modulo['id']?>">
                <fieldset class="form-group">
                    <legend>Editar módulo</legend>
                    <input type="text" name="modulo">
                    <input type="hidden" name="id" value="<?=$modulo['id']?>">
                    <button type="submit" class="btn btn-primary" id="btn-editar">Editar</button>
                </fieldset>
            </form>
            <ul class="lista-aulas" id="lista-aulas<?=$modulo['id']?>">
                <?php
                    foreach ($modulo['aulas'] as $aula):
                        //var_dump($aula);
                        //exit;
                ?>
                <li><span><?=(($aula['tipo'] == 1 ) ? $aula['video']['nome'] : $aula['questionario']['nome']  )?></span>
                    <a href="<?=BASE_URL.'aulas/editar/'.$aula['id']?>"><i class="far fa-edit editar"></i></a>
                    <a href="javascript:;" onclick="deleteAula(this)" data-aula-id="<?=$aula['id']?>">
                        <i class="far fa-trash-alt excluir"></i>
                    </a>
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