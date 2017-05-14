<?php require_once "controller/controller-admin.php"?>

<section id="conteudo_adm_index">
    <header class="header" id="header_adm">
        <?=$botaoLogout?>
        <?=$imagemLogo?>
    </header>

    <article id="botoes_adm">
        <div class="botoes">
            <a href="<?=PATH?>admin/atendentes">Atendentes</a>
        </div>
        <div class="botoes">
            <a href="<?=PATH?>admin/tipoatendimento">Tipos de Atendimentos</a>
        </div>
        <div class="botoes">
            <a href="<?=PATH?>admin/guiches">Guichês</a>
        </div>
    </article>
</section>