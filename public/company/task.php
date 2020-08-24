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

        if(empty($_SESSION['info']) || $_SESSION['type'] != "company") {
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


    <script>
        // Init 
        $(document).ready(function() {

            if($(this).is(":checked")){
                    $('#pass').show();
                    $('#grade').hide();
                }
                else{
                    $('#pass').hide();
                    $('#grade').show();
                }

            $('#gradeSetting').click(function(){
                if($(this).is(":checked")){
                    $('#grade').hide();
                    $('#pass').show();
                }
                else{
                    $('#grade').show();
                    $('#pass').hide();
                }
            });
		});

    </script>
    
    <?php
        // calculate the different percentage  
            function similarity($str1, $str2) {

                similar_text($str1, $str2, $percent);

                return round($percent /100 , 4);
        }
    ?>

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
            $controller = new controller\candidateController();
            $candidate = $controller->getCandidateByID($_GET['candidate']);
        
            $controller = new controller\taskController();
            $result = $controller->getResult($_GET['id'], $_GET['candidate']);
            $task = $controller->getTaskByID($_GET['id']);
        ?>

        <!-- PHP to get and set setting by cookie -->
        <?php
        //new
            require_once '../../src/gradeSetting.php';
        ?>

        <?php
        //mark answer
        if (isset($_POST["marks"])) {
            $marks = $_POST["marks"];
            if(!isset($_POST["gradeSetting"])){
                if($marks < $_POST["gradeD"]) {
                    $grade = "F";
                }
                else if($marks >= $_POST["gradeD"] && $marks < $_POST["gradeC"]) {
                    $grade = "D";
                }
                else if($marks >= $_POST["gradeC"] && $marks < $_POST["gradeB"]) {
                    $grade = "C";
                }
                else if($marks >= $_POST["gradeB"] && $marks < $_POST["gradeA"]) {
                    $grade = "B";
                }
                else if($marks >= $_POST["gradeA"]) {
                    $grade = "A";
                }
            }else{
                if($marks >= $_POST["gradeP"]){
                    $grade = "P";
                }else{
                    $grade = "F";
                }
            }
            $comment = $_POST["comment"];

            $controller->markResult($task->get_task_id(), $candidate->get_id(), $marks, $grade, $comment);
        }
        //
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
                            <?php if($result->get_marks() !== NULL && $result->get_grade() !== NULL && $result->get_comment() !== NULL) { ?>
                                <p class="card-text">Mark: <?= $result->get_marks() ?></p>
                                <p class="card-text">Grade: <?= $result->get_grade() ?></p>
                                <p class="card-text">Comment: <?= $result->get_comment() ?></p>
                            <?php } else { ?>
                                <button class="btn btn-secondary" data-toggle="modal" data-target="#MarkModal">Mark Answer</button>
                            <?php } ?>
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
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Grammer Mistake</h5>
                        </div>
                        <div class="card-body">
                            <p id="mistake_count"></p>
                            <table id="table_grammer" class="table table-striped table-bordered">
                                <tr>
                                    <th>Word</th>
                                    <th>Mistake Setence</th>
                                    <th>Mistake</th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Plagiarism check</h5>
                        </div>
                        <div class="card-body">
                            <p>The similar percentage for others candidate</p>
                            <table id="table1" class="table table-striped table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Percentage</th>
                                    <th>Detail</th>
                                </tr>
                                <?php
                                    $answer = $result->get_answer();

                                    $sql = "SELECT *
                                    FROM result
                                    WHERE taskID ='" . $_GET['id'] . "' AND
                                          (status = 'submit' OR status = 'marked')
                                    ";
                                    $rs_result = mysqli_query($conn, $sql);                     

                                    while($rc_result = mysqli_fetch_assoc($rs_result)){
                                        if($rc_result['candidateID'] != $_GET['candidate']){
                                        $sql = "SELECT *
                                                FROM candidate
                                                WHERE candidateID ='" . $rc_result['candidateID'] . "'
                                            ";
                                        $rs_cand = mysqli_query($conn, $sql);
                                        $rc_cand = mysqli_fetch_assoc($rs_cand);
                                ?>
                                    <tr>
                                    <td><?=$rc_cand['name']?></td>
                                    <td><?=$rc_cand['email']?></td>
                                    <td><?php echo (similarity($answer,$rc_result['answer']) * 100) . '%';?></td>
                                    <td class="button" onclick="window.location='plagiarism.php?id=<?= $rc_result['taskID']?>&cand1=<?= $_GET['candidate']?>&cand2=<?= $rc_result['candidateID']?>';" style="cursor:pointer">More info</td>
                                </tr>
                                
                                <?php
                                    }
                                }
                                ?>
                            </table>
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
            var text = $(".answer").text()

			var settings = {
				"async": true,
				"crossDomain": true,
				"url": "https://grammarbot.p.rapidapi.com/check",
				"method": "POST",
				"headers": {
					"x-rapidapi-host": "grammarbot.p.rapidapi.com",
					"x-rapidapi-key": "3a2796f185msh9112c2659b8cfcbp1d4bb5jsn41797dc39674",
					"content-type": "application/x-www-form-urlencoded"
				},
				"data": {
					"language": "en-US",
					"text": text
				}
			}
			$.ajax(settings).done(function (response) {
                console.log(response);
                $("#mistake_count").text("Total grammer mistake: " + response.matches.length)
				var mistake = response.matches;
				for(var i in mistake){
                    $("#table_grammer tr:last").after('<tr><td>' + mistake[i].offset + '</td><td>' + mistake[i].sentence + '</td><td>' + mistake[i].message + '</td></tr>')
				}
			});

    </script>

    <!-- Modal -->
    <div class="modal fade" id="MarkModal" tabindex="-1" role="dialog" aria-labelledby="MarkModel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Mark Submission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="modal-body">
                    
                        <div class="form-group">
                            <label for="taskName">Marks</label>
                            <input type="text" class="form-control" name="marks" id="marks">
                        </div>

                        <div class="form-group">
                            <label for="gradeSetting">Grade setting</label></br>
                            <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="gradeSetting" id="gradeSetting" <?echo $_COOKIE['gradeSetting'];?> > No grading (just pass or fail)</input></div>
                            <div id="grade">
                                A: <input type="number" class="w-25" name="gradeA" id="gradeA" value="<?= $_COOKIE['gradeA'] ?>" min="0"> or above</br>
                                B: <input type="number" class="w-25" name="gradeB" id="gradeB" value="<?= $_COOKIE['gradeB'] ?>" min="0"> or above</br>
                                C: <input type="number" class="w-25" name="gradeC" id="gradeC" value="<?= $_COOKIE['gradeC'] ?>" min="0"> or above</br>
                                D: <input type="number" class="w-25" name="gradeD" id="gradeD" value="<?= $_COOKIE['gradeD'] ?>" min="0"> or above</br>
                                F: others
                            </div>
                            <div id="pass">
                                Pass score: <input type="number" class="form-control w-25" name="gradeP" id="gradeP" value="<?= $_COOKIE['gradeP']?>" min="0">
                            </div>
                        </div>    

                        <div class="form-group">
                            <label for="taskName">Comment</label>
                            <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
                        </div>    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
</body>

</html>