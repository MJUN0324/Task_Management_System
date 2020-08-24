<!doctype html>
<html lang="en">

<head>
    <title>Add Account</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font Awesome 5 CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">

    <?php
        include_once '../../src/autoload.php';
        require_once '../../src/connection/mysql_conn.php';

        session_start();

        if (empty($_SESSION['info']) || $_SESSION['type'] != "admin") {
            echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
            die("Redirecting to login.php");
        }
    ?>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"])) {
                $name = $_POST["name"];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $type = $_POST['type'];

                if($type == "candidate") {
                    $controller = new controller\candidateController();
                    $controller->register($name, $email, $password);
                }
                else if($type == "company") {
                    $controller = new controller\companyController();
                    $controller->register($name, $email, $password);
                }
                else if($type == "admin") {
                    $controller = new controller\adminController();
                    $controller->register($name, $email, $password);
                }
            }
            else if(isset($_POST["xlsxfile"])) {
                require_once "../../vendor/SimpleXLSX.php"; 

                if ($xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name'])) {
                    foreach ($xlsx->rows() as $key=>$elt) {
                        if ($key != 0) {
                            switch (strtolower($elt[1])) {
                                case 'admin':
                                    $controller = new controller\adminController;
                                    $controller->register($elt[0], $elt[2], $elt[3]);
                                    break;
                                    
                                case 'company':
                                    $controller = new controller\companyController;
                                    $controller->register($elt[0], $elt[2], $elt[3]);
                                    break;
        
                                case 'candidate':
                                    $controller = new controller\candidateController;
                                    $controller->register($elt[0], $elt[2], $elt[3]);
                                    break;
                            }
                        }      
                    }
                } 
                else {
                    echo SimpleXLSX::parseError();
                }
            }
        }
    ?>
</head>

<body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Font Awesome 5 JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.1.1/js/all.js" integrity="sha384-BtvRZcyfv4r0x/phJt9Y9HhnN5ur1Z+kZbKVgzVBAlQZX4jvAuImlIz+bG7TS00a" crossorigin="anonymous"></script>

    

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
        <!-- Jumbotron -->
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                </br></br></br>
                <h1 class="display-3">Add new account</h1>
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

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <h3>Add single account</h3>
                        <div class="form-group">
                            <label for="type">Account Type</label>
                            <select name="type" class="form-control" id="type">
                                <option value="candidate">Candidate</option>
                                <option value="company">Company</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="first_name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <label for="password">Password</label>
                        <div class="input-group">       
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="input-group-append" style="padding-top: 0px;">
                                <button class="btn btn-secondary" type="button" onclick="genPassword()"><i class="fa fa-random" aria-hidden="true"></i></button>
                                <button class="btn btn-secondary" type="button" onclick="show()"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            </div>                          
                        </div>
                        <span class="msg"></span>
                        <div class="checker">
                            <small class="invalid" id="characters"> At least 8 characters long.</small><br/>
                            <small class="invalid" id="uppercase"> Contains uppercase letters.</small><br/>
                            <small class="invalid" id="lowercase"> Contains lowercase letters.</small><br/>
                            <small class="invalid" id="numbers"> Contains numbers.</small><br/>
                        </div>
                        <hr />
                        <button type="submit" class="btn btn-primary" id="submit">Add Account</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                    
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST' enctype='multipart/form-data'>
                        <hr />
                        <h3>Add mulitple accounts</h3>
                        <div class="form-group">
                            <label for="UploadCSV">Upload XLSX file</label>
                            <div class="float-right">
                                    <a href="../../assets/csv_temp/addAcc_temp.xlsx" class="button" id="btn-download" download="addAcc_temp"><p><b><i class="fas fa-file-download"></i> Excel Template</b></p></a>
                            </div>
                            <input type="file" class="form-control" id="file" name="file">                           
                        </div>
                        <hr />
                        <input type='submit' class="btn btn-primary" name='xlsxfile' value="Import" accept=".xlsx" />
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

    <!-- Password Checker JS -->
    <script src="../../vendor/passwordCheck.js"></script>

    <script>
        function genPassword() {
            var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
            var password = "";
            for (var x = 0; x < 10; x++) {
                var i = Math.floor(Math.random() * chars.length);
                password += chars.charAt(i);
            }
            $("#password").val(password);
            $("#password").keyup(); // Fire a keyup to trigger the checker
        }

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