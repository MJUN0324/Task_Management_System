<!doctype html>
<html lang="en">

<head>
    <title>Submission</title>
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
 
         if(empty($_SESSION['info']) || $_SESSION['type'] != "candidate") {
             echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
             die("Redirecting to login.php");
         }
        
    ?>
</head>

<body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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

    <!-- CK Editor JS -->
    <script src="../../vendor/ckeditor/ckeditor.js"></script>

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
                            <a href="../php/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="content"> 

        
        <?php
            $controller = new controller\taskController();
            $result = $controller->getResult($_GET['id'], $_GET['candidate']);
            $task = $controller->getTaskByID($_GET['id']);

            $controller = new controller\candidateController();
            $candidate = $controller->getCandidateByID($_GET['candidate']);
        ?>

        <!-- Jumbotron -->
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-3">Submission</h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-sm-12 offset-md-2">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Info</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Task: <?= $task->get_task_name() ?></p>
                            <p class="card-text">Submit By: <?= $candidate->get_username() ?></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Result</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Mark: <?= $result->get_marks() ?></p>
                            <p class="card-text">Grade: <?= $result->get_grade() ?></p>
                            <p class="card-text">Comment: <?= $result->get_comment() ?></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Answer</h5>
                        </div>
                        <div class="card-body">
                            <div class="answer"><?= $result->get_answer() ?></div>
                        </div>
                    </div>
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

    
</body>

</html>