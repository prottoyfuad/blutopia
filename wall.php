
<?php
session_start();
$dbserver = "localhost";
$dbusername = "root";
$dbpassword = "root";
$dbname = "Blutopia";
    
function Call_Out($args) { ?>
  <div class="callout", style = "color : hotpink; font-size : 20">
    <div class="callout-header">Alert</div>
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <div class="callout-container">
      <?php echo $args ?>
    </div>
  </div> <?php
}

$conn = new mysqli($dbserver, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['username'])) {
	include("background.php");
}

?>

