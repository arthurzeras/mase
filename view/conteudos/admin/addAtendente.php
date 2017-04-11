<?php include_once "controller/controller-admin.php";?>

<style>
    input{
        width:50%;
        height: 40px;
        font-size: 13pt;
        margin-bottom: 5px
    }
    input[type="submit"]{
        cursor: pointer;
    }
</style>

<a href="/mase/" style="position: absolute; left: 10px;">< Voltar</a>

<div align="center">
    <h1>Cadastrar novo atendente</h1>

    <form method="post">
        <input type="text" placeholder="Matrícula do Atendente" name="matricula" required>
        <input type="text" placeholder="Nome" name="nome" required>
        <input type="password" placeholder="Senha" name="senha" required>
        <input type="submit" value="Cadastrar">
    </form>

    <?=$msg?>
</div>