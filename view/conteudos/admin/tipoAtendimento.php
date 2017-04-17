<?php require_once "controller/controller-admin.php";?>
<div align="center">
    <a href="/mase/admin/tipoAtendimento&add=novo" style="position:absolute; right: 10px">+ Cadastrar Novo</a>
    <a href="/mase/" style="position: absolute; left: 10px">&lsaquo; Voltar</a>
    <h2>Tipos de Atendimento</h2>

    <table>
        <tr>
            <td>Tipo de Atendimento</td>
            <td colspan="2" align="center">Ações</td>
        </tr>
        <?php
            if($tipoAtendimento->pegarTudoLinhas() > 0){
                foreach ($tipoAtendimento->pegarTudo() as $key => $item) { ?>
            <tr>
                <td><?=$item->nome_tipo?></td>
                <td><a href="/mase/admin/tipoAtendimento&do=update&id=<?=$item->id_tipo_atendimento?>">Alterar</a></td>
                <td><a style="cursor: pointer;" onclick="confirmar('tipo_atendimento','<?php echo ($item->id_tipo_atendimento);?>', '<?php echo ($item->nome_tipo);?>');">Deletar</a></td>
            </tr>
        <?php }
        }else{ ?>
            <tr>
                <td colspan="3">Não há nenhum tipo de atendimento cadastrado.</td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php

//TESTES
//if(isset($_GET['vsf']) && $_GET['vsf'] == "ta") {
//    echo "<a id='click' href='#'>AAAAAAAAAAAAAAAAA</a>";
//    echo "<div class='teste'></div>";
//}
?>

<?php
echo $msg;

if(isset($_GET['add']) && $_GET['add'] == "novo"){
?>
<div id="add_tipo">
    <a href="/mase/admin/tipoAtendimento">Fechar</a>
    <form method="post">
        <input type="text" name="tipo_atendimento" placeholder="Nome do tipo de atendimento" required>
        <input type="submit" value="Cadastrar">
    </form>
</div>
<?php }

if(isset($_GET['do']) && $_GET['do'] == "update"){
    $id = $_GET['id'];
    $result = $tipoAtendimento->pegarLinha($id);
?>
<div id="alterar_tipo">
    <a href="/mase/admin/tipoAtendimento">Fechar</a>
    <form method="post">
        <input type="text" name="nome_tipo" placeholder="Nome do tipo de atendimento" value="<?=$result->nome_tipo?>">
        <input type="hidden" value="<?=$result->id_tipo_atendimento?>" name="id">
        <input type="submit" name="alterar_atendimento" value="Alterar">
    </form>
</div>
<?php } ?>