<?php  
    include_once 'autoload.php';
    require_once 'connection/mysql_conn.php';

    if(isset($_POST["taskID"]) && isset($_POST["candidateID"]) && isset($_POST["answer"])) {
        $controller = new controller\taskController();       
        $controller->submit($_POST["taskID"], $_POST["candidateID"], $_POST["answer"]);
    }  
 ?>