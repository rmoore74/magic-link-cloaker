<html>
<head>
	<title>Installation - Magic Link Cloaker v1.0</title>
	
	<link rel="stylesheet" href="styles/mlc-styles.css">
	<link rel="stylesheet" href="styles/parsley.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
	<body style="background: #eee;">
		<div id="mlc-contain">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>Installation <small>Magic Link Cloaker V1.0</small></h1></div>
				<div class="panel-body">
					<?php 
						//if (isset($_GET['destroy']) {
							if ($_GET['destroy'] == "true") {
								$install = "install.php";
								$setup = "setup.php";
								if (unlink($install)) {
									if(unlink($setup)) {
										echo '<div class="alert alert-success" role="alert"><p><strong>Success!</strong> Everything wen\'t well! I hope you enjoy Magic Link Cloaker! :-)</p><p>Click here to <a href="index.php">access your dashboard</a></p></div>';
									} else {
										echo '<div class="alert alert-danger" role="alert"><strong>Oops!</strong> For some reason, it has been impossible to self-destruct.</div>';
									}
								}
							}
						//}
					?>
					<h3>Thank you for choosing Magic Link Cloaker</h3><p>You will have your magic link cloaker installed within minutes, it's really simple! Just follow the steps below and you'll be set up in no time.</p>
					<p>One last thing that we need to do before you go off and log in to your brand new dashboard, is to delete the installation files for security purposes. So, if you'd kindly do the honours, please press the self-destruct button below. (Don't worry, only the installation and setup files will self-destruct!)<p>
					<a href="self_delete.php?destroy=true" class="btn btn-danger pull-right">Destroy Files</a>
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
