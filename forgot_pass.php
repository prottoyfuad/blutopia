
<?php

if(isset($_POST['change_pass'])) {
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

  $que = "SELECT * FROM User WHERE username = '$_POST[username]'";
  $msg = "";
  $result = $conn->query($que);
  if ($result->num_rows == 0) {
    $msg = "Invalid username!<br><br>Don't have an account? Sign Up Instead!<br>";
  }
  else {
    $entity = $result->fetch_assoc();
    if ($entity['email'] != $_POST['email']) {
      $msg = "Email address doesn't match, try again!<br>";
    }
  }

  if ($msg != "") {
    echo $msg;
    $conn->close();
  } else {
    $sql = "UPDATE User SET userpass = '$_POST[newpass]' where username = '$_POST[username]'";
    if ($conn->query($sql)) {
      $conn->close();
      ?><script type = "text/javascript"> 
          alert("Password Updated! You can Sign in now!");
          window.location.href = "index.php";
      </script><?php
    } else {
      Call_Out($conn->error);
    }
  }
}

?>

<html>
<body>
  <div style = "position : absolute; left : 5%; bottom : 5%">
    <b> All rights reserved © Flaming Tomato </b>
  </div>
  <div style = "position : absolute; left : 5%; font-size : 20px;">
  <h1> Blutopia! </h1>
  <h3> Recover Account! </h2><br>
  <form method = "post">
    <div>
      Username :
      <input type = "text" name = "username" style = "width : 175;" />
    </div><br>
    <div>
      Email Address used to create account:
      <input type = "text" name = "email" style = "width : 175;" />
    </div><br>
    <div>
      New Password :
      <input type = "password" name = "newpass" style = "width : 175;">  
    </div><br><br>
    <div>
      <input type = "submit" name = "change_pass" value = "Change Password" id = "signin_button" style = "width : 150; height : 30" /><br><br>
    </div><br>
    <div>
      <a href = "index.php" style = "color:#226688;"> Go back </a>
    </div>
  </form>
  </div>
</body>
</html>

