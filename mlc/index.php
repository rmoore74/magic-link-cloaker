<?php
	session_start();
	
	if (isset($_SESSION['login_user'])) {
		header("Location: dashboard.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - Magic Link Cloaker v1.0</title>
	
	<link rel="stylesheet" href="styles/mlc-styles.css">
	<link rel="stylesheet" href="styles/parsley.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
	<body style="background: #eee;">
		<div id="mlc-contain">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>Dashboard Login <small>Magic Link Cloaker V1.0</small></h1></div>
				<div class="panel-body">
					<?php
						if(isset($_GET['login'])) {
							echo '<div class="alert alert-danger" role="alert"><strong>Error</strong> Incorrect username and/or password. Please try again.</div>';
						}
					?>
					<form class="form-horizontal" action="login.php" method="post" data-parsley-validate>
						<div class="form-group">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">
								<input name="user" type="text" class="form-control" required/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input name="pass" type="password" class="form-control" required/>
							</div>
						</div>
						<input type="submit" class="btn btn-info pull-right" value="Login" />
					</form>
				</div>
			</div>
			<footer style="font-size: 12">
				&copy; 2015 <a href="http://rogermoore.io/">rogermoore.io</a>. All rights reserved.
			</footer>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<script src="js/parsley.js"></script>
		<script type="text/javascript">
		$(document).ready(function () {
		  $('.next').on('click', function () {
		    var current = $(this).data('currentBlock'),
		      next = $(this).data('nextBlock');

		    if (next > current)
		      if (false === $('#mlc-setup').parsley().validate('block' + current))
			return;

		    $('.block' + current)
		      .removeClass('show')
		      .addClass('hidden');

		    $('.block' + next)
		      .removeClass('hidden')
		      .addClass('show');

		  });
		});
		</script>
	</body>
</html>
