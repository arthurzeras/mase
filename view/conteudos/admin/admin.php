<?php
include_once "controller/controller-admin.php";
?>


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

<h1 align="center">Tela de Administrador</h1>


<div align="center">
    <a href="/mase/admin/addatendente" style="position:absolute; right: 10px">+ Cadastrar Novo</a>
    <h2>Atendentes Cadastrados</h2>

    <table>
        <?php foreach ($atendente->pegarTudo() as $key => $item) { ?>
            <tr>
                <td><?=$item->matricula?></td>
                <td><?=$item->nome_atendente?></td>
                <td><a href="?do=update&id=<?=$item->id_atendente?>">Alterar</a></td>
                <td><a href="?do=del&id=<?=$item->id_atendente?>">Deletar</a></td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php
    echo $msgUpdate;

    if($acao == "update"){
    $saida = $atendente->pegarLinha((int)$id);
?>
    <div align="center" id="janela_alterar" style="margin-top: 50px;">
        <form method="post">
            <input type="text" value="<?=$saida->matricula?>" placeholder="Matrícula do Atendente" name="matricula" required>
            <input type="text" value="<?=$saida->nome_atendente?>" placeholder="Nome" name="nome" required>
            <input type="hidden" value="<?=$saida->id_atendente?>" name="id">
            <input type="submit" value="Alterar" name="alterar">
        </form>
    </div>

<?php } ?>
