<?php
    include_once 'autoload.php';

    if(!isset($_COOKIE["gradeA"])){
        setcookie("gradeA", 70, time()+3600*24*30, '../');
        setcookie("gradeB", 60, time()+3600*24*30, '../');
        setcookie("gradeC", 50, time()+3600*24*30, '../');
        setcookie("gradeD", 40, time()+3600*24*30, '../');
        setcookie("gradeP", 40, time()+3600*24*30, '../');
        setcookie("gradeSetting", "", time()+3600*24*30, '../');
        header("Refresh:0");
    }//update setting
    else if(isset($_POST["submit"])){
        setcookie("gradeA", $_POST["gradeA"], time()+3600*24*30, '../');
        setcookie("gradeB", $_POST["gradeB"], time()+3600*24*30, '../');
        setcookie("gradeC", $_POST["gradeC"], time()+3600*24*30, '../');
        setcookie("gradeD", $_POST["gradeD"], time()+3600*24*30, '../');
        setcookie("gradeP", $_POST["gradeP"], time()+3600*24*30, '../');
        if(isset($_POST["gradeSetting"])){
            setcookie("gradeSetting", "checked", time()+3600*24*30, '../');
        }
        else{
            setcookie("gradeSetting", "", time()+3600*24*30, '../');
        }
    }
?>