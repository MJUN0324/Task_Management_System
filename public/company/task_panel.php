<!doctype html>
<html lang="en">

<head>
    <title>Task Panel</title>
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
                $candidateList = $task->get_candidate_list();
            }
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="card">                      
                        <h5 class="card-header"><?= $task->get_task_name() ?>  </h5>
                        <div class="card-body">
                            <p class="card-text">Duration: <?= $task->get_start() ?> - <?= $task->get_end() ?></p>
                            <?php if($task->get_attempt_time() === NULL || substr($task->get_attempt_time(), 0, 8) === "00:00:00") { ?>
                                <p class="card-text">Attempt Time: Unlimited</p>
                            <?php } else { ?> 
                                <p class="card-text">Attempt Time: <?= substr($task->get_attempt_time(), 0, 8) ?></p>
                            <?php } ?>
                            <p class="card-text">Attempt Limit: <?= $task->get_attempt_limit() ?></p>
                            <p class="card-text">Description: <?= $task->get_description() ?></p>
                            <p class="card-text">File:</p>
                            <?php foreach($task->get_file_list() as $file) { ?>
                                <a href="<?= $file->get_file_location() ?>" target="_blank"><?= $file->get_file_name() ?></a><br/>
                            <?php } ?>
                            <br />
                            <p class="card-text"><?= ($task->is_disabled()) ? '<span class="text-danger">Deleted</span>' : '' ?></p>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-action">
                            <a href="edit_task.php?id=<?= $id ?>">
                                <div class="d-flex w-100 justify-content-center">
                                    <p><b><i class="fas fa-pen fa-fw"></i>Edit Task</b></p>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <?php if($task->is_disabled()) { ?>
                                <a href="../../src/recover_task.php?id=<?= $id ?>">
                                    <div class="d-flex w-100 justify-content-center">
                                        <p><b><i class="fas fa-recycle"></i> Recover Task</b></p>
                                    </div>
                                </a>
                            <?php } else { ?>
                                <a href="../../src/delete_task.php?id=<?= $id ?>">
                                    <div class="d-flex w-100 justify-content-center">
                                        <p><b><i class="fas fa-trash fa-fw"></i>Delete Task</b></p>
                                    </div>
                                </a>
                            <?php } ?>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <a href="statistic.php?id=<?= $id ?>">
                                <div class="d-flex w-100 justify-content-center">
                                    <p><b><i class="fas fa-chart-bar fa-fw"></i>Statistic</b></p>
                                </div>
                            </a>
                            <li class="list-group-item list-group-item-action">
                            <a href="./face-recognition/index.html" target="_blank">
                                <div class="d-flex w-100 justify-content-center">
                                    <p><b><i class="fas fa-eye"></i>Face Recognition</b></p>
                                </div>
                            </a>
                        </li>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8 col-sm-12">                                      
                    <ul class="list-group">
                        <?php
                            date_default_timezone_set('Asia/Hong_Kong');
                            $now = date("Y-m-d H:i:s");
                            if($now >= $task->get_start()) {
                                if($now >= $task->get_end()) {
                                    $disabled = true;
                                }
                                else {
                                    $disabled = false;
                                }
                            }
                        ?>
                              
                        <li class="list-group-item list-group-item-action <?= $disabled ? "disabled" : "" ?>">
                            <a href="add_candidate.php?id=<?= $id ?>">
                                <div class="d-flex w-100 justify-content-center">
                                    <p><b><i class="fas fa-plus fa-fw"></i>Add Candidate</b></p>
                                </div>
                            </a>
                        </li> 
                        <?php 

                        ?>
                        <?php foreach($candidateList as $candidate) {?>    
                            <?php 
                                $status = $controller->getStatus($task->get_task_id(), $candidate->get_id());
                                if($status === NULL)
                                    $status = "Not Attempt";    
                            ?>
                            <li class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <h5 class="mb-1"><?= $candidate->get_username() ?></h5>
                                        <p><small>Status: <?= ucfirst($status) ?></small></p>
                                    </div>
                                    
                                    <div>
                                        <?php if($status == "marked" || $status == "submit") { ?>
                                            <a href="task.php?id=<?= $_GET['id'] ?>&candidate=<?= $candidate->get_id() ?>"><p><i class="far fa-eye fa-fw"></i><small>View Answer</small></p></a>                           
                                        <?php } ?>
                                        <?php if($status == "submit") { ?>
                                            <a href="../../src/unsubmit.php?id=<?= $_GET['id'] ?>&candidate=<?= $candidate->get_id() ?>"><p><i class="fas fa-trash fa-fw"></i><small>Unsubmit</small></p></a>
                                        <?php } ?>
                                        <?php if($status != "marked") { ?>
                                            <a href="../../src/remove_candidate.php?id=<?= $_GET['id'] ?>&candidate=<?= $candidate->get_id() ?>"><p><i class="fas fa-user-slash fa-fw"></i><small>Remove</small></p></a>
                                        <?php } ?>
                                    </div>
                                    
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
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