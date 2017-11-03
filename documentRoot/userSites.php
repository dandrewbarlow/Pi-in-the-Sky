<?php
session_start();
if (!isset($_SESSION['username'])){
	$_SESSION['msg'] = "You must log in first";
	header('location: index.php');
}
include('includes/requireLogin.php');
include('includes/dbconnect.php');
?>
<html>
<head>
	<title>Hosted Sites | Pi In The Sky</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
	<div class="header">
		<h2>Website Management</h2>
	</div>
	<div class="content">
		<p>Here you can manage what websites your sever is currently hosting</p>
		<h2>Enabled Sites</h2>
		<table align="center">
			<tr> <th>Id</th> <th>Website Name</th> <th>Created By</th> <th>Created On</th> <th>Is Domain?</th> <th>Disable?</th> </tr>
		<?php
			$query = "";
			if ($_SESSION['superuser'] == 1) {
				$query = "SELECT * FROM websites WHERE is_enabled = 1";
			}
			else {
				$username = $_SESSION['username'];
				$query = "SELECT * FROM websites WHERE (is_enabled = 1 AND user_uid = '$username')"
			}
			$result = mysqli_query($conn, $query);
			//$i =0;
			$filelist="";
			while($row = mysqli_fetch_array($result)){
				$form = '<form method="post" action="includes/siteDisable.php"><input type="hidden" name="siteID" value="'.$row['website_name'].'">';
				$button = '<input type="submit" value="disable"></form>';
				$filelist .= "<tr><td>".$row['site_id'].'</td>';
				$filelist .= "<tr><td>".$row['website_name'].'</td>';
				$filelist .= "<tr><td>".$row['user_uid'].'</td>';
				$filelist .= "<tr><td>".$row['created_on'].'</td>';
				$filelist .= "<tr><td>".$row['is_domain'].'</td>';
				$filelist .= '<td>'.$form.$button.'</td></tr><br>';
			}
			echo $filelist;
		?>
		</table>
		<h2>Available Sites</h2>
		<table align="center">
		<?php
			$query = "SELECT website_name FROM websites WHERE is_enabled = 0";
			$result = mysqli_query($conn, $query);
			$i =0;
			$filelist = "";
			while($i = mysqli_fetch_assoc($result)){
				$form = '<form method="post" action="includes/siteEnable.php"><input type="hidden" name="siteID" value="'.$i['website_name'].'">';
				$button = '<input type="submit" value="Enable"></form>';
				$form2 = '<form method="post" action="includes/siteDelete.php"><input type="hidden" name="siteID" value="'.$i['website_name'].'">';
				$button2 = '<input type="submit" value="Delete"></form>';
				$filelist.="<tr><td>".$i['website_name'].'</td><td>'.$form.$button.'</td><td>'.$form2.$button2.'</td></tr><br>';
			}
			echo $filelist;
		?>
		</table>
		<a href="upload.php">Create a site</a>
	</div>
</body>
</html>
