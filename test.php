<?php 

    require_once 'php/candidateController.php';

    $controller = new candidateController();

    //$controller->register("Test Candidate", "test@candidate.com", "12345678");

    //$candidate[] = $controller->getCandidateList('CA0001');
    //var_dump($candidate)

    $controller->edit("CA0002", "Test Candidate", "test@candidate.com", "1234567999");
?>