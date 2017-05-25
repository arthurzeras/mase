<?php
include_once "controller/controller-admin.php";
?>

<section id="conteudo_perfil">
    <header class="header" id="header_adm">
        <a class="voltar_pagina" href="<?=PATH?>"><i class="flaticon-back"></i></a>
        <?=$imagemLogo?>
        <div id="botoes_adm_atendente">
            <a data-toggle="tooltip" data-placement="bottom" title="Cadastrar novo perfil" class="add_novo" href="<?=PATH?>admin/perfis&add=novo"><img src="../assets/img/icon-plus.png"></a>
            <span id="divisor"></span>
            <a class="icones_header logout" href="<?=PATH?>admin/perfis&logout=true"><i class="flaticon flaticon-logout"></i></a>
        </div>
    </header>
    <div id="corpo">
        <div class="header_corpo" id="perfis_header">
            <img src="../assets/img/icon-users.png">
            <h1>Perfis</h1>
            <span class="linha_header"></span>
        </div>
        <div class="lista_tabela">
            <table>
                <tr>
                    <th>Nome do perfil</th>
                    <th colspan="2" align="center">Ações</th>
                </tr>
                <?php
                if(!isset($_GET['do'])){
                    if($perfil->pegarTudoLinhas() > 0){
                        foreach ($perfil->pegarTudo() as $key => $item) { ?>
                            <tr class="items">
                                <td><?=$item->nome_perfil ?></td>
                                <td><a href="<?=PATH?>admin/perfis&do=update&id=<?=$item->id_perfil?>"><i class="flaticon-edit"></i></a></td>
                                <td><a onclick="confirmar('perfis','<?php echo ($item->id_perfil);?>', '<?php echo ($item->nome_perfil);?>', '<?=PATH?>');"><i class="flaticon-garbage"></i></a></td>
                            </tr>
                        <?php }
                    }else{ ?>
                        <tr>
                            <td colspan="3">Não há perfis cadastrados.</td>
                        </tr>
                    <?php }
                }else if(isset($_GET['do']) && $_GET['do'] == "update"){
                    $id = $_GET['id'];
                    foreach ($perfil->pegarTudo() as $key => $item) { ?>
                        <tr class="items">

                <?php   if($perfil->pegarId($item->nome_perfil) == $id){
                            $result = $perfil->pegarLinha($id);
                ?>
                            <form method="post">
                                <td class="editando">
                                    <span class="flaticon-edit"></span>
                                    <input type="text" value="<?=$item->nome_perfil?>" placeholder="Nome do perfil" name="perfil_editando" autofocus required>
                                </td>
                                <input type="hidden" value="<?=$result->id_perfil?>" name="id">
                                <td class="editando"><button name="alterar_perfil" type="submit"><img src="../assets/img/icon-save.png"></button></td>
                                <td class="editando"><a href="<?=PATH?>admin/perfis"><i class="flaticon-cancel"></i></a></td>
                            </form>
                            <p id="erro"><?=$msg?></p>
                <?php }else{?>
                            <td class="bloqueado"><?=$item->nome_perfil?></td>
                        </tr>
                <?php } } }?>
            </table>
        </div>
    </div>
    
    <?php
    if(isset($_GET['add']) && $_GET['add'] == "novo"){
        ?>
        <div id="add_novo">
            <div id="janela_add">
                <a id="fechar" href="<?=PATH?>admin/perfis"><img src="../assets/img/icon-close.png"></a>
                <h2>Novo Perfil</h2>
                <form method="post">
                    <input type="text" class="campos_perfil input_attr" id="perfil" name="perfil" required autofocus>
                    <label id="placeholder_perfil" class="placeholder perfil" for="perfil" >Nome do perfil</label>
                    <a href="javascript:void(0);" tabindex="-1" class="limpar limpar_perfil">×</a>

                    <input type="submit" class="campos_perfil botao" value="Cadastrar">
                </form>
                <?=$msgerr?>
            </div>
        </div>
    <?php } ?>
</section>