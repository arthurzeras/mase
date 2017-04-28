<?php
include_once "controller/controller-admin.php";
echo $msg;
?>

<section id="conteudo_adm">
    <header class="header" id="header_adm">
        <a class="voltar_pagina" href="/mase/"><i class="flaticon-back"></i></a>
        <?=$imagemLogo?>
        <div id="botoes_adm_atendente">
            <a data-toggle="tooltip" data-placement="bottom" title="Cadastrar novo atendente" class="add_novo" href="/mase/admin/addatendente"><img src="../assets/img/icon-plus.png"></a>
            <span id="divisor"></span>
            <?=$botaoLogout?>
        </div>
    </header>
    <div id="atendentes">
        <div id="atendentes_header">
            <img src="../assets/img/icon-users.png">
            <h1>Atendentes</h1>
            <span id="linha_adm_atendentes"></span>
        </div>
        <div id="atendentes_conteudo">
            <table>
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th colspan="2" align="center">Ações</th>
                </tr>
                <?php
                if(!isset($_GET['do'])){
                    if($atendente->pegarTudoLinhas() > 0){
                        foreach ($atendente->pegarTudo() as $key => $item) { ?>
                            <tr class="items">
                                <td><?=$item->matricula?></td>
                                <td><?=$item->nome_atendente?></td>
                                <td><?=$item->email_atendente?></td>
                                <?php if($item->nome_atendente !== "admin") {?>
                                    <td><a href="/mase/admin/atendentes&do=update&id=<?=$item->id_atendente?>"><i class="flaticon-edit"></i></a></td>
                                    <td><a onclick="confirmar('atendentes','<?php echo ($item->id_atendente);?>', '<?php echo ($item->nome_atendente);?>');"><i class="flaticon-garbage"></i></a></td>
                                <?php }else{ ?>
                                    <td colspan="2"><a href="/mase/admin/atendentes&do=update&id=<?=$item->id_atendente?>"><i class="flaticon-edit"></i></a></td>
                                <?php }?>
                            </tr>
                        <?php }
                    }else{ ?>
                        <tr>
                            <td colspan="4">Não há atendentes cadastrados.</td>
                        </tr>
                    <?php }
                }else if(isset($_GET['do']) && $_GET['do'] == "update"){
                    $id = $_GET['id'];
                    foreach ($atendente->pegarTudo() as $key => $item) { ?>
                        <tr class="items">

                <?php   if($atendente->pegarId($item->nome_atendente) == $id){
                            $atendenteEditar = $item->nome_atendente;
                            $result = $atendente->pegarLinha($id);
                ?>
                            <form method="post">
                                <td class="editando"><span class="flaticon-edit"></span><input type="text" value="<?=$result->matricula?>" placeholder="Matrícula do Atendente" name="matricula" required></td>
                                <td class="editando"><input type="text" value="<?=$result->nome_atendente?>" placeholder="Nome" name="nome" required></td>
                                <td class="editando"><input type="email" value="<?=$result->email_atendente?>" placeholder="Email" name="email" required></td>
                                <input type="hidden" value="<?=$result->id_atendente?>" name="id">
                                <td class="editando"><button name="alterar_atendente" type="submit"><img src="../assets/img/icon-save.png"></button></td>
                                <td class="editando"><a href="/mase/admin/atendentes"><i class="flaticon-cancel"></i></a></td>
                            </form>
                <?php }else{?>
                            <td class="bloqueado"><?=$item->matricula?></td>
                            <td class="bloqueado"><?=$item->nome_atendente?></td>
                            <td class="bloqueado"><?=$item->email_atendente?></td>
                <?php if($item->nome_atendente !== "admin") {?>
                                <td class="bloqueado"><a href="/mase/admin/atendentes&do=update&id=<?=$item->id_atendente?>"><i class="flaticon-edit"></i></a></td>
                                <td class="bloqueado"><a onclick="confirmar('atendentes','<?php echo ($item->id_atendente);?>', '<?php echo ($item->nome_atendente);?>');"><i class="flaticon-garbage"></i></a></td>
                            <?php }else{ ?>
                                <td class="bloqueado" colspan="2"><a href="/mase/admin/atendentes&do=update&id=<?=$item->id_atendente?>"><i class="flaticon-edit"></i></a></td>
                            <?php }?>
                            </tr>
                <?php } } }?>
            </table>
        </div>
    </div>
</section>