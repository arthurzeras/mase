<?php require_once "controller/controller-login.php"; ?>

<div id="conteudo_login">
    <img id="imagem_logo" src="assets/img/logo_header.png" class="img-responsive">
    <div id="janela_login" class="center-block">
        <h1>login</h1>
        <span id="linha_login"></span>
        <div id="formulario_login">
            <form method="post">
                <input type="number" id="matricula" class="campos_login input_login" name="matricula" max="10" required>
                <label id="placeholder_matricula" class="placeholder matricula" for="matricula">Matrícula</label>
                <a href="javascript:void(0)" tabindex="-1" class="limpar limpar_matricula">×</a>
                <input type="password" id="senha" class="campos_login input_login" name="senha" required>
                <label id="placeholder_senha" class="placeholder senha" for="senha">Senha</label>
                <a href="javascript:void(0)" tabindex="-1" class="limpar limpar_senha">×</a>
                <input type="submit" class="campos_login botao" value="ENTRAR">
                <div id="panel_end">
                    <p id="input_checkbox"><input type="checkbox" name="chkbox" id="checkbox">
                        <label for="checkbox"></label>
                    </p>
                    <p id="label">Permanecer conectado</p>
                    <a href="#" id="esqueceu_senha">Esqueceu a senha?</a>
                </div>
                <p class="mensagem-erro"><?=$error?></p>
            </form>
        </div>
    </div>
</div>