<!doctype html>
<html lang="en">

<head>
    <title>Task</title>
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

    <!-- CK Editor CSS -->
    <link rel="stylesheet" href="../../vendor/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">

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
	<!-- <script src="../../vendor/ckeditor/samples/js/sample.js"></script> -->

    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <a href="./">
                        <img src="../../assets/img/HKVEPlogo.png" />
                    </a>                        
                </div>
                <div class="col-lg-6 d-flex justify-content-end align-self-center">
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
            if(isset($_GET['id'])) {
                $id = $_GET['id'];

                $controller = new controller\taskController();
                $task = $controller->getTaskByID($id);

                $taskName = $task->get_task_name();
                $attemptTime = $task->get_attempt_time();
                $question = $task->get_question();
                $description = $task->get_description();
                $fileList = $task->get_file_list();
                $answer = $controller->getAnswer($id, unserialize($_SESSION["info"])->get_id());

                $tempArr = $controller->getCandidateStartAndEndTime($id, unserialize($_SESSION["info"])->get_id());
                $startTime = $tempArr[0];
                $endTime = $tempArr[1];
            }
        ?>

        <!-- Jumbotron -->
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-3">Tasks</h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <div class="card">
                        <div class="card-header">
                            <h5><?= $taskName ?></h5>
                        </div>
                        <div class="card-body">
                            <p>Task Duration: <span id="time_duration"><?= substr($attemptTime, 0, 8) ?></span></p>
                            <p>Time Remaining: <span id="remain_time"></span></p>
                            <p><small>Last Autosave Time: <span id="autoSave_time"></span></small></p>
                        </div>
                    </div>
                    <p class="pt-4">
                        <button class="btn btn-secondary" onclick="submit()">Submit</button>
                    </p>
                </div>
                <div class="col-10">
                    <div>
                        <p><b>Question</b></p>
                        <?= $question ?> <br/><br/>
                        <?php foreach($fileList as $file) { ?>
                            <p>       
                                <i class="far fa-file-pdf"></i> <a href='<?= $file->get_file_location() ?>' target="_blank"><?= $file->get_file_name() ?></a>    
                            </p>
                        <?php } ?>
                    </div>
                    <div class="adjoined-bottom">
                        <div class="grid-container">
                            <div class="grid-width-100">
                                <div id="answer">
                                    <?= $answer ?>
                                </div>
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
        var editor = CKEDITOR.replace('answer', { height: 1000 });

        editor.on("instanceReady", function(){
			this.document.on("keyup", function() { 
				var taskID = "<?= $id ?>";
				var candidateID = "<?= unserialize($_SESSION["info"])->get_id(); ?>";
				var answer = editor.getData();

                saveAnswer(taskID, candidateID, answer);
            });
        });

        /* CountDown */
        var deadline = new Date("<?= $endTime ?>").getTime();
        function countdown() {
            var now = new Date().getTime();
            var remainTime = deadline - now;
            var hours = Math.floor((remainTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((remainTime % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((remainTime % (1000 * 60)) / 1000);
            $("#remain_time").html(
                                    (hours >= 10 ? "" : "0") + hours + ":" + 
                                    (minutes >= 10 ? "" : "0") + minutes + ":" + 
                                    (seconds >= 10 ? "" : "0") + seconds
                                );
            if (remainTime < 0) {
                $("#remain_time").html("Times up!");
                submit();
            }
        }

        <?php if($attemptTime === NULL || substr($attemptTime, 0, 8) === "00:00:00") { ?>
            $("#time_duration").html("Unlimited");
            $("#remain_time").parent().hide();           
        <?php } else { ?>
            setInterval(function() {   
                countdown();   
            }, 1000);  
        <?php } ?>

            

        /* Autosave */
        function saveAnswer(taskID, candidateID, answer) { 
            $.ajax({  
                url:"../../src/save_answer.php",  
                method:"POST",  
                data:{taskID: taskID, candidateID: candidateID, answer: answer},  
                dataType:"text",  
                success:function(data) {   
                    var today = new Date();
                    var now = (today.getHours() >= 10 ? "" : "0") + today.getHours() + ":" + 
                              (today.getMinutes() >= 10 ? "" : "0") + today.getMinutes() + ":" + 
                              (today.getSeconds() >= 10 ? "" : "0") + today.getSeconds();
                    $('#autoSave_time').text(now);
                }  
            });  
        }

        /* Submit Function */
        function submit() {
            var taskID = "<?= $id ?>";
			var candidateID = "<?= unserialize($_SESSION["info"])->get_id(); ?>";
			var answer = editor.getData();

            $.ajax({  
                url:"../../src/submit_task.php",  
                method:"POST",  
                data:{taskID: taskID, candidateID: candidateID, answer: answer},  
                dataType:"text",  
                success:function(data) {   
                    window.location.href = 'index.php';
                }  
            }); 
        }
    </script>
    
</body>

</html>