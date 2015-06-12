<?php
	session_start();
	
	if (!isset($_SESSION['login_user'])) {
		header("Location: index.php");
	}
	
	require 'includes/config.php';
	
	function makeDirectory($link_dir, $cloaked_dir, $link) {
		// create directory for redirect
		mkdir($link_dir . "" . $cloaked_dir);

		require 'includes/config.php';

		$conn = new mysqli($server, $user, $pass, $dbname);

		$query = $conn->prepare("INSERT INTO CloakedLinks (longlink, shorturl) VALUES (?, ?)");
		$query->bind_param("ss", $link, $cloaked_dir);
		$query->execute();

		$conn->close();
	}

	function createFile($shorturl, $dir, $link) {
		// create redirect file
		copy('includes/config.php', $dir . '/config.php');
		copy('includes/functions.php', $dir . '/functions.php');
		
		include 'includes/config.php';

		$conn = new mysqli($server, $user, $pass, $dbname);
		
		//$query = $conn->prepare("SELECT `ID` FROM CloakedLinks WHERE shorturl = `test`");
		//$query->bind_param('s', $shorturl);
		//$query->execute();
		//$query->bind_result($linkid);
		//$query->execute();
		
		$result = new mysqli($conn, "SELECT `ID` FROM CloakedLinks WHERE shorturl = `test`");
		
		if($result === false) {
			echo "error";
		} else {
			$rows = array();
			while($row = mysqli_fetch_assoc($result)) {
				echo $row;
				$rows[] = $row;
			}
		}
		
		//print_f $rows;

		/*$file = fopen($dir . "/index.php", "w") or die("Unable to open file!");
		fwrite($file, "<?php\n");
		fwrite($file, "include 'config.php';\n");
		fwrite($file, "include 'functions.php';\n");
		fwrite($file, "\n");
		fwrite($file, "\$linkid = '$linkid';\n");
		fwrite($file, "\$date = date('Y/m/d');\n");
		fwrite($file, "\$ip = \$_SERVER['REMOTE_ADDR'];\n");
		fwrite($file, "\$ua = getBrowser();\n");
		fwrite($file, "\$browser = \$ua['name'] . ' ' . \$ua['version'];\n");
		fwrite($file, "\$loc_info = json_decode(file_get_contents(\"http://ipinfo.io/{\$ip}/json\"));\n");
		fwrite($file, "\$location = \$loc_info->country;\n");
		fwrite($file, "\n");
		fwrite($file, "\$conn = new mysqli(\$server, \$user, \$pass, \$dbname);\n");
		fwrite($file, "\n");
		fwrite($file, "\$query = \$conn->prepare('SELECT shorturl FROM CloakedLinks WHERE ID = ?');\n");
		fwrite($file, "\$query->bind_param('s', \$linkid);\n");
		fwrite($file, "\$query->execute();\n");
		fwrite($file, "\$query->bind_result(\$id);\n");
		fwrite($file, "\$query->fetch();\n");
		fwrite($file, "\n");
		fwrite($file, "\$conn->close();\n");
		fwrite($file, "\n");
		fwrite($file, "\$conn = new mysqli(\$server, \$user, \$pass, \$dbname);\n");
		fwrite($file, "\n");
		fwrite($file, "\$query = \$conn->prepare('INSERT INTO `Statistics` (`ID`, `linkID`, `hitDate`, `ipaddress`, `browser`, `location`) VALUES (NULL, ?, ?, ?, ?, ?)');\n");
		fwrite($file, "\$query->bind_param('issss', \$id, \$date, \$ip, \$browser, \$location);\n");
		fwrite($file, "\$query->execute();\n");
		fwrite($file, "\n");
		fwrite($file, "\$conn->close();\n");
		fwrite($file, "\n");
		fwrite($file, "header(\"Location: $link\");\n");
		fwrite($file, "die();\n");
		fwrite($file, "?>\n");
		fclose($file);*/
	}

	function checkForDuplicates($row, $cmp_row) {
		if($row === $cmp_row) {
			header("Location: dashboard.php?err=0#add");
			die();
		}
	}

	$conn = new mysqli($server, $user, $pass, $dbname);
	$dir_name = $_POST['cloaked'];
	
	$query = $conn->prepare("SELECT shorturl FROM CloakedLinks WHERE shorturl = ?");
	$query->bind_param("s", $dir_name);
	$query->execute();
	$query->bind_result($dir_rows);
	$query->fetch();

	$conn->close();	
	
	$new_link = $_POST['link_dir'] . "" . $_POST['cloaked'];
	
	//checkForDuplicates($dir_rows, $dir_name);
	//makeDirectory($_POST['link_dir'], $_POST['cloaked'], $_POST['link']);
	createFile($_POST['cloaked'], $new_link, $_POST['link']);

	//header("Location: dashboard.php?success=0#manage");
	//die();
?>

