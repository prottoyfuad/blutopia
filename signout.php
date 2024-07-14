
<?php
	session_start();
	error_reporting(1);
	$usr = $_SESSION['username'];

	// $query1=mysql_query("select * from users where Email='$user'");
	// $rec1=mysql_fetch_array($query1);
	// $userid=$rec1[0];

  while ($usr == $_SESSION['username']) {
    unset($_SESSION['username']);
    unset($_SESSION['userpass']);
  }
  
	//session_destroy();
	header("location: index.php");
?>

