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

<?php
// define variables and set to empty values
$name = "";
if (isset($_GET["submit"])) {
    $name = test_input($_GET["name"]);
    $names = explode(" ", $name);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h3> Search for movie or actor information </h3>

<div>
<p>
<form method="GET" action="search.php" class = "form-style">
Name: <input type="text" name="name" /> 
<br><br>
<input type="submit" value="Submit" name="submit" />
</form>
</p>
</div>


<p>
<h3> Matched Actors </h3>

<div>
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
if (!$db_connection) {
    die('Connection failed: ' . mysql_error());
}

if(isset($_GET["submit"]) && $name != "") {
$query = "SELECT id, CONCAT(first,' ',last) as name, sex, dob, dod FROM Actor WHERE (first LIKE '%{$names[0]}%' AND last LIKE '%{$names[1]}%') OR (first LIKE '%{$names[1]}%' AND last LIKE '%{$names[0]}%')"; 
mysql_select_db("CS143", $db_connection);
$rs = mysql_query($query, $db_connection);
if (!$rs) {
    die('Invalid query: ' . mysql_error());
} 

if(mysql_num_rows($rs) > 0)
{
    echo "<table>";
    echo "<tr>";
    $i = 0;
    while($i < mysql_num_fields($rs))
    {
        $meta = mysql_fetch_field($rs, $i);
        echo '<th>'.$meta->name.'</th>';
        $i = $i + 1;
    }
    echo "</tr>";
    while($row = mysql_fetch_row($rs)) {
        $count = count($row);
        $y = 0;
        $id = 0;
        echo "<tr>";
        while ($y < $count)
        {
            $c_row = current($row);
            echo "<td>";
            if($y == 0)
                $id = $c_row;
            if($y == 1)
            {?>
            <a href="ActorInfo.php?aid=<?php echo $id ?>"> 
            <?php
            }
            echo $c_row;
            echo "</td>";
            next($row);
            $y = $y + 1;
        }
        echo "</tr>";
    }
    echo "</table>";
} 
}
?>
</div>



<h3> Matched Movies </h3>

<div>
<?php

if(isset($_GET["submit"]) && $name != "") {
$query = "SELECT * FROM Movie WHERE title LIKE '%{$name}%'"; 
mysql_select_db("CS143", $db_connection);
$rs = mysql_query($query, $db_connection);
if (!$rs) {
    die('Invalid query: ' . mysql_error());
} 
if(mysql_num_rows($rs) > 0)
{
    echo "<table>";
    echo "<tr>";
    $i = 0;
    while($i < mysql_num_fields($rs))
    {
        $meta = mysql_fetch_field($rs, $i);
        echo '<th>'.$meta->name.'</th>';
        $i = $i + 1;
    }
    echo "</tr>";
    while($row = mysql_fetch_row($rs)) {
        $count = count($row);
        $y = 0;
        $id = 0;
        echo "<tr>";
        while ($y < $count)
        {
            $c_row = current($row);
            echo "<td>";
            if($y == 0)
                $id = $c_row;
            if($y == 1)
            {?>
            <a href="MovieInfo.php?mid=<?php echo $id ?>"> 
            <?php
            }
            echo $c_row;
            echo "</td>";
            next($row);
            $y = $y + 1;
        }
        echo "</tr>";
    }
    echo "</table>";
}

}

mysql_close($db_connection);
?>
</div>




</p>
</body>

</html> 