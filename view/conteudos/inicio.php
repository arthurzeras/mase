<?php /*Página de atendente - chamar senha*/
    require_once "controller/controller-chamar.php";
    //TER TAMBEM A CONTAGEM DE QUANTAS SENHAS FORAM CHAMADAS NO DIA
?>

<a href="?logout=true">Sair</a>
<p style="right:10px; position: absolute">Bem vindo, <?=$_SESSION['atendente']?></p>
<div align="center">
    <p><?=$mensagem?></p>
    <form method="post">
        <input type="submit" value="Chamar Próxima Senha" name="chamar">
        <input type="submit" value="Finalizar atendimento" name="finalizar">
    </form>
    <div id="conteudo"></div>
</div>
