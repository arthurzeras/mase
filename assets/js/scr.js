//ATUALIZA O METODO DE TRAZER A SENHA PEDIDA MAIS RECENTEMENTE
window.setInterval(ultimasSenhas, 1000);
function ultimasSenhas() {
    $('#conteudo').load("view/conteudos/senhas-pedidas-include.php");
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