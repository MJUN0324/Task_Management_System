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
    <!-- PHP to get data -->
    

    <div class="content">
        <!-- Jumbotron -->
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-3">Upload your face</h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-sm-12 offset-md-3">
                    <!-- Stream video via webcam -->
    <div class="video-wrap">
        <video id="video" playsinline autoplay></video>
    </div>

    <!-- Trigger canvas web API -->
    <div class="controller">
        <a href="#" class="button" id="btn-download" download="<?= unserialize($_SESSION["info"])->get_id()."_".unserialize($_SESSION["info"])->get_username();?>.jpg"><button id="snap" class="btn btn-primary">Capture</button></a>
    </div>

    <!-- Webcam video snapshot -->
    <canvas id="canvas" width="200" height="200"></canvas>

    <script>

        'use strict';

        const video = document.getElementById('video');
        const canvas= document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const errorMsgElement = document.getElementById('spanErrorMsg');

        const constraints = {
            audio: false,
            video:{
                width: 500, height: 300
            }
        };

        async function init(){
            try{
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                handleSuccess(stream);
            }catch(e){
                errorMsgElement.innerHTML = `navigator.getUserMedia.error:${e.toString()}`;
            }
        }

        // Success
        function handleSuccess(stream){
            window.stream = stream;
            video.srcObject = stream;
        }
        // Load init
        init();
        // Draw image
        var button = document.getElementById('btn-download');
        var context = canvas.getContext('2d');
        snap.addEventListener("click", function(){
            context.drawImage(video, 0, 0, 250, 200);
            var dataURL = canvas.toDataURL("image/jpg");
            button.href = dataURL;
        });
        var myVar = setInterval(function () {
            context.drawImage(video, 0, 0, 250, 200);
            var dataURL = canvas.toDataURL("image/jpg");
            button.href = dataURL;
        }, 9000);

    </script>
    <hr>
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
                    <div style="color: red;">Please Upload in file type jpg</div>
                    <script type="text/javascript">
                        function readURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    $('#blah')
                                        .attr('src', e.target.result)
                                        .width(200)
                                        .height(200);
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                    </script>
                    <div class="list-group">
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            <img id="blah" src="#" alt="your image" />
                            <div>
                                <input type="file" name="image" onchange="readURL(this);">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Upload Image</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12"></div>
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