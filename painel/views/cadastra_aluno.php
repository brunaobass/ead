
<?php
    require 'alerts.php';
        if(isset($aluno)):
?>
    <h2>Aluno - <?=($aluno['nome'])?></h2>
    <form method="POST" action="<?=BASE_URL.'home/atualizar_aluno'?>" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$aluno['id']?>">
<?php
    else:
?>  
    <h2>Novo aluno</h2>
    <form method="POST" action="cadastrar_aluno" enctype="multipart/form-data">
<?php
    endif;
?>
    <fieldset class="form-group">
        <label for="nome">Nome</label>
        <input type="text" name="nome" <?=(isset($aluno['nome']) ? 'value="'.$aluno['nome'].'"' :''  )?>>
    </fieldset>
    <fieldset class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" <?=(isset($aluno['email']) ? 'value="'.$aluno['email'].'"' :''  )?>>
    </fieldset>
    <fieldset class="form-group">
        <label for="senha1">Senha</label>
        <input type="password" name="senha1">
    </fieldset>
    <fieldset class="form-group">
        <label for="senha1">Confirme a senha</label>
        <input type="password" name="senha2">
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
    if(isset($aluno)):
?>
    <table class="tabela-cursos">
    <thead>
        <th>Imagem</th>
        <th>Nome</th>
        <th>Quantidade de Alunos</th>
        <th>Ações</th>
    </thead>
    <tbody>
        <?php
            foreach($cursos as $curso):
        ?>
        <tr>
            <td><img src="<?=BASE_URL.'../assets/images/cursos/'.$curso['imagem']?>"</td>
            <td><?=$curso['nome']?></td>
            <td><?=$curso['total_alunos']?></td>
            <td>
                <a href="<?=BASE_URL.'cursos/editar/'.$curso['id']?>"><i class="far fa-edit editar"></i></a>
                <a href="<?=BASE_URL.'cursos/excluir/'.$curso['id']?>"><i class="far fa-trash-alt excluir"></i></a>
            </td>
        </tr>
        <?php
            endforeach;
        ?>
    </tbody>
</table>
<?php
    endif;
?>
