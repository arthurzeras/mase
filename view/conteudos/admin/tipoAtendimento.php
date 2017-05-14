<?php require_once "controller/controller-admin.php";?>

<section id="conteudo_tipo_atendimento">
    <header class="header" id="header_adm">
        <a class="voltar_pagina" href="<?=PATH?>"><i class="flaticon-back"></i></a>
        <?=$imagemLogo?>
        <div id="botoes_adm_atendente">
            <a data-toggle="tooltip" id="add_atendimento" data-placement="bottom" title="Cadastrar novo" class="add_novo" href="<?=PATH?>admin/tipoatendimento&add=novo"><img src="../assets/img/icon-plus.png"></a>
            <span id="divisor"></span>
            <a class="icones_header logout" href="<?=PATH?>admin/tipoatendimento&logout=true"><i class="flaticon flaticon-logout"></i></a>
        </div>
    </header>
    <div id="corpo">
        <div class="header_corpo" id="tipo_atendimento_header">
            <img id="icon-plus" src="../assets/img/icon-tipos.png">&nbsp;<h1>Tipos de Atendimento</h1>
            <span class="linha_header"></span>
        </div>
        <div class="lista_tabela">
            <table>
                <tr>
                    <th>Tipo de Atendimento</th>
                    <th colspan="2" align="center">Ações</th>
                </tr>
        <?php if(!isset($_GET['do'])){
                if($tipoAtendimento->pegarTudoLinhas() > 0){
                    foreach ($tipoAtendimento->pegarTudo() as $key => $item) { ?>
                        <tr class="items">
                            <td><?=$item->nome_tipo?></td>
                            <td><a href="<?=PATH?>admin/tipoatendimento&do=update&id=<?=$item->id_tipo_atendimento?>"><i class="flaticon-edit"></i></a></td>
                            <td><a onclick="confirmar('tipo_atendimento','<?php echo ($item->id_tipo_atendimento);?>', '<?php echo ($item->nome_tipo);?>');"><i class="flaticon-garbage"></i></a></td>
                        </tr>
                    <?php }
                }else{ ?>
                    <tr>
                        <td colspan="3">Não há nenhum tipo de atendimento cadastrado.</td>
                    </tr>
            <?php }
        }else if (isset($_GET['do']) && $_GET['do'] == "update"){
            $id = $_GET['id'];
            foreach ($tipoAtendimento->pegarTudo() as $key => $item){ ?>
                <tr class="items">
        <?php
                if ($tipoAtendimento->pegarId($item->nome_tipo) == $id){
                    $result = $tipoAtendimento->pegarLinha($id);
        ?>
                    <form method="post">
                        <td class="editando">
                            <span class="flaticon-edit"></span>
                            <input type="text" value="<?=$result->nome_tipo?>" placeholder="Título do atendimento" name="nome_tipo" required autofocus>
                        </td>
                        <input type="hidden" value="<?=$result->id_tipo_atendimento?>" name="id">
                        <td class="editando"><button name="alterar_atendimento" type="submit"><img src="../assets/img/icon-save.png"></button></td>
                        <td class="editando"><a href="<?=PATH?>admin/tipoatendimento"><i class="flaticon-cancel"></i></a></td>
                    </form>
        <?php } else { ?>
                    <td class="bloqueado"><?=$item->nome_tipo?></td>
                </tr>
        <?php } } } ?>
            </table>
        </div>
    </div>

    <?php
    echo $msg;

    if(isset($_GET['add']) && $_GET['add'] == "novo"){
        ?>
        <div id="add_novo">
            <div id="janela_add">
                <a id="fechar" href="<?=PATH?>admin/tipoatendimento"><img src="../assets/img/icon-close.png"></a>
                <h2>Novo tipo de atendimento</h2>
                <form method="post">
                    <input type="text" class="campos_tipo input_attr" id="tipo_atendimento" name="tipo_atendimento" required autofocus>
                    <label id="placeholder_tipo" class="placeholder tipo_atendimento" for="tipo_atendimento" >Nome do tipo</label>
                    <a href="javascript:void(0);" tabindex="-1" class="limpar limpar_tipo">×</a>

                    <input type="submit" class="campos_tipo botao" value="Cadastrar">
                </form>
                <?=$msgerr?>
            </div>
        </div>
    <?php } ?>
</section>