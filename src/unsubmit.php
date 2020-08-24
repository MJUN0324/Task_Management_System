<?php  
    include_once 'autoload.php';
    require_once 'connection/mysql_conn.php';

    if(isset($_GET["id"]) && isset($_GET["candidate"])) {
        $controller = new controller\taskController();       
        $controller->unsubmit($_GET["id"], $_GET["candidate"]);
    }  
 ?>