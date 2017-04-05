//ATUALIZA O MÉTODO DE TRAZER A PÁGINA QUE CARREGA AS ÚTIMAS SENHAS CHAMADAS
window.setInterval(carrega, 1000);
function carrega() {
    $('#conteudo').load("ultimas-senhas-include.php");
}

//SUBIR A JANELA POPUP DE ALTERAR DADOS DO ATENDENTE
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

if (getUrlVars()['do'].length > 0){
    document.getElementById("janela_alterar").className = "janela_alterar";
}