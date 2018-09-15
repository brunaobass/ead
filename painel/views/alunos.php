<h2>Alunos</h2>
<a href="<?=BASE_URL?>alunos/adicionar" class="btn btn-primary btn-add">Adicionar aluno</a>
<table class="tabela-alunos">
    <thead>
        <th>Nome</th>
        <th>Quantidade de Cursos</th>
        <th>Ações</th>
    </thead>
    <tbody>
        <?php
            foreach($alunos as $aluno):
        ?>
        <tr>
            <td><?=$aluno['nome']?></td>
            <td><?=$aluno['total_cursos']?></td>
            <td>
                <a href="<?=BASE_URL.'alunos/editar/'.$aluno['id']?>"><i class="far fa-edit editar"></i></a>
                <a href="<?=BASE_URL.'alunos/excluir/'.$aluno['id']?>"><i class="far fa-trash-alt excluir"></i></a>
            </td>
        </tr>
        <?php
            endforeach;
        ?>
    </tbody>
</table>