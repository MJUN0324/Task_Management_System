<?php
    include_once 'autoload.php';
    use controller;

    $controller = new controller\loginController();

    $controller->logout();
?>