<section class="coluna form-login">
    <h1>Cadastro de Aluno</h1>
    <form method="POST">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email">
        </div>
        <div class="form-group">
            <label for="nivel">Tipo de usuário</label>
            <select name="nivel">
                <option value="1">Aluno</option>
                <option value="2">Instrutor</option>
            </select>
        </div>

        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" name="senha1">
        </div>
        <div class="form-group">
            <label for="senha">Confirme sua senha</label>
            <input type="password" name="senha2">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>

    </form>

    <?php
        if(!empty($aviso)){
            echo "<p>".$aviso."</p>";
        }
    ?>
</section>