<?php require_once "controller/controller-admin.php";?>

<section id="conteudo_guiches">
    <header class="header" id="header_adm">
        <a class="voltar_pagina" href="<?=PATH?>"><i class="flaticon-back"></i></a>
        <?=$imagemLogo?>
        <div id="botoes_adm_atendente">
            <a data-toggle="tooltip" id="add_atendimento" data-placement="bottom" title="Cadastrar novo" class="add_novo" href="<?=PATH?>admin/guiches&add=novo"><img src="../assets/img/icon-plus.png"></a>
            <span id="divisor"></span>
            <a class="icones_header logout" href="<?=PATH?>admin/tipoatendimento&logout=true"><i class="flaticon flaticon-logout"></i></a>
        </div>
    </header>
    <div id="corpo">
        <div class="header_corpo" id="tipo_atendimento_header">
            <img id="icon-plus" src="../assets/img/icon-guiche.png">&nbsp;<h1>Guichês</h1>
            <span class="linha_header"></span>
        </div>
        <div class="lista_tabela">
            <table>
                <tr>
                    <th>IP da máquina</th>
                    <th>Número do guichê</th>
                    <th colspan="2" align="center">Ações</th>
                </tr>
<?php       if(!isset($_GET['do'])){
                if($guiche->pegarTudoLinhas() > 0){
                    foreach($guiche->pegarTudo() as $key => $item){
?>
                        <tr class="items">
                            <td><?=$item->ip_maquina?></td>
                            <td><?=$item->numero_guiche?></td>
                            <td><a href="<?=PATH?>admin/guiches&do=update&id=<?=$item->id_guiche?>"><i class="flaticon-edit"></i></a></td>
                            <td>
                                <a onclick="confirmar('guiches', '<?=$item->id_guiche?>', '<?=$item->ip_maquina?>')">
                                    <i class="flaticon-garbage"></i>
                                </a>
                            </td>
                        </tr>
<?php
                    }
                }else{
?>
                    <tr>
                        <td colspan="4">Não existe nenhum guichê cadastrado</td>
                    </tr>
<?php
                }
            }else if(isset($_GET['do']) && $_GET['do'] == "update"){
                $id = $_GET['id'];
                foreach($guiche->pegarTudo() as $key => $item) {
?>
                    <tr class="items">
<?php
                        if($guiche->pegarId($item->ip_maquina) == $id){
                            $result = $guiche->pegarLinha($id);
?>
                            <form method="post">
                                <input type="hidden" value="<?=$result->id_guiche?>" name="id">
                                <td class="editando">
                                    <span class="flaticon-edit"></span>
                                    <input type="text" name="ip_maquina" value="<?=$result->ip_maquina?>" placeholder="IP da máqina" autofocus required>
                                </td>
                                <td class="editando">
                                    <input type="number" value="<?=$result->numero_guiche?>" placeholder="Número do guichê" required>
                                </td>
                                <td class="editando"><button name="alterar_guiche" type="submit"><img src="../assets/img/icon-save.png"></button></td>
                                <td class="editando"><a href="<?=PATH?>admin/guiches"><span class="flaticon-cancel"></span></a></td>
                            </form>
<?php
                        }else{
?>
                            <td class="bloqueado"><?=$item->ip_maquina?></td>
                            <td class="bloqueado"><?=$item->numero_guiche?></td>
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
                <a id="fechar" href="<?=PATH?>admin/guiches"><img src="../assets/img/icon-close.png"></a>
                <h2>Novo guichê</h2>
                <form method="post">
                    <input type="text" class="campos_tipo input_attr" id="ip_maquina" name="ip_maquina" required autofocus>
                    <label id="placeholder_ip_maquina" class="placeholder ip_maquina" for="ip_maquina" >
                        IP da máquina. Ex: 192.168.0.155
                        <img src="../assets/img/icon-help.png" data-toggle="tooltip" data-placement="right" title="O ip é um código único de cada computador para identificá-lo na rede. Para descobrir o IP da máquina digite 'ipconfig' no prompt de comando do windows, ele estará descrito como IPv4.">
                    </label>
                    <a href="javascript:void(0);" tabindex="-1" class="limpar limpar_ip_maquina">×</a>

                    <input type="number" class="campos_tipo input_attr" id="num_guiche" name="num_guiche" required>
                    <label id="placeholder_ip_maquina" class="placeholder num_guiche" for="num_guiche" >Número do guichê</label>
                    <a href="javascript:void(0);" tabindex="-1" class="limpar limpar_num_guiche">×</a>

                    <input type="submit" class="campos_tipo botao" value="Cadastrar">
                </form>
                <?=$msgerr?>
            </div>
        </div>
    <?php } ?>
</section>