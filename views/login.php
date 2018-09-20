<?php
    require 'alerts.php';
?>
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
        <div class="login-buttons">
            <button type="submit" class="btn btn-login">Entrar</button>
            <a href="<?=BASE_URL?>login/cadastrar" class="btn btn-cadastrar">Cadastrar</a>
        </div>

        
    </form> 
</section>


