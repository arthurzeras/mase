<?php
include_once "controller/controller-admin.php";
?>

<script src="assets/js/scripts.js"></script>
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
    <a href="/mase/&logout=ok" style="position: absolute; left: 10px">Sair</a>
    <h2>Atendentes Cadastrados</h2>

    <table>
        <?php foreach ($atendente->pegarTudo() as $key => $item) { ?>
            <tr>
                <td><?=$item->matricula?></td>
                <td><?=$item->nome_atendente?></td>
                <td><a href="/mase/&do=update&id=<?=$item->id_atendente?>">Alterar</a></td>
                <td><a style="cursor: pointer;" onclick="confirmar('<?php echo ($item->id_atendente);?>', '<?php echo ($item->nome_atendente);?>');">Deletar</a></td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php
    echo $msg;

    //SE EXISTIR O GET DE ALTERAR, EXIBE OS DADOS A SEREM ALTERADOS
    if(isset($_GET['do']) && $_GET['do'] == "update"){
    $id = $_GET['id'];
    $result = $atendente->pegarLinha($id);
?>
    <div align="center" id="janela_alterar" style="margin-top: 50px;">
        <form method="post">
            <input type="text" value="<?=$result->matricula?>" placeholder="Matrícula do Atendente" name="matricula" required>
            <input type="text" value="<?=$result->nome_atendente?>" placeholder="Nome" name="nome" required>
            <input type="hidden" value="<?=$result->id_atendente?>" name="id">
            <input type="submit" value="Alterar" name="alterar">
        </form>
    </div>
<?php } ?>
