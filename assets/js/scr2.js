$(document).ready(function (){
    //ATUALIZA O METODO DE TRAZER A SENHA PEDIDA MAIS RECENTEMENTE
    window.setInterval(ultimasSenhas, 1000);
    function ultimasSenhas() {
        $('#ultimas_conteudo').load("view/conteudos/senhas-pedidas-include.php");
    }

    //ATUALIZA O METODO DE TRAZER A SENHA CHAMADA MAIS RECENTEMENTE
    window.setInterval(senhaChamada, 2000);
    function senhaChamada() {
        $('#senha_chamada').load("view/conteudos/senhas-chamadas-include.php");
    }

    //POPUP DE CONFIRMAÇÃO DE EXCLUSÃO DE ATENDENTE
    function confirmar(pagina, id, nome) {
        switch (pagina){
            case "tipo_atendimento":
                if (confirm("Deletar "+ nome +"?")){
                    location.href = "/mase/admin/tipoAtendimento&pagina="+pagina+"&do=del&id=" + id;
                }
                break;
            case "atendentes":
                if (confirm("Deletar "+ nome +"?")){
                    location.href = "/mase/admin/atendentes&pagina="+pagina+"&do=del&id=" + id;
                }
                break;
        }
    }

    //SOMENTE NUMEROS NO INPUT
    $("#matricula").keyup(function (){
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });

    //SUBIR O PLACEHOLDER DO INPUT
    $('.input_login').on('blur', function (){
        var nome_input = $(this).attr('id');
        if(!$(this).val()){
            $("#placeholder_"+nome_input).removeClass("active");
        }else {
            $("#placeholder_"+nome_input).addClass("active");
        }
    });

    //LIMPAR INPUT
    $('.limpar').on('click', function (){
        var classe = $(this).attr('class');
        var nomeTipo = classe.split("_")[1];
        $("#"+nomeTipo).val('');
        $("#placeholder_"+nomeTipo).removeClass("active");
    });

    //TOOLTIP
    $('[data-toggle="tooltip"]').tooltip();
});
