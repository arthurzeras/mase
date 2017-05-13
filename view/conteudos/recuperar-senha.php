<?php require_once "controller/controller-recuperar.php"?>

<section id="recuperar_senha">
    <a class="voltar_pagina" href="<?=PATH?>"><i class="flaticon-back"></i> <span>Voltar</span></a>
    <article id="janela">
        <h1>Recuperar senha</h1>
        <p>Digite seu e-mail para recuperar a senha.</p>
        <form method="post">
            <input class="input" type="email" name="email" placeholder="E-mail" id="email" autofocus required>
            <button class="input" id="botao" type="submit">Enviar</button>
        </form>
        <p id="mensagem"><?=$mensagem?></p>
    </article>
</section>