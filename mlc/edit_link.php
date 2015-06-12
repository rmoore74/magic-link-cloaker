<?php
	session_start();
	include 'includes/config.php';
	
	if (!isset($_SESSION['login_user'])) {
		header("Location: index.php");
	}

	$old = $cloak_directory . "" . $_POST['oldurl'];
	$new = $cloak_directory . "" . $_POST['newurl'];

	$rename = rename($old, $new);

	if ($rename == true) {
		$conn = new mysqli($server, $user, $pass, $dbname);
		
		$query = $conn->prepare("UPDATE CloakedLinks SET shorturl = ? WHERE shorturl = ?");
		$query->bind_param('ss', $_POST['newurl'], $_POST['oldurl']);
		$query->execute();
		
		$conn->close();

		header("Location: dashboard.php?success=2#manage");
		die();
	} else {
		echo "$old <br /> $new <br />";
		echo "Could not rename :(";
	}
?>
