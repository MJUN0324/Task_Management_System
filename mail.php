<?php 
    $to_email = 'taihoyin19991999@gmail.com';
    $subject = 'Your HKVEP Online Test Account is created';
    $message = 'This mail is sent using the PHP mail function\nYour account number is:....\n\tPassword is :....';
    $headers = 'From: hkvep.noreply@gmail.com';
    $success = mail($to_email,$subject,$message,$headers);
    if($success) {
        echo "ok";
    }
    else {
        print_r(error_get_last());
    }
?>