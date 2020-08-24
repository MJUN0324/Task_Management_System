<?php
        include_once '../../src/autoload.php';
        require_once '../../src/connection/mysql_conn.php';
 
        session_start();

        if(empty($_SESSION['info']) || $_SESSION['type'] != "candidate") {
            echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
            die("Redirecting to login.php");
        }
    ?>
<?php
    // if upload button is pressed
    if (isset($_POST['submit'])) {
        makeDirectory();
        $file = $_FILES['image'];

        $fileName    = $_FILES['image']['name'];
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileSize    = $_FILES['image']['size'];
        $fileError   = $_FILES['image']['error'];
        $fileType    = $_FILES['image']['type'];

        // File Extension
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        // Allowed file type
        $allowed = array('jpg');

        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 1000000){
                    $fileNameNew = "1.".$fileActualExt;
                    $fileDestination = "../company/face-recognition/labeled_images/".unserialize($_SESSION["info"])->get_id()."_".unserialize($_SESSION["info"])->get_username()."/".$fileNameNew;          
                    move_uploaded_file($fileTmpName, $fileDestination);
                    // Update Database
                    $sql = "UPDATE Candidate SET photo='".$fileDestination."' WHERE candidateID='".unserialize($_SESSION["info"])->get_id()."'";
                    mysqli_query($conn, $sql);
                    mysqli_close($conn);
                    $_SESSION["Msg"] = "Upload Success";
                    header("Location: Add_face.php?uploadsuccess");
                }else{
                    echo "Your file is too big";
                    $_SESSION["Error Msg"] = "ERROR: Your file is too big!";
                    header("Location: Add_face.php");
                }
            }else {
                echo "There was an error in your file";
                $_SESSION["Error Msg"] = "ERROR: There was an error in your file!";
                header("Location: Add_face.php");
            }
        }else{
            echo "You cannot upload files of this type!";
            $_SESSION["Error Msg"] = "ERROR: Cannot upload files of this type!";
            header("Location: Add_face.php");
        }

    }

    function makeDirectory(){
        $directoryName = "../company/face-recognition/labeled_images/".unserialize($_SESSION["info"])->get_id()."_".unserialize($_SESSION["info"])->get_username();

        if(!is_dir($directoryName)){
            // Directory does not exist so create it
            mkdir($directoryName,0777,true);
        }
    }
?>
