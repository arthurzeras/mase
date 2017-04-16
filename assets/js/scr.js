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

//SUBIR A JANELA POPUP DE ALTERAR DADOS DO ATENDENTE
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

//POPUP DE CONFIRMAÇÃO DE EXCLUSÃO DE ATENDENTE
function confirmar(id, nome) {
    if (confirm("Deletar " + nome + "?")) {
        location.href = "/mase/admin&do=del&id=" + id;
    }
}