<!DOCTYPE html>
<html lang="en">
	<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<meta charset="utf-8">
		<title>HKVEP Online Task</title>
		<?php 
			session_start();

			if(empty($_SESSION['info'])) {
				echo "<script type='text/javascript'>window.location.href = 'public/login.php';</script>";
				die("Redirecting to login.php");
			}
			else {
				if($_SESSION['type'] == "candidate") {
					echo "<script type='text/javascript'>window.location.href = 'public/candidate/index.php';</script>";
					die("Redirecting to candidate index");
				}
				else if($_SESSION['type'] == "company") {
					echo "<script type='text/javascript'>window.location.href = 'public/company/index.php';</script>";
					die("Redirecting to company index");
				}
				else if($_SESSION['type'] == "admin") {
					echo "<script type='text/javascript'>window.location.href = 'public/admin/index.php';</script>";
					die("Redirecting to admin index");
				}
			}		
		?>		
	</head>
</html>
