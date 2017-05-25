<?php
include_once "controller/controller-admin.php";
?>

<section id="conteudo_adm">
    <header class="header" id="header_adm">
        <a class="voltar_pagina" href="<?=PATH?>"><i class="flaticon-back"></i></a>
        <?=$imagemLogo?>
        <div id="botoes_adm_atendente">
            <a data-toggle="tooltip" data-placement="bottom" title="Cadastrar novo atendente" class="add_novo" href="<?=PATH?>admin/addusuario"><img src="../assets/img/icon-plus.png"></a>
            <span id="divisor"></span>
            <a class="icones_header logout" href="<?=PATH?>admin/usuarios&logout=true"><i class="flaticon flaticon-logout"></i></a>
        </div>
    </header>
    <div id="corpo">
        <div class="header_corpo" id="atendentes_header">
            <img src="../assets/img/icon-users.png">
            <h1>Atendentes</h1>
            <span class="linha_header"></span>
        </div>
        <div class="lista_tabela">
            <table>
                <tr>
                    <th>Perfil</th>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th colspan="2" align="center">Ações</th>
                </tr>
                <?php
                if(!isset($_GET['do'])){
                    if($usuario->pegarTudoLinhas() > 0){
                        foreach ($usuario->pegarTudo() as $key => $item) { 
                            $nome_perfil = $perfil->pegarLinha($item->fk_perfil);
                        ?>
                            <tr class="items">
                                <?php if($item->fk_perfil != 1){ ?>
                                    <td><?=$nome_perfil->nome_perfil?></td>
                                    <td><?=$item->matricula?></td>
                                    <td><?=$item->nome_usuario?></td>
                                    <td><?=$item->email_usuario?></td>
                                    <td><a href="<?=PATH?>admin/usuarios&do=update&id=<?=$item->id_usuario?>"><i class="flaticon-edit"></i></a></td>
                                    <td><a onclick="confirmar('usuarios','<?php echo ($item->id_usuario);?>', '<?php echo ($item->nome_usuario);?>', '<?=PATH?>');"><i class="flaticon-garbage"></i></a></td>
                                <?php } ?>
                            </tr>
                        <?php }
                    }else{ ?>
                        <tr>
                            <td colspan="4">Não há atendentes cadastrados.</td>
                        </tr>
                    <?php }
                }else if(isset($_GET['do']) && $_GET['do'] == "update"){
                    $id = $_GET['id'];
                    foreach ($usuario->pegarTudo() as $key => $item) { ?>
                        <tr class="items">

                <?php   if($usuario->pegarId($item->nome_usuario) == $id){
                            $atendenteEditar = $item->nome_usuario;
                            $result = $usuario->pegarLinha($id);
                ?>
                            <form method="post">
                                <td class="editando">
                                    <span class="flaticon-edit"></span>
                                    <select name="id_perfil">
                <?php foreach($perfil->pegarTudo() as $key => $item){ ?>
                                        <option value="<?=$item->id_perfil?>"><?=$item->nome_perfil?></option>
                <?php } ?>
                                    </select>
                                </td>
                                <td class="editando"><input type="text" value="<?=$result->matricula?>" placeholder="Matrícula do Atendente" name="matricula_editar" required autofocus></td>
                                <td class="editando"><input type="text" value="<?=$result->nome_usuario?>" placeholder="Nome" name="nome_editar" required></td>
                                <td class="editando"><input type="email" value="<?=$result->email_usuario?>" placeholder="Email" name="email_editar" required></td>
                                <input type="hidden" value="<?=$result->id_usuario?>" name="id">
                                <td class="editando"><button name="alterar_usuario" type="submit"><img src="../assets/img/icon-save.png"></button></td>
                                <td class="editando"><a href="<?=PATH?>admin/usuarios"><i class="flaticon-cancel"></i></a></td>
                            </form>
                            <p id="erro"><?=$msg?></p>
                <?php }else{?>
                            <td class="bloqueado"><?=$nome_perfil->nome_perfil?></td>
                            <td class="bloqueado"><?=$item->matricula?></td>
                            <td class="bloqueado"><?=$item->nome_usuario?></td>
                            <td class="bloqueado"><?=$item->email_usuario?></td>
                <?php if($item->nome_usuario !== "admin") {?>
                                <td class="bloqueado"><a href="<?=PATH?>admin/atendentes&do=update&id=<?=$item->id_usuario?>"><i class="flaticon-edit"></i></a></td>
                                <td class="bloqueado"><a onclick="confirmar('atendentes','<?php echo ($item->id_usuario);?>', '<?php echo ($item->nome_usuario);?>', '<?=PATH?>');"><i class="flaticon-garbage"></i></a></td>
                            <?php }else{ ?>
                                <td class="bloqueado" colspan="2"><a href="<?=PATH?>admin/atendentes&do=update&id=<?=$item->id_usuario?>"><i class="flaticon-edit"></i></a></td>
                            <?php }?>
                            </tr>
                <?php } } }?>
            </table>
        </div>
    </div>
</section>