<?php

if(isset($_SESSION['success']) && !empty($_SESSION['success'])):?>
    <p class="alert alert-success"><?=$_SESSION['success']?></p>
<?php
    unset($_SESSION['success']);
endif;

if(isset($_SESSION['erro']) && !empty($_SESSION['erro'])):?>
    <p class="alert alert-erro"><?=$_SESSION['erro']?></p>
<?php
    unset($_SESSION['erro']);
endif;
?>

