<html>
<head>
    <title>My SQL query site</title>
    <style>

    body {
  background-image: url('bg.jpg'); 
  background-repeat: no-repeat;
  background-size: cover;
}
.error {color: #FF0000;}
div {
  background-color: lightgrey;
  padding: 25px;
  margin: 0 auto;
  width: 600px; 
  
}

.form-style {
	margin:10px auto;
	max-width: 700px;
	padding: 20px 12px 10px 20px;
	font: 13px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}

.form-style input[type=text], 
textarea, 
select{
	box-sizing: border-box;
	border:1px solid #BEBEBE;
	padding: 7px;
	margin:0px;
	outline: none;	
}

.form-style input[type=submit]{
	background: #4B99AD;
	padding: 8px 15px 8px 15px;
	border: none;
	color: #fff;
}
.form-style input[type=submit]:hover{
	background: #4691A4;
}

h3 {
  color: white;
  font-family: 'Open Sans';
  font-size: 30px;
	margin-bottom: 10px;
  text-align: center;
}
</style>
</head>

<body>
<?php include 'nav.php';?>


<h3> Add a Comment </h3>

<?php
// define variables and set to empty values
$username = $time = $rating = $comment = "";
$usernameErr = "";

if (isset($_GET["submit"])) {
    if (empty($_GET["username"])) {
        $usernameErr = "Username is required";
      } else {
        $username = test_input($_GET["username"]);
      }
    $rating = test_input($_GET["rating"]);
    $comment = test_input($_GET["comment"]);
    $mid = test_input($_GET["mid"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div>
<p><span class="error">* required field</span></p>
<p>
<form method="GET" action="addComments.php" class = "form-style">
Username: <input type="text" name="username" /> 
<span class="error">* <?php echo $usernameErr ?></span>
<br><br>
Movie: <select name="mid">
					<?php
                        $db_connection = mysql_connect("localhost", "cs143", "");
                        if (!$db_connection) {
                            die('Connection failed: ' . mysql_error());
                        }
                        mysql_select_db("CS143", $db_connection);				
                        $rs = mysql_query("SELECT id, title FROM Movie ORDER BY title", $db_connection);
                        if (!$rs) {
                            die('Invalid query: ' . mysql_error());
                        } else {
                            	while($row = mysql_fetch_row($rs))
								echo '<option value="',$row[0],'">',$row[1],'</option>';
						}
					?>
		</select>
<br><br>
Rating: 
<select name="rating">
<option value="1">1 star</option>
<option value="2">2 stars</option>
<option value="3">3 stars</option>
<option value="4">4 stars</option>
<option value="5">5 stars</option>
</select>
<br><br>
Comment: <textarea name="comment" cols="60" rows="8"></textarea>
<br><br>
<input type="submit" value="Submit" name="submit"/>
</form>

</p>

<p>
<?php

if ($username != "" && isset($_GET["submit"])) {
    $t=time();
    $time = date("Y-m-d H:i:s",$t);
    $query = "INSERT INTO Review VALUES ('{$username}','{$time}', '{$mid}', '{$rating}', '{$comment}')";
    mysql_select_db("CS143", $db_connection);
    $rs = mysql_query($query, $db_connection);
    if (!$time) {
        die('Invalid query: ' . mysql_error());
    }else
    {
        echo "Comment successfully added!";
    }
}


mysql_close($db_connection);
?>


</p>
</div>


</body>



</html>

