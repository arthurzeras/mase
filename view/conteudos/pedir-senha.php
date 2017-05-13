<?php require_once "controller/controller-pedir.php"; ?>

<section id="pedir_senha">
    <h1>Peça aqui sua senha</h1>
    <article>
        <form method="post">
            <button id="botao_pedir" type="submit" name="gerar">Pedir senha</button>
            <div id="preferencial">
                <span id="input_checkbox">
                    <input type="checkbox" name="preferencial" id="checkbox">
                    <label for="checkbox"></label>
                </span>
                <p id="label">Atendimento preferencial?</p>
            </div>
        </form>
    </article>
    <p id="senha"><?=$senha?></p>
</section>