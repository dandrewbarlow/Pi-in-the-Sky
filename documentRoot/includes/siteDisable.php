<?php
session_start();
if(!isset($_SESSION['username'])){
	$_SESSION['msg']="You must log in first!";
	header("location: index.php");
}
include('server.php');

$siteName = $_POST['siteID'];

unlink('/etc/apache2/sites-enabled/'.$siteName.'.conf');
$sqlquery = 'UPDATE websites SET is_enabled = 0 WHERE website_name="'.$siteName.'"';
mysqli_query($conn, $sqlquery);
header("location: ../userSites.php");
?>
