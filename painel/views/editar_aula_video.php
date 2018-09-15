<h2 class="titulo-secundario">Editar Aula - Vídeo</h2>
<?php require 'alerts.php';?>
<div class="form-edit-aula">
    
    <form method="POST" action="<?=BASE_URL.'aulas/editarVideo/'.$video['id_aula']?>">
        <div class="form-group">
            <label for="nome">Título</label>
            <input type="text" name="nome" value="<?=(isset($video['id_aula']) ? $video['nome']:'')?>">      
        </div>
        
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea  name="descricao"><?=(isset($video['id_aula']) ? $video['descricao']:'')?></textarea>      
        </div>
        <div class="form-group">
            <label for="url">URL do vídeo</label>
            <input type="text" name="url" value="<?=(isset($video['id_aula'])?$video['url']:'')?>">      
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div><!--form-add-aula-->
