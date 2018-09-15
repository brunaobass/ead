
<a href="<?=BASE_URL?>cursos/adicionar" class="btn btn-primary btn-add">Adicionar curso</a>
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