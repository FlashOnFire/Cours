<?php 
    require_once 'fonctions-2048.php';

    //afffiche_sept_variables();

    if (isset($_GET['action-joueur']))
        write_log($_GET['action-joueur']);

?>