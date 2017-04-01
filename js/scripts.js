//atualizar as últimas senhas pedidas
window.setInterval(carrega, 1000);
function carrega() {
    $('#conteudo').load("ultimas-senhas-include.php");
}