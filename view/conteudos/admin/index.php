<?php require_once "controller/controller-admin.php"?>

<section id="conteudo_adm_index">
    <header class="header" id="header_adm">
        <?=$botaoLogout?>
        <?=$imagemLogo?>
    </header>

    <article id="botoes_adm">
        <div class="botoes">
            <a href="<?=PATH?>admin/usuarios">Usuários</a>
        </div>
        <div class="botoes">
            <a href="<?=PATH?>admin/tipoatendimento">Tipos de Atendimentos</a>
        </div>
        <div class="botoes">
            <a href="<?=PATH?>admin/perfis">Perfis</a>
        </div>
        <div class="botoes">
            <a href="<?=PATH?>admin/guiches">Guichês</a>
        </div>
    </article>
    <?php if(isset($_GET['update'])){
    foreach($atendente->pegarTudo() as $key => $value){
        if($value->id_atendente == 1){
    if($_GET['update'] == "matricula"){ ?>
        <div id="editar_matricula">
            <h2>Editar matricula</h2>
            <form>
                <label for="matricula">Matrícula</label>
                <input type="number" name="matricula" id="matricula" value="<?=$value->matricula?>"/>
                <button type="submit">Salvar</button>
            </form>
        </div>
    <?php }else if($_GET['update'] == "senha"){ ?>
        <article id="editar_adm">
            
        </article>
    <?php } } } }?>
</section>