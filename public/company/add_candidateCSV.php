<?php 
    require_once "../php/taskController.php";

    if (isset($_POST["submitCSV"])) {
        $controller = new taskController;
        $controller->addCandidateInCSV($_POST["taskID"], $_FILES['file']['name']);
    }

    header("Location:add_candidate.php"); 
?>