<?php
require "classes/Acesso.class.php";

echo "Veio pro atendente";

$atendentes = new Acesso();

//FAZER LOGOUT
if(isset($_GET['logout']) && $_GET['logout']==true){
    $atendentes->logout();
    header("Location: /mase/");
}

?>

<br>
<a href="?logout=true">Sair</a>
