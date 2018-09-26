<div class="curso">
    <section class="grade">
        <h3>Grade curricular do curso</h3>

        <ul class="lista-modulos">
            <?php
                foreach($modulos as $modulo):
            ?>
            <li><span class="nome-modulo"><?=$modulo['nome']?></span>
                    <ul class="lista-aulas">
                        <?php
                            foreach($modulo['aulas'] as $aula):
                        ?>

                        <li><?=$aula[$aula['tipo_nome']]['nome']?></li>

                        <?php
                            endforeach;
                        ?>
                    </ul> 
                </li>
            <?php
                endforeach;
            ?>
        </ul>
    </section><!--aulas-->
    <section class="descricao">
        <h3>Descrição</h3>
        <p>Mussum Ipsum, cacilds vidis litro abertis. Si u mundo tá muito paradis? Toma um mé que o mundo vai girarzis! 
            Nec orci ornare consequat. Praesent lacinia ultrices consectetur. Sed non ipsum felis. Admodum accumsan 
            disputationi eu sit. Vide electram sadipscing et per. Quem num gosta di mé, boa gentis num é.

            Suco de cevadiss deixa as pessoas mais interessantis. Não sou faixa preta cumpadi, sou preto inteiris, inteiris. 
            Paisis, filhis, espiritis santis. Suco de cevadiss, é um leite divinis, qui tem lupuliz, matis, aguis e fermentis.

            Si num tem leite então bota uma pinga aí cumpadi! Nullam volutpat risus nec leo commodo, ut interdum diam laoreet. 
            Sed non consequat odio. Viva Forevis aptent taciti sociosqu ad litora torquent. Praesent vel viverra nisi. 
            Mauris aliquet nunc non turpis scelerisque, eget.</p>
    </section>
    <section class="inscrever">
        <h3>Video de demonstração</h3>
        <img src="<?=BASE_URL.'assets/images/cursos/'.$curso["imagem"]?>" alt="<?=$curso['nome']?>">
        <a href="<?=BASE_URL.'cursos/inscrever/'.$curso['id']?>" class="btn btn-primary">Inscrever</a>

    </section>
</div><!--conteudo-->



