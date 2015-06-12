<?php
	session_start();
	include 'includes/config.php';
	
	if (!isset($_SESSION['login_user'])) {
		header("Location: index.php");
	}

	$conn = new mysqli($server, $user, $pass, $dbname);

	$lg_user = $_SESSION['login_user'];
	
	$query = $conn->prepare("SELECT directory FROM Admin WHERE user = ?");
	$query->bind_param("s", $lg_user);
	$query->execute();
	$query->bind_result($cloak_dir);
	$query->fetch();
	
	$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Dashboard - Magic Link Cloaker v1.0</title>
	
	<link rel="stylesheet" href="styles/mlc-styles.css">
	<link rel="stylesheet" href="styles/parsley.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
	<body style="background: #eee;">
		<div id="mlc-contain">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1>Dashboard <small>Magic Link Cloaker V1.0</small></h1>
					<div style="text-align: right;">
						<a href="#add">Add a Link</a> | <a href="#manage">Manage Links</a> | <a href="#settings">Settings</a> | <a href="logout.php">Logout</a>
					</div>
				</div>
				<div class="panel-body">
					<h4>Dashboard Panel <small>Welcome back <?php echo $_SESSION['login_user']; ?>.</small></h4>
					<p>This is your Magic Link Cloaker personal dashboard. From here you are able to view all the links you've cloaked, view the statistics of these links, and add new links.</p>
					<hr />
					<h4 id="add">Add New Link</h4>
					<p>Cloaking an unsightly link, for example an affiliate link, couldn't be easier. In the form below type the directory name that you want, so that you can give this link to your visitors, and then put the actual messy URL in the input box below it. Once you've done that, click 'Cloak Link'.</p>
					<?php 
						if(isset($_GET['err'])) {
							if ($_GET['err'] == "0") {
								echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Oops!</strong> You have already used this directory!</div>';
							}
						}						
					?>
					<p>
						<form action="add_link.php" method="post">
							<div class="form-group">
								<label>Cloaked Link</label>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">http://<?php echo $_SERVER['HTTP_HOST'] . "/". $cloak_dir; ?></span>
									<input type="text" class="form-control" placeholder="cloaked_directory" aria-describedby="basic-addon1" name="cloaked">
								</div>
							</div>
							<div class="form-group">
								<label>Original Link</label>
								<input type="text" class="form-control" placeholder="http://example.com/id=3285ur822" name="link" /> 
							</div>
							<input type="hidden" name="link_dir" value="<?php echo $cloak_dir; ?>" />
							<div class="form-group" style="text-align: right;">
								<input type="submit" class="btn btn-info" value="Add Link" />
							</div>
						</form>
					</p>
					<hr />
					<h4 id="manage">Manage Existing Links</h4>
					<p>Below is a list of all the links that you have cloaked at the moment. Here you can delete, edit, and view the statistics for each link.</p>
					<?php
						if(isset($_GET['success'])) {
							if ($_GET['success'] == "0") {
								echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> You have cloaked your link.</div>';
							}
							if ($_GET['success'] == "1") {
								echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> You have removed your link.</div>';
							}
							if ($_GET['success'] == "2") {
								echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> You have renamed your link.</div>';
							}
						}	
					?>
					<table class="table table-hover">
						<thead>
							<th></th>
							<th>Cloak Directory</th>
							<th>Original URL</th>
							<th><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
							<th><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
							<th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</thead>
						<tbody>
<?php
$conn = new mysqli($server, $user, $pass, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM CloakedLinks";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
?>
<tr>
	<td><input type="checkbox"></td>
	<td><?php echo $row["shorturl"]; ?></td>
	<td><?php echo $row["longlink"]; ?></td>
	<td><a href="statistics.php?id=<?php echo $row['ID']; ?>"><span style="color: blue;" class="glyphicon glyphicon-stats" aria-hidden="true"></span></a></td>
	<td><a href="edit.php?id=<?php echo $row['ID']; ?>"><span style="color: yellow;" class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
	<td><a href="delete.php?id=<?php echo $row['ID']; ?>"><span style="color: red;" class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
</tr>
<?php
    }
} else {
    echo "<tr><td></td><td>No links here. </td></tr>";
}
$conn->close();
?>
						</tbody>
					</table>
					<hr />
					<h4 id="settings">Settings</h4>
					<p>General software options. Use this section to perform actions such as uninstall software, change admin password, change cloak directory etc.</p>
					<div role="tab-panel">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#pass" aria-controls="pass" role="tab" data-toggle="tab">Change Pass</a></li>
							<li role="presentation"><a href="#chdir" aria-controls="chdir" role="tab" data-toggle="tab">Change Directory</a></li>
							<li role="presentation"><a href="#unin" aria-controls="unin" role="tab" data-toggle="tab">Uninstall</a></li>
						</ul>

						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="pass">
								<p>Use this to change your dashboard login password.</p>
								<form class="form-horizontal">
									<div class="form-group">
										<label class="col-sm-3 control-label">Current Password</label>
										<div class="col-sm-9">
											<input type="password" name="curPass" class="form-control" />
										</div>
									</div>
									<hr />
									<div class="form-group">
										<label class="col-sm-3 control-label">New Password</label>
										<div class="col-sm-9">
											<input type="password" name="newPass" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Confirm Password</label>
										<div class="col-sm-9">
											<input type="password" name="confPass" class="form-control" />
										</div>
									</div>
									<input type="submit" class="btn btn-info pull-right" value="Change" />
								</form>
							</div>
							<div role="tabpanel" class="tab-pane" id="chdir">
								<p>Use this form to change your link cloaking directory.</p>
								<form class="form-horizontal">
									<div class="form-group">
										<label class="col-sm-3 control-label">Current Directory</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo $cloak_directory; ?></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">New Directory</label>
										<div class="col-sm-9">
											<input type="text" name="newDir" class="form-control" />
										</div>
									</div>
									<input type="submit" class="btn btn-info pull-right" value="Change" />
								</form>
							</div>
							<div role="tabpanel" class="tab-pane" id="unin">	
								<p>uninstal magic link cloaker :(</p>
							</div>
						</div>
					</div>
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

