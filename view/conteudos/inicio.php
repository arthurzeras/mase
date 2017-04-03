<?php
require "classes/Atendentes.class.php";

echo "Veio pro inicio";

$atendentes = new Atendentes();

//FAZER LOGOUT
if(isset($_GET['logout']) && $_GET['logout']==true){
    $atendentes->logout();
    header("Refresh:0");
}

?>

<br>
<a href="?logout=true">Sair</a>
