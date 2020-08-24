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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <?php
        require_once "../php/candidate.php";

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
                        <img src="../img/HKVEPlogo.png" />
                    </a>                    
                </div>

                <div class="col-5 d-flex justify-content-end align-self-center">
                    <div class="dropdown">
                        <button class="btn btn-link text-white" type="button" data-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                        
                        
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
        <!-- Jumbotron -->
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-3">Widget Setting</h1>
            </div>
        </div> 

        <div class="container-fluid">

            <div class="row" id="widget">
                <div class="col-md-4 col-sm-12 offset-md-2 border" >
                    <p>Avaliable Widget</p>
                    <ul class="list-group" id="avaliable">
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="calendar"><span>Calendar</span><span class="add" ><i class="fas fa-plus"></i></span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="search"><span>Search</span><span class="add"><i class="fas fa-plus"></i></span></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-12 border">
                    <p>Selected Widget</p>
                    <ul class="list-group" id="selected">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $(".add").click(function(){
                var dataId = $(this).parent().attr("id");
                $("#selected").append('<li class="list-group-item d-flex justify-content-between align-items-center" id="' + dataId + '"><span>' + dataId.charAt(0).toUpperCase() + dataId.substr(1).toLowerCase() + '</span><span class="delete"><i class="fas fa-times"></i></span></li>')
            });
            $(document).on("click", ".delete" , function() {
                $(this).parent().remove();
            });
        });  
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