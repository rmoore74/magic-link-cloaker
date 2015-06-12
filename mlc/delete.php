<?php
	session_start();
	include 'includes/config.php';
	
	if (!isset($_SESSION['login_user'])) {
		header("Location: index.php");
	}

	$id = $_GET['id'];

	$conn = new mysqli($server, $user, $pass, $dbname);
	
	$query = $conn->prepare("SELECT shorturl FROM CloakedLinks");
	$query->execute();
	$query->bind_result($shortDir);
	$query->fetch();
	
	$conn->close();
	
	$dir = $cloak_directory . "/" . $shortDir;
	$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
	$files = new RecursiveIteratorIterator($it,
	             RecursiveIteratorIterator::CHILD_FIRST);
	foreach($files as $file) {
	    if ($file->isDir()){
	        rmdir($file->getRealPath());
	    } else {
	        unlink($file->getRealPath());
	    }
	}
	rmdir($dir);

	$conn = new mysqli($server, $user, $pass, $dbname);
	
	$query = $conn->prepare("DELETE FROM CloakedLinks WHERE ID = ?");
	$query->bind_param("i", $id);
	$query->execute();

	$query = $conn->prepare("DELETE FROM Statistics WHERE linkID = ?");
	$query->bind_param("i", $id);
	$query->execute();
	
	$conn->close();

	header("Location: dashboard.php?success=1#manage");
	die();
?>
