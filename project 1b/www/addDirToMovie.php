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

<h3> Add a Director to a Movie </h3>

<div>
<?php
// define variables and set to empty values
$mid = $did = "";

if (isset($_GET["submit"])) {
    $mid= test_input($_GET["mid"]);
    $did = test_input($_GET["did"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<p>
<form method="GET" action="addDirToMovie.php" class = "form-style">
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
                        mysql_close($db_connection);
					?>
		</select>
        <br><br>
Name: <select name="did">
					<?php
                        $db_connection = mysql_connect("localhost", "cs143", "");
                        if (!$db_connection) {
                            die('Connection failed: ' . mysql_error());
                        }
                        mysql_select_db("CS143", $db_connection);				
                        $rs = mysql_query("SELECT id, last, first FROM Director ORDER BY first", $db_connection);
                        if (!$rs) {
                            die('Invalid query: ' . mysql_error());
                        } else {
                            	while($row = mysql_fetch_row($rs))
                                echo '<option value="',$row[0],'">',$row[2],' ',$row[1],'</option>';
                        }
                        mysql_close($db_connection);
					?>
		</select>
<br><br>
<input type="submit" value="Submit" name="submit"/>
</form>
</p>

<p>
<?php

if (isset($_GET["submit"])) {
    $db_connection = mysql_connect("localhost", "cs143", "");
    if (!$db_connection) {
        die('Connection failed: ' . mysql_error());
    } 
    $query = "INSERT INTO MovieDirector VALUES ('{$mid}','{$did}')";
    mysql_select_db("CS143", $db_connection);
    $rs = mysql_query($query, $db_connection);
    if (!$rs) {
        die('Invalid query: ' . mysql_error());
    } 
    else
    {
        echo "Director successfully added!";
    }
    mysql_close($db_connection);
} 
?>

</p>
</div>

</body>

</html>

