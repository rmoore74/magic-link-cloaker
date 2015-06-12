<?php
	session_start();
	
	include 'includes/config.php';

	$loginuser = $_POST['user'];
	$loginpass = $_POST['pass'];
	
	$conn = new mysqli($server, $user, $pass, $dbname);
	
	$sql = "SELECT pass FROM Admin WHERE user = ?";
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
	$login_query = $conn->prepare("SELECT pass FROM Admin WHERE user = ?");
	$login_query->bind_param("s", $loginuser);
	$login_query->execute();
	
	$login_query->bind_result($adminpass);
	
	$login_query->fetch();
	
	if(password_verify($loginpass, $adminpass)) {
		$_SESSION['login_user'] = $loginuser;
		header("Location: dashboard.php");
		die();
	} else {
		header("Location: index.php?login=0");
		die();
	}
	
	$conn->close();
?>
