
<?php
include('signin.php');
include('signup.php');
?>

<html>
<body>
  <div style = "position : absolute; left : 5%; bottom : 5%">
    <b> All rights reserved © Flaming Tomato </b>
  </div>
  <div style = "position : absolute; left : 5%; font-size : 20px;">
  <h1> Welcome to Blutopia! </h1>
  <h2> The minimal and secure social media...<br> Have a blutopian day! </h2><br>
  <form method = "post">
    <div>
      Username :
      <input type = "text" name = "username" style = "width : 175;" />
    </div><br><br>
    <div>
      Password :
      <input type = "password" name = "userpass" style = "width : 175;">  
    </div><br><br>
    <div>
      <input type = "submit" name = "signin" value = "Sign in" id = "signin_button" style = "width : 70; height : 30" /><br><br>
    </div><br>
    <div>
      <a href = "Forgot_pass.php" style = "color:#226688;"> Forgot password? Recover your account!</a>
    </div>
  </form>
  </div>

  <div style = "position : absolute; top : 10%; left : 55%; font-size : 20px;">
  <form method = "post">
    <h3> Create New Account!<br>Stay in touch with the people you care! </h3>
    <div>
      First Name :
      <input type = "text" name = "fname" class = "inputbox" style = "width : 200"/>
    </div><br>
    <div>
      Last Name :
      <input type = "text" name = "lname" class = "inputbox" style = "width : 200"/>
    </div><br>
    <div>
      Email :
      <input type = "text" name = "email" class = "inputbox" style = "width : 240"/>
    </div><br>
    <div>
      Date of birth :
      <input type = "date" name = "dob" style = "width : 185"/>
    </div><br>
    <div>
      Username :
      <input type = "text" name = "username" class = "inputbox" style = "width : 205"/>
    </div><br>
    <div>
      Password :
      <input type = "password" name = "userpass" class = "inputbox"style = "width : 210"/>
    </div><br>
    <div>
      <input type = "submit" name = "signup" value = "Sign up now!" id = "signin_button" style = "width : 120; height : 30" />
    </div>
  </form>
  </div>

</body>
</html>

