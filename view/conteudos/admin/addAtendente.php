<?php include_once "controller/controller-admin.php";

if($_SESSION['matricula'] != ""){
    $activePlaceholder = "active";
}else{
    $activePlaceholder = "";
}

?>
<section id="conteudo_add_atendente">
    <header class="header" id="header_adm">
        <a class="voltar_pagina" href="<?=PATH?>admin/atendentes"><i class="flaticon-back"></i></a>
        <?=$imagemLogo?>
        <div id="botoes_adm_atendente">
            <a class="icones_header logout" href="<?=PATH?>admin/addatendente&logout=true"><i class="flaticon flaticon-logout"></i></a>
        </div>
    </header>
    <div id="corpo">
        <div class="header_corpo" id="add_atentente_header">
            <img src="../assets/img/icon-plus.png">&nbsp;<h1>Cadastrar novo atendente</h1>
            <span class="linha_header"></span>
        </div>
        <div id="formulario_add">
            <form method="post">
                <input type="number" value="<?=$_SESSION['matricula']?>" id="matricula" class="campos_add input_attr" name="matricula" required autofocus>
                <label id="placeholder_matricula" class="placeholder matricula <?=$activePlaceholder?>" for="matricula">Matrícula</label>
                <a href="javascript:void(0);" tabindex="-1" class="limpar limpar_matricula">×</a>

                <input type="text" value="<?=$_SESSION['nome']?>" id="nome" class="campos_add input_attr" name="nome" required>
                <label id="placeholder_nome" class="placeholder nome <?=$activePlaceholder?>" for="nome">Nome</label>
                <a href="javascript:void(0);" tabindex="-1" class="limpar limpar_nome">×</a>

                <input type="email" value="<?=$_SESSION['email']?>" id="email" class="campos_add input_attr" name="email" required>
                <label id="placeholder_email" class="placeholder email <?=$activePlaceholder?>" for="email">E-mail</label>
                <a href="javascript:void(0);" tabindex="-1" class="limpar limpar_email">×</a>

                <input class="campos_add botao" type="submit" value="Cadastrar">
            </form>
            <p id="obs">*A senha é gerada automaticamente, sendo o mesmo número da matrícula.</p>
            <?=$msg?>
        </div>
    </div>
</section>