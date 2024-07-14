
<?php
session_start();
if (isset($_SESSION['username'])) {
  include("background.php");

  $dbserver = "localhost";
  $dbusername = "root";
  $dbpassword = "root";
  $dbname = "Blutopia";

  function Call_Out($args) { ?>
    <div class="callout", style="color : hotpink; font-size : 16; position : absolute; right : 5; top : 60">
      <div class="callout-header">Alert! 
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;
        <?php echo "<br>".$args ?>
      </span></div>
    </div> <?php
  }

  function Time_Now() {
    date_default_timezone_set("Asia/Dhaka");
    return date("Y-m-d H:i:s");
  }

  $conn = new mysqli($dbserver, $dbusername, $dbpassword, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $getName = function ($usr) use ($conn) {
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT first_name, last_name FROM User WHERE username = '$usr'";
    $result = $conn->query($sql);
    $entity = $result->fetch_assoc();
    return $entity['first_name'] . " " . $entity['last_name'];
  };

  $reactionCount = function ($twid, $react) use ($conn) {
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT count(*) AS dx FROM reaction WHERE tweet_id = $twid AND vote = $react";
    $result = $conn->query($sql);
    $entity = $result->fetch_assoc();
    return $entity['dx'];
  };

  $usersReaction = function ($twid, $usr) use ($conn) {
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT vote FROM reaction WHERE tweet_id = '$twid' AND src_name = '$usr'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) return -1;
    $entity = $result->fetch_assoc();
    return intval($entity['vote']);
  };

	if (isset($_POST['tweet_button'])) {
		$tweet_txt = $_POST['tweet_txt'];
    $nlen = strlen($tweet_txt);
    $valid = true;
    if ($nlen > 240 or $nlen < 1) $valid = false;
    if ($valid == false) {
      Call_Out("Tweet length is not in range[0, 240]");
    } else {
      $valid = false;
      for ($i = 0; $i < $nlen; $i++) if ($tweet_txt[$i] != ' ') $valid = true;
      if ($valid == false) {
        Call_Out("Tweet length is not in range[0, 240]");
      } else {
        $post_time = Time_Now();
        $sql = "INSERT INTO Tweet(src_name, tweet, created_on) VALUES('$_SESSION[username]', '$tweet_txt', '$post_time')";
        try {
          if ($conn->query($sql)) {
            Call_Out("Tweet posted Successfully!");
          } else {
            Call_Out($conn->error);
          }
        } catch (Exception $e) {
          Call_out($e->getMessage());
        }
      }
    }
	}

  ?>
  <html>
  <body>
    <form method = "post" name = "tweet_txt" id = "post_txt">
      <div style = "position : absolute; left : 10%; top : 15%;">
        <textarea style = "height : 100; width : 500;" name = "tweet_txt"
        maxlength = "240" placeholder = "What are you tweeting today?"></textarea>
      </div>
      <div style="position:absolute; left:10%; top : 35%;">
        <input type = "submit" value = "Tweet" name = "tweet_button" id = "tweet_button_id">
      </div>
    </form>

    <div style="position:absolute;left:10%; top:39%;">
      <table cellspacing="0">
        <?php
        $que_tweet = "SELECT * FROM Tweet WHERE src_name = ANY (
        SELECT trg_name FROM Follow_event WHERE src_name = '$_SESSION[username]'
      ) ORDER BY created_on DESC";

        $que_result = $conn->query($que_tweet);
        while ($entity = $que_result->fetch_assoc()) {
          $tweet_id = $entity['tweet_id'];
          $src_name = $entity['src_name'];
          $tweet_txt = $entity['tweet'];
          $tweet_created_on = $entity['created_on'];
          $src_fullname = $getName($src_name);
        ?>
          <tr>
            <td colspan="4" align="right" style="border-top:outset; border-top-width:thin;">&nbsp; </td>
            <td> </td>
            <td> </td>
          </tr>
          <tr>
            <td colspan="3" style="padding:7;">
              <a href="wall.php?id=<?php echo $src_name; ?>" id="<?php echo $tweet_id; ?>"> <?php echo $src_fullname ?> </a>
              <?php echo "<br>" . $tweet_created_on ?>
            </td>
            <td> </td>
            <td> </td>
            <td> </td>
          </tr>

          <?php
          $len = strlen($tweet_txt);
          if ($len > 0 && $len <= 85) {
            $line1 = substr($tweet_txt, 0, 85);
          ?>
            <tr>
              <td></td>
              <td colspan="3" style="padding-left:7;"><?php echo $line1; ?> </td>
            </tr>
          <?php
          } else if ($len > 85 && $len <= 165) {
            $line1 = substr($tweet_txt, 0, 85);
            $line2 = substr($tweet_txt, 85, 85);
          ?>
            <tr>
              <td></td>
              <td colspan="3" style="padding-left:7;"><?php echo $line1; ?> </td>
            </tr>
            <tr>
              <td> </td>
              <td colspan="3" style="padding-left:7;"><?php echo $line2; ?> </td>
            </tr>
          <?php
          } else {
            $line1 = substr($tweet_txt, 0, 85);
            $line2 = substr($tweet_txt, 85, 85);
            $line3 = substr($tweet_txt, 165, 85);
          ?>
            <tr>
              <td></td>
              <td colspan="3" style="padding-left:7;"><?php echo $line1; ?> </td>
            </tr>
            <tr>
              <td></td>
              <td colspan="3" style="padding-left:7;"><?php echo $line2; ?> </td>
            </tr>
            <tr>
              <td></td>
              <td colspan="3" style="padding-left:7;"><?php echo $line3; ?> </td>
            </tr>
          <?php
          }
          ?>

          <tr style="color:#6D84C4;">
            <td> </td>
            <?php
            $upvote_count = $reactionCount($tweet_id, 1);
            $downvote_count = $reactionCount($tweet_id, 0);
            $user_vote = $usersReaction($tweet_id, $_SESSION['username']);
            if ($user_vote == 1) { 
            ?>
              <td style="padding-top:15;">
                <form method="post">
                  <input type="hidden" name="tweetid1" value="<?php echo $tweet_id; ?>">
                  <label for="upvote_tweet"><?php echo "↑ ".$upvote_count." ." ?></label>
                  <input type="submit" value="Upvote" name="upvote1" style="border:black; font-size:15px; color:white; background:green" id="upvote_id1">
                  <label for="downvote_tweet"><?php echo " . ↓ ".$downvote_count." ." ?></label>
                  <input type="submit" value="Downvote" name="downvote1" style="border:black; font-size:15px; color:Red;" id="downvote_id1">
                </form>
              </td>
            <?php
            } 
            else if ($user_vote == 0) {
            ?>
              <td style="padding-top:15;">
                <form method="post">
                  <input type="hidden" name="tweetid0" value="<?php echo $tweet_id; ?>">
                  <label for="upvote_tweet"><?php echo "↑ ".$upvote_count." ." ?></label>
                  <input type="submit" value="Upvote" name="upvote0" style="border:black; font-size:15px; color:Green;" id="upvote_id0">
                  <label for="downvote_tweet"><?php echo " . ↓ ".$downvote_count." ." ?></label>
                  <input type="submit" value="Downvote" name="downvote0" style="border:black; font-size:15px; color:white; background:red;" id="downvote_id0">
                </form>
              </td>
            <?php
            } 
            else {
            ?>
              <td style="padding-top:15;">
                <form method="post">
                  <input type="hidden" name="tweetid2" value="<?php echo $tweet_id; ?>">
                  <label for="upvote_tweet"><?php echo "↑ ".$upvote_count." ." ?></label>
                  <input type="submit" value="Upvote" name="upvote2" style="border:black; font-size:15px; color:Green;" id="upvote_id2">
                  <label for="downvote_tweet"><?php echo " . ↓ ".$downvote_count." ." ?></label>
                  <input type="submit" value="Downvote" name="downvote2" style="border:black; font-size:15px; color:Red;" id="downvote_id2">
                </form>
              </td>
            <?php
            }
            ?>




        <?php
        }
        ?>
      </table>
    </div>

  </body>

  </html>

<?php
} else {
  header('location: index.php');
}

?>

