<!doctype html>
<html lang="en">

<head>

<style>
    .content-table{
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    min-width: 100%;
    border-radius: 5px 5px 0 0;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}


.content-table thead tr {
    background-color: brown;
    color: #FFF;
    text-align: left;
    font-weight: bold;
}

.content-table th,
.content-table td {
    padding: 12px 15px;
}

.content-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.content-table tbody tr:nth-of-type(even){
    background-color: #f3f3f3;
}

.content-table tbody tr:last-of-type{
    border-bottom: 2px solid rgb(228, 46, 46);
}
</style>
    <title>Add Candidate</title>
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

        if (empty($_SESSION['info']) || $_SESSION['type'] != "company") {
            echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
            die("Redirecting to login.php");
        }
    ?>

    <?php
        if (isset($_POST["taskID"]) && isset($_POST["candidateID"])) {    
            $taskID = $_POST["taskID"];
            $candidateID = $_POST["candidateID"];
            
            $controller = new controller\taskController();
            $controller->addCandidateToTask($taskID, $candidateID);
        }
        else if (isset($_POST["xlsxfile"])) {  
            require_once "../../vendor/SimpleXLSX.php"; 

            $taskID = $_POST["taskID"];
            
            if ($xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name'])) {
                foreach ($xlsx->rows() as $key=>$elt) {
                    if ($key != 0) {
                        $controller = new controller\candidateController();
                        $candidate = $controller->getCandidateByEmail($elt[1]);
                        if($candidate !== NULL) {
                            $candidateID = $candidate->get_id();
                            $controller = new controller\taskController();
                            $controller->addCandidateToTask($taskID, $candidateID);
                        }
                        
                    }      
                }
            }
            else {
                echo SimpleXLSX::parseError();
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
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle text-white" type="button" data-toggle="dropdown">
                            <?= unserialize($_SESSION["info"])->get_username(); ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="../../src/logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="content">
        <?php 
            $controller = new controller\taskController();
            $candidateList = $controller->getCandidateListNotInTask($_GET['id']);
        ?>

        <!-- Jumbotron -->
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-3">Add Candidate</h1>
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

                    <?php
                        $sql = 'SELECT taskName FROM task WHERE taskID = "'.$_GET['id'].'"';
                        $rs = mysqli_query($conn, $sql);
                        if ($rc = mysqli_fetch_assoc($rs)){
                    ?>
                        <h2 class="display-3" style="font-size: 1.5rem;">Please Select Candidates to be Assigned to <b><?php echo $rc['taskName'] ?></b></h2>
                    <?php }; ?>
                    <!-- Show Candidate Table -->
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>Candidate Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>          
                            <?php foreach($candidateList as $candidate){ ?>
                                <tr>
                                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                        <input type="hidden" id="taskID" name="taskID" value="<?= $_GET['id'] ?>">
                                        <input type="hidden" name="candidateID" id="candidateID" value="<?= $candidate->get_id() ?>">
                                        <td><?= $candidate->get_username() ?></td>
                                        <td><?= $candidate->get_email() ?></td>
                                        <td><button type="submit" class="btn btn-primary">Add</button></td>
                                    </form> 
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method='POST' enctype='multipart/form-data'>
                        <input type="hidden" id="taskID" name="taskID" value="<?= $_GET['id'] ?>">  
                        <hr />
                        <h3>Add mulitple candidate</h3>
                        <div class="form-group">
                            <label for="UploadCSV">Upload CSV file</label>
                            <div class="float-right">
                                    <a href="../../assets/csv_temp/assign_temp.xlsx" class="button" id="btn-download" download="assign_temp"><p><b><i class="fas fa-file-download"></i> CSV Template</b></p></a>
                            </div>
                            <input type="file" class="form-control" id="file" name="file">                           
                        </div>
                        <hr />
                        <input type='submit' class="btn btn-primary" name='xlsxfile' value="Import" />
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

</body>

</html>