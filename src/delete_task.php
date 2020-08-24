<?php  
    include_once 'autoload.php';
    require_once 'connection/mysql_conn.php';

    if(isset($_GET["id"])) {
        $controller = new controller\taskController();       
        $controller->delete($_GET["id"]);
    }  
 ?>