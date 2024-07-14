
<?php 
  $dbserver = "localhost";
  $dbusername = "root";
  $dbpassword = "root";
  $dbname = "Blutopia";
  $conn = new mysqli($dbserver, $dbusername, $dbpassword, $dbname);
?>

<html>
<body>
  <div style = "position : absolute; left : 0; top : 0; 
                height : 10%; width : 100%; background : grey">
  </div>  

  <div style = "position : absolute; left : 4%; top :1%; font-size : 25; font-weight : 900;"> 
    <a href = "feed.php" style="color:bisque;"> Blutopia </a>
  </div>

  <div style = "position : absolute; left : 15%; top : 2%;">
    <?php echo "Logged in as<br>".(function($usr) use ($conn) {
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      $sql = "SELECT first_name, last_name FROM User WHERE username = '$usr'";
      $result = $conn->query($sql);
      $entity = $result->fetch_assoc();
      return $entity['first_name']." ".$entity['last_name'];
    })($_SESSION['username']); ?>
  </div>

  <div style="position:absolute; left:28%; top:3%;">
    <a href = "feed.php" style = "color : mediumaquamarine"> Feed </a>
  </div>

  <div style="position:absolute; left:35%; top:3%;">
    <a href = "wall.php" style = "color : mediumaquamarine"> Wall </a>
  </div>

  <div style="position:absolute; left:42%; top:3%;">
    <a href = "threads.php" style = "color : mediumaquamarine"> Messages </a>
  </div>

  <div style="position:absolute; right:5%; top:3%;">
    <a href = "signout.php" style = "color : mediumaquamarine"> Sign out </a>
  </div>

  <script>
    function box_check() {
      sbox = document.Search_form.search_box.value;
      if (sbox == "") return false;
      return true;
    }
  </script>

  <form name = "Search_form" action = "Search_Display_submit.php"
        method = "get" onSubmit = "return box_check()">

    <div style = "position : absolute; right : 20%; top : 2%;">
      <input type = "text" name = "search_box" style = "height : 30; width : 300;"
      onKeyUp = "searching();" id = "search_text1" placeholder = "Search...">
    </div>

    <div style = "position : absolute; right : 13%; top : 2%">
      <input type = "submit" value = "Search" name = "search_button">
    </div>

  </form>
</body>
</html>

