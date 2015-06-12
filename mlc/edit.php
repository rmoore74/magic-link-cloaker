<?php
	session_start();
	include 'includes/config.php';
	
	if (!isset($_SESSION['login_user'])) {
		header("Location: index.php");
	}

	// get title 
	$conn = new mysqli($server, $user, $pass, $dbname);

	$query = $conn->prepare("SELECT shorturl FROM CloakedLinks WHERE ID = ?");
	$query->bind_param("s", $_GET['id']);
	$query->execute();
	$query->bind_result($title);
	$query->fetch();

	$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Edit Link - Magic Link Cloaker v1.0</title>
	
	<link rel="stylesheet" href="styles/mlc-styles.css">
	<link rel="stylesheet" href="styles/parsley.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
	<body style="background: #eee;">
		<div id="mlc-contain">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1><?php echo $title; ?> <small>Edit Link</small></h1>
					<div style="text-align: right;">
						<a href="dashboard.php">Dashboard</a> | <a href="logout.php">Logout</a>
					</div>
				</div>
				<div class="panel-body">
					<h4>Edit <?php echo $title; ?></h4>
					<p>Here you can change the name of your cloaked link. To do this just enter the appropriate details in the boxes below and hit update!</p>
					<form action="edit_link.php" method="POST">
						<div class="form-group">
							<label>Current URL</label>
							<input class="form-control" type="text" value="<?php echo $title; ?>" disabled>
						</div>
						<div class="form-group">
							<label>New URL</label>
							<input class="form-control" name="newurl" type="text" placeholder="<?php echo $title; ?>">
						</div>
						<input type="hidden" name="oldurl" value="<?php echo $title; ?>" />
						<input type="submit" class="btn btn-info pull-right" value="Update" />
					</form>
				</div>
			</div>
			<footer style="font-size: 12">
				&copy; 2015 <a href="http://rogermoore.io/">rogermoore.io</a>. All rights reserved.
			</footer>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<script src="js/parsley.js">
	</body>
</html>

