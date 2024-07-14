
<?php

if(isset($_POST['signup'])) {
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
  { 
    $sql = "SELECT * FROM User WHERE username = '$_POST[username]'";
    $ret = $conn->query($sql);
    if ($ret->num_rows > 0) {
      Call_Out("Username Already taken! Try another.<br>");
    }
  }
  { 
    $sql = "SELECT * FROM User WHERE email = '$_POST[email]'";
    $ret = $conn->query($sql);
    if ($ret->num_rows > 0) {
      Call_Out("Email Already taken! Try another.<br>");
    }
  }

  date_default_timezone_set("Asia/Dhaka");
  $nowdt = date("Y-m-d H:i:s");
  $sql = "INSERT INTO USER(username, userpass, first_name, last_name, email, birth_date, created_on)
  VALUES('$_POST[username]', '$_POST[userpass]', '$_POST[fname]', '$_POST[lname]', '$_POST[email]', '$_POST[dob]', '$nowdt')";
  
  try {
    if ($conn->query($sql)) {
      Call_Out("New Account Created...<br>You can Sign in now!");
    } else {
      Call_Out($conn->error);
    }
  } catch (Exception $e) {
    Call_out($e->getMessage());
  }

  $conn->close();
}

?>

