<?php /*Página de atendente - chamar senha*/
    require_once "controller/controller-chamar.php";
    //TER TAMBEM A CONTAGEM DE QUANTAS SENHAS FORAM CHAMADAS NO DIA
$hora1 = new DateTime(date("H:i:s"));
$hora2 = new DateTime("19:22:12");

$hr = $hora2->diff($hora1)->format('%H:%I:%S');
echo date("H:i:s");
?>

<a href="?logout=true">Sair</a>
<p style="right:10px; position: absolute">Bem vindo, <?=$_SESSION['atendente']?></p>
<div align="center">
    <p><?=$mensagem?></p>
    <form method="post">
        <?=$botao?>
    </form>
    <a href="/mase/&finalizar=ok">Finalizar atendimento</a>
    <div id="conteudo"></div>
</div>

<?php if(isset($_GET['finalizar'])){ ?>
    <div id="finalizar_senha">
        <h2>Finalizar atendimento</h2>
        <p>Selecione o tipo de atendimento realizado.</p>
        <form method="post">
    <?php
        if($tipoAtendimento->pegarTudoLinhas() > 0){ ?>
            <input type="hidden" name="atendente" value="<?=$atendente->pegarId($_SESSION['atendente'])?>">
            <input type="hidden" name="data" value="<?=date("Y-m-d")?>">
            <select name="tipo_atendimento" required>
    <?php
            foreach($tipoAtendimento->pegarTudo() as $key => $value){
    ?>
                <option value="<?=$value->id_tipo_atendimento?>"><?=$value->nome_tipo?></option>
            <?php } ?>
            </select>
        <?php }else{?>
        <p>Não há nenhum tipo de atendimento para ser escolhido</p>
            <?php }?>
            <input type="submit" value="Finalizar" name="finalizar">
            <a href="/mase/">Cancelar</a>
        </form>
    </div>
<?php } ?>
