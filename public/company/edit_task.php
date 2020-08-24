<!doctype html>
<html lang="en">

<head>
    <title>Edit Task</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font Awesome 5 CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"
        integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">

    <?php
        include_once '../../src/autoload.php';
        require_once '../../src/connection/mysql_conn.php';

        session_start();

        if(empty($_SESSION['info']) || $_SESSION['type'] != "company") {
            echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
            die("Redirecting to login.php");
        }
    ?>

    <?php 
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskID = $_GET["id"];
            $taskName = $_POST["taskName"];
            $companyID = unserialize($_SESSION["info"])->get_id();
            $start = $_POST["start"];
            $end = $_POST["end"];
            $timeLimit = $_POST["timeLimit"];
            $attemptTime = $_POST["attemptTime"];
            $attemptLimit = $_POST["attemptLimit"];
            $description = $_POST["description"];
            $question = $_POST["question"];
            
            $controller = new controller\taskController();
            $controller->edit($taskID, $taskName, $companyID, $start, $end, $attemptTime, $attemptLimit, $description, $question);
        }
    ?>
</head>

<body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

    <!-- Font Awesome 5 JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.1.1/js/all.js"
        integrity="sha384-BtvRZcyfv4r0x/phJt9Y9HhnN5ur1Z+kZbKVgzVBAlQZX4jvAuImlIz+bG7TS00a"
        crossorigin="anonymous"></script>        

    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <a href="./">
                        <img src="../../assets/img/HKVEPlogo.png" />
                    </a>                       
                </div>
                <div class="col-lg-6 d-flex justify-content-end align-self-center">
                    <div class="dropdown dropdown-menu-right">
                        <button class="btn btn-link dropdown-toggle text-white" type="button" data-toggle="dropdown">
                            <?= unserialize($_SESSION["info"])->get_username(); ?>
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu ">
                            <!--
                            <a href="../php/logout.php"><i class="fas fa-user"></i>Profile</a>
                            <div class="dropdown-divider"></div>
                            -->
                            <a href="../../src/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="content">
        <?php 
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $controller = new controller\taskController();
                $task = $controller->getTaskByID($id);
            }
        ?>

        <!-- Jumbotron -->
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-3">Edit task</h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-12 offset-md-3">

                <?php 
                    if (isset($_SESSION['Msg'])) { 
                        echo '<div class="alert alert-success" role="alert">' . $_SESSION["Msg"] . '</div>';
                        unset($_SESSION["Msg"]);
                    }
                ?>
     
                <?php 
                    if (isset($_SESSION['Error Msg'])) { 
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION["Error Msg"] . '</div>';
                        unset($_SESSION["Error Msg"]);
                    }
                ?>

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="form-group">
                            <label for="taskName">Task Name</label>
                            <input type="text" class="form-control" name="taskName" id="taskName" value="<?= $task->get_task_name() ?>">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="start">Start Time</label>
                                <input type="datetime-local" class="form-control" name="start" id="start" value="<?= date( 'Y-m-d\TH:i', strtotime($task->get_start())) ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="end">End Time</label>
                                <input type="datetime-local" class="form-control" name="end" id="end" value="<?= date('Y-m-d\TH:i', strtotime($task->get_end()))?>">
                            </div>                          
                        </div>
                        <div class="form-row">
                            
                            <div class="form-group col-md-6">
                                <label for="attemptTime">Time Limit</label>
                                <div class="input-group">
                                    <div class="input-group-prepend" style="padding: 0px">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="timeLimit" <?= ($task->get_attempt_time() != null) ? "checked" : "" ?> readonly>
                                        </div>
                                    </div>
                                    <input type="time" class="form-control" name="attemptTime" id="attemptTime" value="<?= date("H:i", strtotime($task->get_attempt_time())) ?>">
                                </div>   
                            </div>
                            <div class="form-group col-md-6">
                                <label for="attemptLimit">Attempt Limit</label>
                                <div class="input-group">
                                    <div class="input-group-prepend" style="padding: 0px">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="attemptLimit" <?= ($task->get_attempt_limit() != null) ? "checked" : "" ?> disabled>
                                        </div>
                                    </div>
                                    <input type="number" class="form-control" name="attemptLimit" id="attemptLimit" value="<?= $task->get_attempt_limit() ?>" readonly>
                                </div>   
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea rows="4" class="form-control" name="question" id="question"><?= $task->get_question() ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="file">Task File (Can upload mulitple PDF file)</label>
                            <ul class="list-group">
                                <?php foreach($task->get_file_list() as $file) { ?>
                                    <li class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100">
                                            <p><?= $file->get_file_name() ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea rows="4" class="form-control" name="description" id="description"><?= $task->get_description() ?></textarea>
                        </div>

                        <hr />
                            
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <footer>
        <div class="container-fluid">
            <small>
                ©Copyright
                <script>
                    var year = 2020;
                    document.write(year + (new Date().getFullYear() > year && " - " + new Date().getFullYear()));
                </script>
                The Hong Kong Vocational English Programme, All Rights Reserved
            </small>
        </div>

    </footer>

    <script>
        $(document).on("change", "input[name='timeLimit']", function() {         
            if(this.checked) {
                $("#attemptTime").prop('readonly', false);
            }
            else {
                $("#attemptTime").prop('readonly', true);
            }          
        });


    </script>

</body>

</html>