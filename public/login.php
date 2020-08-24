<!doctype html>
<html lang="en">
    <?php 
        include_once '../src/autoload.php';
        require_once '../src/connection/mysql_conn.php';
    ?>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $controller = new controller\loginController();
            $controller->loginCheck($email, $password);
        }
    ?>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

        <title>HKVEP Online Task - Sign in</title>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Font Awesome 5 CSS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" 
            integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

        <!-- Login Form CSS -->
        <link rel="stylesheet" href="../assets/css/loginform.css">

    </head>

    <body class="text-center">
        <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <img src="../assets/img/HKVEPlogo.png" class="mb-5"/>
            <h1 class="h3 mb-3 font-weight-normal">Sign in</h1>

            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
            
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
            
            <div class="text-danger mb-3">
                <?php 
                    if(isset($_SESSION["errorMsg"])){
                        echo $_SESSION["errorMsg"];
                        unset($_SESSION["errorMsg"]);
                    } 
                ?>
            </div>

            <!-- <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div> -->
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">
                ©<?= (date("Y") == "2020" ? "" : "2020-") . date("Y") ?>
            </p>
        </form>
    </body>
</html>
