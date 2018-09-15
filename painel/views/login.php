
<section class="coluna form-login">
    <form method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email">
        </div>

        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" name="senha">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <br/>
        <a href="<?=BASE_URL?>login/cadastrar" class="btn btn-secundario">Cadastre-se</a>
    </form> 
</section>


