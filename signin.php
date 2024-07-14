
<?php

if(isset($_POST['signin'])) {
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

  $sql = "SELECT * FROM User WHERE username = '$_POST[username]'";
  $result = $conn->query($sql);
  
  $msg = "";
  if ($result->num_rows == 0) {
    $msg = "This username does not exit.<br>Don't have an account? Sign Up Instead!<br>";
  }
  else {
    $entity = $result->fetch_assoc();
    if ($entity['userpass'] != $_POST['userpass']) {
      $msg = "Wrong Password, try again!<br>";
    }
  }
  if ($msg != "") Call_Out($msg);
  else {
    session_start();
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['userpass'] = $_POST['userpass'];
    header("location: feed.php");
  }
}

?>

