<?php
    $dados_atendente = $atendente->pegarLinha($atendente->pegarId($_SESSION['atendente']));

    if(isset($_GET['senha'])){
        $alterar_senha = '<p>Alterar senha |<a href="/mase/&editar=editar"><i class="flaticon-cancel"></i></a></p>';
    }else{
        $alterar_senha = '<a id="botao_alterarSenha" href="/mase/&editar=editar&senha=senha"><i class="flaticon-padlock"></i> Alterar senha</a>';
    }
?>

<div id="editar_atendente">
    <div id="janela_editar">
        <a href="/mase/"><img id="fechar_editar" src="assets/img/icon-close.png"></a>
        <h2>Seus dados</h2>
        <span id="linha_atendimento"></span>
        <form method="post" id="formulario_editar">
            <div data-toggle="tooltip" title="Campo não editável">
                <input id="matricula" class="campos_input input_attr" type="text" name="matricula" value="<?=$dados_atendente->matricula?>">
                <label id="" class="placeholder matricula active" for="matricula">Matrícula</label>
            </div>

            <div data-toggle="tooltip" title="Campo não editável">
                <input id="nome" class="campos_input input_attr" name="nome" type="text" value="<?=$dados_atendente->nome_atendente?>">
                <label id="" class="placeholder nome active" for="nome">Nome</label>
            </div>

            <input id="email" class="campos_input input_attr" type="email" name="email" value="<?=$dados_atendente->email_atendente?>" required>
            <label id="placeholder_email" class="placeholder email active" for="email">Email</label>
            <a href="javascript:void(0)" class="limpar limpar_email">×</a>

            <?php echo $alterar_senha;
                if(isset($_GET['senha'])){?>
                <div id="alterar_senha">
                    <input id="senhaAtual" class="campos_input input_attr" type="password" name="senha_atual" required>
                    <label id="placeholder_senhaAtual" class="placeholder senhaAtual" for="senhaAtual">Senha atual</label>
                    <a href="javascript:void(0)" class="limpar limpar_senhaAtual">×</a>

                    <input id="novaSenha" class="campos_input input_attr" type="password" name="nova_senha" required>
                    <label id="placeholder_novaSenha" class="placeholder novaSenha" for="novaSenha">Nova senha</label>
                    <a href="javascript:void(0)" class="limpar limpar_novaSenha">×</a>

                    <input id="repeteSenha" class="campos_input input_attr" type="password" name="repete_senha" required>
                    <label id="placeholder_repeteSenha" class="placeholder repeteSenha" for="repeteSenha">Repetir Senha</label>
                    <a href="javascript:void(0)" class="limpar limpar_repeteSenha">×</a>
                </div>
            <?php }?>
            <input type="hidden" name="id_atendente" value="<?=$dados_atendente->id_atendente?>">
            <button class="campos_input botao" name="editar" type="submit">Salvar</button>
        </form>
    </div>
</div>