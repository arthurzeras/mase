<?php /*Página de atendente - chamar senha*/
require_once "controller/controller-chamar.php";
//TER TAMBEM A CONTAGEM DE QUANTAS SENHAS FORAM CHAMADAS NO DIA
?>
<section id="conteudo_atendente">
    <header class="header" id="header_atendente">
        <?=$imagemLogo?>
        <div id="info">
            <p id="nome_atendente"><?=$_SESSION['atendente']?></p>
            <div id="icones_header">
                <a class="icones_header info" href="javascript:void(0)"><img id="icon_info" src="<?=$diretorio?>/img/icon-info.png"></a>
                <a class="icones_header config" href="&editar=editar"><i class="flaticon flaticon-settings"></i></a>
                <?=$botaoLogout?>
            </div>
        </div>
    </header>
    <div id="atendendo">
        <h1>Atendendo</h1>
        <?=$mensagem?>
        <span id="linha_atendente"></span>
        <div id="botoes_senha">
            <form method="post">
                <?=$botao?>
            </form>
            <?=$botao_finalizar?>
        </div>
    </div>
    <div id="ultimas_pedidas">
        <h2>Já pedidas</h2>
        <div id="ultimas_conteudo"></div>
    </div>
    <?php include_once "view/conteudos/atendente/menu-info.php";
     if(isset($_GET['finalizar'])){ ?>
        <div id="finalizar_senha">
            <div id="janela_finalizar">
                <a href="/mase/"><img id="icon_close" src="assets/img/icon-close.png"></a>
                <h2>Finalizar atendimento</h2>
                <span id="linha_atendimento"></span>
                <h3>Selecione o tipo de atendimento realizado:</h3>
                <form method="post" id="formulario_finalizar">
                    <?php
                    if($tipoAtendimento->pegarTudoLinhas() > 0){ ?>
                        <input type="hidden" name="atendente" value="<?=$atendente->pegarId($_SESSION['atendente'])?>">
                        <input type="hidden" name="data" value="<?=date("Y-m-d")?>">
                        <span id="botao_select"><img src="assets/img/icon-select.png"></span>
                        <select id="tipos_atendimento" name="tipo_atendimento" required>
                            <?php
                            foreach($tipoAtendimento->pegarTudo() as $key => $value){
                                ?>
                                <option value="<?=$value->id_tipo_atendimento?>"><?=$value->nome_tipo?></option>
                            <?php } ?>
                        </select>
                    <?php }else{?>
                        <p>Não há nenhum tipo de atendimento para ser escolhido</p>
                    <?php }?>
                    <button id="botao_finalizar" type="submit" name="finalizar">Finalizar</button>
                </form>
            </div>
        </div>
    <?php }else if(isset($_GET['editar'])){
            include_once "view/conteudos/atendente/alterar-senha.php";
        }
    ?>
</section>