<!doctype html>
<html lang="en">

<head>
    <title>HKVEP Online Task</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font Awesome 5 CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"
        integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

    <!-- Caleandar CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link rel="stylesheet" href="../../vendor/calendar/theme2.css"/>

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

    

    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <a href="./">
                        <img src="../../assets/img/HKVEPlogo.png" />
                    </a>                    
                </div>

                <div class="col-5 d-flex justify-content-end align-self-center">
                <?php
                $sql = "SELECT photo FROM candidate WHERE candidateID='".unserialize($_SESSION["info"])->get_id()."'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {                
                ?>
                <a href="Add_face.php">
                    <img src="<?php echo $row["photo"]; 
                    if ($row["photo"] == null)
                        echo "../../assets/noImage.jpg";
                    }}?>" style="height: 50px; width: 50px;" target="popup" 
                    onclick="window.open('Add_face.php','popup','width=600,height=600'); return false;" >
                </a>
                    <div class="dropdown">
                        <button class="btn btn-link text-white" type="button" data-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <?php                        
                                $notStart = 0;

                                $sql_notStarted = "SELECT *
                                        FROM candidate_task
                                        WHERE candidateID = '" . unserialize($_SESSION["info"])->get_id() . "'                          
                                        ";

                                $result_notStarted = mysqli_query($conn, $sql_notStarted);

                                while($record_notStarted = mysqli_fetch_assoc($result_notStarted)) {
                                    if (!isset($record_notStarted['startTime'])){
                                        $notStart++;
                                    }
                                }
                                
                                $marked = 0;
                                        
                                $sql_marked = "SELECT *
                                        FROM result
                                        WHERE candidateID = '" . unserialize($_SESSION["info"])->get_id() . "'                          
                                        ";

                                $result_marked = mysqli_query($conn, $sql_marked);
                            
                                while($record_marked = mysqli_fetch_assoc($result_marked)) {
                                    if ($record_marked['status'] == "marked"){
                                        $marked++;
                                    }
                                }
                            ?>

                            <?php if($notStart > 0) { ?> 
                                <li class="dropdown-item disabled">You have <?= $notStart ?> new task</li>
                            <?php } ?>
                            <?php if($marked > 0) { ?>
                                <li class="dropdown-item disabled">You have <?= $marked ?> task(s) is/are marked</li>
                            <?php } ?>
                            <?php if($marked == 0 && $notStart == 0) { ?>
                                <li class="dropdown-item disabled">no news</li>
                            <?php } ?>
                        
                        </ul>
                    </div>
                </div>

                <div class="col-lg-1 d-flex justify-content-end align-self-center">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle text-white" type="button" data-toggle="dropdown">
                            <?= unserialize($_SESSION["info"])->get_username(); ?>
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="../../src/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <div class="content">
        <?php 
            $controller = new controller\taskController();
            $company_controller = new controller\companyController();
            $taskList = $controller->getTaskByCandidateID(unserialize($_SESSION["info"])->get_id());
        ?>
        <!-- Jumbotron -->
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-3">Task Available</h1>
            </div>
        </div> 

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="p-3 mb-2 bg-secondary text-white"><b>Ongoing Task</b></div>
                    <div class="list-group" id="ongoing">
                        <?php foreach($taskList as $task) { ?>
                            <?php
                                date_default_timezone_set('Asia/Hong_Kong');
                                $now = date("Y-m-d H:i:s");
                            ?>
                            
                            <?php if($now >= $task->get_start()) { ?>
                                <?php if($now < $task->get_end()) {?>
                                    <?php
                                        $status = $controller->getStatus($task->get_task_id(), unserialize($_SESSION["info"])->get_id());
                                        if($status === NULL)
                                            $status = "Not Attempt";
        
                                        switch(strtolower($status)) {
                                            case "unsubmit":
                                                $url = "task_panel.php?id=" . $task->get_task_id(); 
                                                $disabled_status = false;
                                                break;
        
                                            case "submitted":
                                                $url = "task_panel.php?id=" . $task->get_task_id();
                                                $disabled_status = true; 
                                                break;
                
                                            case "marked":
                                                $url = "result.php?id=" . $task->get_task_id() . "&candidate=" . unserialize($_SESSION["info"])->get_id(); 
                                                $disabled_status = false;
                                                break;
                
                                            default:
                                                $url = "task_panel.php?id=" . $task->get_task_id(); 
                                                $disabled_status = false;
                                        }    
                                    ?>
                                    <a href="<?= $url ?>" class="list-group-item list-group-item-action <?= $disabled_status ? "disabled" : "" ?>">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><?= $task->get_task_name() ?></h5>
                                            <small><?= ucfirst($status) ?></small>
                                        </div>
                                        <p class="mb-1"><?= $task->get_description() ?></p>
                                        <p><small>Company: <?= ($company_controller->getCompanyByID($task->get_company_id()))->get_username() ?></small></p>
                                        <p><small><?= $task->get_start() ?> - <?= $task->get_end() ?></small></p>
                                    </a>     
                                <?php } ?>
                            <?php } ?>     
                        <?php } ?> 
                    </div>
                    
                    <br />

                    <div class="p-3 mb-2 bg-secondary text-white"><b>Ended Task</b></div>
                    <div class="list-group" id="ended">
                        <?php foreach($taskList as $task) { ?>
                            <?php
                                date_default_timezone_set('Asia/Hong_Kong');
                                $now = date("Y-m-d H:i:s");
                            ?>
                            
                            <?php if($now >= $task->get_start()) { ?>
                                <?php if($now >= $task->get_end()) {?>
                                    <?php
                                        $status = $controller->getStatus($task->get_task_id(), unserialize($_SESSION["info"])->get_id());
                                        if($status === NULL)
                                            $status = "Not Attempt";
        
                                        switch(strtolower($status)) {
                                            case "unsubmit":
                                                $url = "task_panel.php?id=" . $task->get_task_id(); 
                                                $disabled_status = false;
                                                break;
        
                                            case "submitted":
                                                $url = "task_panel.php?id=" . $task->get_task_id();
                                                $disabled_status = true; 
                                                break;
                
                                            case "marked":
                                                $url = "result.php?id=" . $task->get_task_id() . "&candidate=" . unserialize($_SESSION["info"])->get_id(); 
                                                $disabled_status = false;
                                                break;
                
                                            default:
                                                $url = "task_panel.php?id=" . $task->get_task_id(); 
                                                $disabled_status = false;
                                        }    
                                    ?>
                                    <a href="<?= $url ?>" class="list-group-item list-group-item-action <?= $status !== "marked" ? "disabled" : "" ?>">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><?= $task->get_task_name() ?></h5>
                                            <small><?= ucfirst($status) ?></small>
                                        </div>
                                        <p class="mb-1"><?= $task->get_description() ?></p>
                                        <p><small>Company: <?= ($company_controller->getCompanyByID($task->get_company_id()))->get_username() ?></small></p>
                                        <p><small><?= $task->get_start() ?> - <?= $task->get_end() ?></small></p>
                                    </a>     
                                <?php } ?>
                            <?php } ?>     
                        <?php } ?> 
                    </div>
                    
                    <br />

                    <div class="p-3 mb-2 bg-secondary text-white"><b>Task to be completed</b></div>
                    <div class="list-group" id="notstart">
                        <?php foreach($taskList as $task) { ?>
                            <?php
                                date_default_timezone_set('Asia/Hong_Kong');
                                $now = date("Y-m-d H:i:s");
                            ?>
                            
                            <?php if($now < $task->get_start()) { ?>
                                <?php
                                    $status = $controller->getStatus($task->get_task_id(), unserialize($_SESSION["info"])->get_id());
                                    if($status === NULL)
                                        $status = "Not Attempt";
    
                                    switch(strtolower($status)) {
                                        case "unsubmit":
                                            $url = "task_panel.php?id=" . $task->get_task_id(); 
                                            $disabled_status = false;
                                            break;
    
                                        case "submitted":
                                            $url = "task_panel.php?id=" . $task->get_task_id();
                                            $disabled_status = true; 
                                            break;
                
                                        case "marked":
                                            $url = "result.php?id=" . $task->get_task_id() . "&candidate=" . unserialize($_SESSION["info"])->get_id(); 
                                            $disabled_status = false;
                                            break;
                
                                        default:
                                            $url = "task_panel.php?id=" . $task->get_task_id(); 
                                            $disabled_status = false;
                                    }    
                                ?>
                                <a href="<?= $url ?>" class="list-group-item list-group-item-action disabled">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><?= $task->get_task_name() ?></h5>
                                        <small><?= ucfirst($status) ?></small>
                                    </div>
                                    <p class="mb-1"><?= $task->get_description() ?></p>
                                    <p><small>Company: <?= ($company_controller->getCompanyByID($task->get_company_id()))->get_username() ?></small></p>
                                    <p><small><?= $task->get_start() ?> - <?= $task->get_end() ?></small></p>
                                </a>     
                            <?php } ?>     
                        <?php } ?> 
                    </div>
                    
                </div>
                <div class="col-md-4 col-sm-12 d-flex justify-content-center">
                    <div id="caleandar">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Caleandar JS -->
    <script type="text/javascript" src="../../vendor/calendar/caleandar.js"></script>
    <script>
        var events = [
            <?php 
                foreach($taskList as $task) {
                    $startDate =  getDate(strtotime($task->get_start()));
                    $endDate =  getDate(strtotime($task->get_end()));
            ?>
                   {'Date': new Date(<?= $startDate['year'] ?>, <?= $startDate['mon'] ?>, <?= $startDate['mday'] ?>), 'Title': 'Start Task: <?= $task->get_task_name() ?>'},
                   {'Date': new Date(<?= $endDate['year'] ?>, <?= $endDate['mon'] ?>, <?= $endDate['mday'] ?>), 'Title': 'End Task: <?= $task->get_task_name() ?>'},
            <?php } ?>
        ];
        var settings = {};
        var element = document.getElementById('caleandar');
        caleandar(element, events, settings);
    </script>

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