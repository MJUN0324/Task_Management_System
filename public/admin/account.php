<!doctype html>
<html lang="en">
<head>
    <title>Account</title>
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
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle text-white" type="button" data-toggle="dropdown">
                            <?= unserialize($_SESSION["info"])->get_username(); ?>
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
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
                <h1 class="display-3">Account Manage</h1>
            </div>
        </div>

        <div class="container-fluid">
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

            <div class="row panel with-nav-tabs panel-warning">
                <div class="col-lg-6 offset-md-3 panel-heading">
                    <ul class="row nav">
                        <li class="col-4 text-center">
                            <a class="btn btn-primary active" href="#candidate" data-toggle="tab">Candidate</a>
                        </li>
                        <li class="col-4 text-center">
                            <a class="btn btn-primary" href="#company" data-toggle="tab">Company</a>
                        </li>
                        <li class="col-4 text-center">
                            <a class="btn btn-primary" href="#admin" data-toggle="tab">Admin</a>
                        </li>
                    </ul>
                 
                    <div class="panel-body">
                        <div class="tab-content">

                            <!-- Candidate Panel -->
                            <div class="tab-pane fade in show active" id="candidate">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action">
                                        <a href="add_account.php">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <p><b><i class="fas fa-plus fa-fw"></i>Add Account</b></p>
                                            </div>
                                        </a>
                                    </li>

                                    <?php
                                        $candidate_controller = new controller\candidateController();
                                        $candidateList = $candidate_controller->getCandidateList();                
                                    ?>

                                    <?php foreach($candidateList as $candidate) { ?>
                                        <li class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <div>
                                                    <h5 class="mb-1"><?= $candidate->get_username() ?></h5>
                                                    <p class="mb-1"><?= $candidate->get_email() ?></p>
                                                </div>
                                                <div>
                                                    <a href="edit_account.php?id=<?= $candidate->get_id() ?>">
                                                        <i class="fas fa-pen fa-fw"></i><small>Modify</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php }; ?>
                                </ul>
                            </div>

                            <!-- Company Panel -->
                            <div class="tab-pane fade in" id="company">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action">
                                        <a href="add_account.php">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <p><b><i class="fas fa-plus fa-fw"></i>Add Account</b></p>
                                            </div>
                                        </a>
                                    </li>
                                    
                                    <?php
                                        $company_controller = new controller\companyController();
                                        $companyList = $company_controller->getCompanyList();                
                                    ?>

                                    <?php foreach($companyList as $company) { ?>
                                        <li class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <div>
                                                    <h5 class="mb-1"><?= $company->get_username() ?></h5>
                                                    <p class="mb-1"><?= $company->get_email() ?></p>
                                                </div>
                                                <div>      
                                                    <a href="edit_account.php?id=<?= $company->get_id() ?>">
                                                        <i class="fas fa-pen fa-fw"></i><small>Modify</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php }; ?>
                                </ul>
                            </div> 

                            <!-- Admin Panel -->
                            <div class="tab-pane fade in" id="admin">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action">
                                        <a href="add_account.php">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <p><b><i class="fas fa-plus fa-fw"></i>Add Account</b></p>
                                            </div>
                                        </a>
                                    </li>

                                    <?php
                                        $admin_controller = new controller\adminController();
                                        $adminList = $admin_controller->getAdminList();                
                                    ?>

                                    <?php foreach($adminList as $admin) { ?>
                                        <li class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <div>
                                                    <h5 class="mb-1"><?= $admin->get_username() ?></h5>
                                                    <p class="mb-1"><?= $admin->get_email() ?></p>
                                                </div>
                                                <div>
                                                    <a href="edit_account.php?id=<?= $admin->get_id() ?>">
                                                        <i class="fas fa-pen fa-fw"></i><small>Modify</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php }; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container-fluid">
            <small>
                ©Copyright <?= (date("Y") == "2020" ? "" : "2020-") . date("Y") ?> The Hong Kong Vocational English Programme, All Rights Reserved
            </small>
        </div>

    </footer>

</body>

</html>