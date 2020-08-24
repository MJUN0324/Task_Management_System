<!doctype html>
<html lang="en">
<head>
    <title>Edit Account</title>
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

        if(empty($_SESSION['info']) || $_SESSION['type'] != "admin") {
            echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
            die("Redirecting to login.php");
        }
    ?>

    <?php   
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST["type"];
            $id = $_POST["account_id"];
            $name = $_POST["name"];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $disabled = boolval($_POST['disabled']);

            if($type == "Candidate") {
                $controller = new controller\candidateController();
                $controller->edit($id, $name, $email, $password, $disabled);
            }
            else if($type == "Company") {
                $controller = new controller\companyController();
                $controller->edit($id, $name, $email, $password, $disabled);
            }
            else if($type == "Admin") {
                $controller = new controller\adminController();
                $controller->edit($id, $name, $email, $password, $disabled);
            }
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

                if(substr($id, 0, 2) === "CA") {
                    $controller = new controller\candidateController();
                    $data = $controller->getCandidateByID($id);
                }
                if(substr($id, 0, 2) === "CO") {
                    $controller = new controller\companyController();
                    $data = $controller->getCompanyByID($id);
                }
                if(substr($id, 0, 1) === "A") {
                    $controller = new controller\adminController();
                    $data = $controller->getAdminByID($id);
                }
            }
        ?>
        
       <!-- Jumbotron -->
       <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-3">Edit Account</h1>
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
                        <input type="hidden" class="form-control" id="type" name="type" value="<?= $data->get_type() ?>">
                        <input type="hidden" class="form-control" id="account_id" name="account_id" value="<?= $data->get_id() ?>">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?= $data->get_username() ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $data->get_email() ?>" readonly>
                        </div>

                        <label for="password">Password</label>
                        <div class="input-group">       
                            <input type="password" class="form-control" id="password" name="password" value="<?= $data->get_password() ?>" required>
                            <div class="input-group-append" style="padding-top: 0px;">
                                <button class="btn btn-secondary" type="button" onclick="show()"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            </div>
                        </div>

                         <label for="status">Disabled</label>
                        <div class="form-row"> 
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="disabled" id="disabled" value="1" <?= ($data->is_disabled()) ? "checked" : "" ?>>
                                <label class="form-check-label" for="able">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="disabled" id="disabled" value="0" <?= !($data->is_disabled()) ? "checked" : "" ?>>
                                <label class="form-check-label" for="disable">No</label>
                            </div>
                        </div>
                        <hr />
                        <button type="submit" class="btn btn-primary">Confirm</button>
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
        function show() {
            if($("#password").attr("type") === "password") {
                $("#password").prop("type", "text");
                //$("#password").find("i").removeClass("fa-eye").addClass("fa-eye-slash");
            }
            else {
                $("#password").prop("type", "password");
                //$("#password").find("i").removeClass("fa-eye-slash").addClass("fa-eye");
            }
        }
    </script>

</body>

</html>