function check() {
    var matricula = document.getElementById("matricula").value;
    var nome = document.getElementById("nome").value;
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;
    var dataString = 'matricula=' +matricula+ '&nome=' +nome+ '&email=' +email+ '&senha=' +senha;

    $.ajax({
        type: "post",
        data: dataString,
        url: "../controller/controller-admin.php",
        cache: false,
        success: function (html) {
            $("#msg").html(html);
        }
    });

    return false;
}