<!doctype html>
<html lang="en">

<head>
    <title>HKVEP Online Task - Statistic</title>
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

    <!-- Chart JS -->
    <script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    
    <!-- DataTable -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- PHP to get data -->
    <?php 
        //new
        //if(isset($_GET['id'])){
        //    $taskID = $_GET['id'];
        //    $controller = new controller\taskController();
        //    $resultList = $controller->getResultList($taskID);
        //}
        //
        $sql = "SELECT *
                FROM result
                WHERE taskID ='" . $_GET['id'] . "' AND
                      status = 'marked'
                ";
        $rs_result = mysqli_query($conn, $sql);
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
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle text-white" type="button" data-toggle="dropdown">
                            <?= unserialize($_SESSION["info"])->get_username(); ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="../../src/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
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
                <h1 class="display-3">Statistics</h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="col-lg-10 col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <canvas id="pieChart" width="500" height="500"></canvas>
                    </div>
                </div>
                <div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="s_table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mark</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //new
                            $ga = 0;
                            $gb = 0;
                            $gc = 0;
                            $gd = 0;
                            $gf = 0;
                            $gp = 0;
                            
                            // $controller2 = new controller\candidateController();
                            // foreach($resultList as $result){
                                // $candidate = $controller2->getCandidateByID($result->get_candidate_id());

                                 while($rc_result = mysqli_fetch_assoc($rs_result)){
                                     $sql = "SELECT *
                                             FROM candidate
                                             WHERE candidateID ='" . $rc_result['candidateID'] . "'
                                         ";
                                     $rs_cand = mysqli_query($conn, $sql);
                                     $rc_cand = mysqli_fetch_assoc($rs_cand);
                                ?>
                                
                                <tr onclick="window.location='task.php?id=<?= $rc_result['taskID']?>&candidate=<?= $rc_result['candidateID']?>';" style="cursor:pointer">
                                    <td><?=$rc_cand['name']?></td>
                                    <td><?=$rc_cand['email']?></td>
                                    <td><?=$rc_result['marks']?></td>
                                    <td><?=$rc_result['grade']?></td>
                                </tr>
                            <?php
                            if($rc_result['grade']==="A"){
                                $ga++;
                            }else if($rc_result['grade']==="B"){
                                $gb++;
                            }else if($rc_result['grade']==="C"){
                                $gc++;
                            }else if($rc_result['grade']==="D"){
                                $gd++;
                            }else if($rc_result['grade']==="F"){
                                $gf++;
                            }else if($rc_result['grade']==="P"){
                                $gp++;
                            }
                            //
                        }?>
                        </tbody>
                        </table>
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
        var ctxP = document.getElementById("pieChart").getContext('2d');
        var myPieChart = new Chart(ctxP, {
        plugins: [ChartDataLabels],
        type: 'pie',
        data: {
            <?php  if($gp == 0){?>
            labels: ["Grade A", "Grade B", "Grade C", "Grade D", "Grade F"],
            datasets: [{
                data: [<?=$ga?>,<?=$gb?>,<?=$gc?>,<?=$gd?>, <?=$gf?>],
                backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
                <?php }else{ ?>
                    labels: ["Pass", "Fail"],
                datasets: [{
                    data: [<?=$gp?>,<?=$gf?>],
                    backgroundColor: ["#F7464A", "#4D5360"],
                    hoverBackgroundColor: ["#FF5A5E", "#616774"]
            <?php } ?>
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'right',
                labels: {
                    padding: 20,
                    boxWidth: 10
                }
            },
            plugins: {
                datalabels: {
                    display: function(context) {
                        return context.dataset.data[context.dataIndex] !== 0;
                    },
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                        return percentage;
                    },
                    color: 'white',
                    labels: {
                        title: {
                            font: {
                                size: '16'
                            }
                        }
                    }
                }
            }
        }
        });

        $(document).ready(function () {
            $('#s_table').DataTable();
        });

    </script>

</body>

</html>