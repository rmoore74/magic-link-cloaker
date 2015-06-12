<?php
	session_start();
	include 'includes/config.php';
	
	if (!isset($_SESSION['login_user'])) {
		header("Location: index.php");
	}
	
	$id = $_GET['id'];
	
	// get title 
	$conn = new mysqli($server, $user, $pass, $dbname);

	$query = $conn->prepare("SELECT shorturl, longlink FROM CloakedLinks WHERE ID = ?");
	$query->bind_param("s", $id);
	$query->execute();
	$query->bind_result($title, $subtitle);
	$query->fetch();

	$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Link Statistics - Magic Link Cloaker v1.0</title>
	
	<link rel="stylesheet" href="styles/mlc-styles.css">
	<link rel="stylesheet" href="styles/parsley.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
	<body style="background: #eee;">
		<div id="mlc-contain">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1><?php echo $title . " <small>" . $subtitle . "</small>"; ?></h1>
					<div style="text-align: right;">
						<a href="dashboard.php">Dashboard</a> | <a href="logout.php">Logout</a>
					</div>
				</div>
				<div class="panel-body">
					<h4>Hit Count</h4>
					<p>
						<canvas id="hitChart" width="100%" height="50%"></canvas>
<?php
$conn = new mysqli($server, $user, $pass, $dbname);

$query = $conn->prepare("SELECT `hitDate`, `ipaddress`, `browser`, `location` FROM Statistics WHERE linkID = ?");
$query->bind_param('s', $id);
$query->execute();
$query->bind_result($result);
//$query->fetch();

if($query->num_rows > 0 ) {
	echo "hello";
} else {
	echo "oops";
}

$conn->close();
?>
						<table>
						
						</table>
					</p>
				</div>
			</div>
			<footer style="font-size: 12">
				&copy; 2015 <a href="http://rogermoore.io/">rogermoore.io</a>. All rights reserved.
			</footer>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<script src="js/Chart.min.js"></script>
		<script>
			var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
			var lineChartData = {
				labels : ["January","February","March","April","May","June","July"],
				datasets : [
					{
						label: "My First dataset",
						fillColor : "rgba(220,220,220,0.2)",
						strokeColor : "rgba(220,220,220,1)",
						pointColor : "rgba(220,220,220,1)",
						pointStrokeColor : "#fff",
						pointHighlightFill : "#fff",
						pointHighlightStroke : "rgba(220,220,220,1)",
						data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
					},
					{
						label: "My Second dataset",
						fillColor : "rgba(151,187,205,0.2)",
						strokeColor : "rgba(151,187,205,1)",
						pointColor : "rgba(151,187,205,1)",
						pointStrokeColor : "#fff",
						pointHighlightFill : "#fff",
						pointHighlightStroke : "rgba(151,187,205,1)",
						data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
					}
				]

			}

			window.onload = function(){
				var ctx = document.getElementById("hitChart").getContext("2d");
				window.myLine = new Chart(ctx).Line(lineChartData, {
					responsive: true
				});
			}

		</script>
	</body>
</html>

