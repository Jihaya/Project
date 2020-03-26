<?php
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['id'] == "")
	{
		echo "Please Login!";
		exit();
    }
    
	include('config.php');
	
	$sql = "UPDATE users SET fname = '".trim($_POST['fname'])."', lname = '".trim($_POST['lname'])."'
	, address = '".trim($_POST['address'])."', tel = '".trim($_POST['tel'])."' WHERE id = '".$_SESSION["id"]."' ";
	$result = mysqli_query($link, $sql) or die ("Error in query: $sql " . mysqli_error());
	
    echo "Save Completed!<br>";
    echo "<script type='text/javascript'>";
	echo "window.location = 'admin.php'; ";
	echo "</script>";
	mysqli_close($link);
?>