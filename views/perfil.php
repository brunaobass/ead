<section class="perfil-usuario">
    <?php
        require 'alerts.php';
    ?>
    <div class="area-perfil">
        <div class="foto">
            <figure class="moldura-perfil">
                <img src="<?=(isset($usuario['imagem'])? BASE_URL.'assets/images/usuarios/'.$usuario['imagem']
                           : BASE_URL.'assets/images/usuarios/perfil-default.png')?>" 
                     class="foto-perfil" id="img_preview">
            </figure>
            
            <a href="javascript:;" class="btn btn-primary" id="btn-troca-foto">
                <?=(isset($edicao)? 'TROCAR FOTO' : 'ESCOLHER FOTO')?>
            </a>
        </div>
        <div class="form-perfil">
            <h2>Seus Dados</h2>
            <?php
                if(isset($edicao)):
            ?>
                <form method="POST" action="<?=BASE_URL?>perfil/editar/" enctype="multipart/form-data">
            <?php
                else:
            ?>
                <form method="POST" action="<?=BASE_URL?>login/cadastrar/" enctype="multipart/form-data">
            <?php
                endif;
            ?>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" <?=(isset($usuario) ? 
                    'value="'.$usuario['nome'].'"': '')?> >
                </div>
                <div class="form-group">
                    <label for="username">Nome de usuário:</label>
                    <input type="text" name="username" <?=(isset($usuario) ? 
                        'value="'.$usuario['username'].'"': '')?> >
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <?php
                        if(isset($edicao)):
                    ?>
                    <p><?=$usuario['email']?></p>
                    <?php
                        else:
                    ?>
                        <input type="email" name="email"<?=(isset($usuario) ? 
                            'value="'.$usuario['email'].'"': '')?> >
                    <?php
                        endif;
                    ?>
                </div>
                <?php
                    if(!isset($edicao)):?>
                    <div class="form-group">
                        <label for="nivel">Tipo de usuário</label>
                        <select name="nivel" >
                            <option value="1">Aluno</option>
                            <option value="2">Instrutor</option>
                        </select>
                    </div>
                <?php
                    endif;
                ?>
                <div class="form-group">
                    
                    <label for="senha1"><?= (isset($edicao) ? 'Nova senha' : 'Senha' )?>:</label>
                    <input type="password" name="senha1">
                </div>
                <div class="form-group">
                    <label for="senha2">Confirmar senha:</label>
                    <input type="password" name="senha2">
                </div>
                <input type="file" name="foto" id="input-foto" onchange="trocaFoto()">
                <button type="submit" class="btn btn-primary">SALVAR</button>
            </form>
        </div><!--form-perfil-->
    </div><!--area-perfil-->
</section>