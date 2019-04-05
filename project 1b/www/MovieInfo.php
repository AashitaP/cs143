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
.form-style-1 input[type=submit]:hover{
background: #4691A4;
}

h3 {
color: white;
font-family: 'Open Sans';
font-size: 30px;
margin-bottom: 10px;
text-align: center;
}

h4 {
color: black;
font-family: 'Open Sans';
font-size: 20px;
margin-bottom: 10px;
text-align: center;
}

button {
    background: #4B99AD;
	padding: 8px 15px 8px 15px;
	border: none;
	color: #fff;
}

</style>
</head>

<body>
<?php include 'nav.php';?>

<h3> Movie Information </h3>

<div>
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
if (!$db_connection) {
    die('Connection failed: ' . mysql_error());
}

if(($_GET['mid'])) {
    $title = $com = $rating = $dir = "";
    $genreArr = [];
    $mid= $_GET['mid'];
mysql_select_db("CS143", $db_connection);
$query = "SELECT * FROM Movie WHERE id=$mid";
$rs = mysql_query($query, $db_connection);
if (!$rs) {
    die('Invalid query: ' . mysql_error());
}

if(mysql_num_rows($rs) > 0)
{
    $result = mysql_fetch_assoc($rs);
    $title = $result[title];
    $com = $result[company];
    $rating = $result[rating];
}

$query = "SELECT CONCAT(first, ' ', last) as name FROM Director INNER JOIN MovieDirector ON Director.id = MovieDirector.did WHERE MovieDirector.mid=$mid";
$rs = mysql_query($query, $db_connection);
if (!$rs) {
    die('Invalid query: ' . mysql_error());
}
if(mysql_num_rows($rs) > 0)
{
    $result = mysql_fetch_assoc($rs);
    $dir = $result[name];
}

$query = "SELECT genre FROM MovieGenre WHERE MovieGenre.mid=$mid";
$rs = mysql_query($query, $db_connection);
if (!$rs) {
    die('Invalid query: ' . mysql_error());
}
if(mysql_num_rows($rs) > 0)
{
    while($genre = mysql_fetch_row($rs)) {
        array_push($genreArr, $genre);
        next($row);
    }
}

}

mysql_close($db_connection);
?>
Title: <?php echo $title ?>
<br>
Company: <?php echo $com ?>
<br>
Rating: <?php echo $rating ?>
<br>
Director: <?php echo $dir ?>
<br>
Genre: 
<?php
for($i = 0; $i < count($genreArr); $i++)
{
    echo $genreArr[$i][0];
    if($i != count($genreArr) - 1)
    echo ", ";
}

?>

</div>


<h3> Actors in this Movie </h3>

<div>
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
if (!$db_connection) {
    die('Connection failed: ' . mysql_error());
}

if(($_GET['mid'])) {
    $mid= $_GET['mid'];
mysql_select_db("CS143", $db_connection);
$query = "SELECT aid, CONCAT(first,' ',last) as name, role FROM MovieActor INNER JOIN Actor ON Actor.id = MovieActor.aid WHERE MovieActor.mid=$mid";
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
        $aid = 0;
        echo "<tr>";
        while ($y < $count)
        {
            $c_row = current($row);
            if($y == 0)
            $aid = $c_row;
            echo "<td>";
            if($y == 1)
            {?> 
            <a href="ActorInfo.php?aid=<?php echo $aid ?>"> 
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

<h3> User Reviews </h3>
<br><br>
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
if (!$db_connection) {
    die('Connection failed: ' . mysql_error());
}

if(($_GET['mid'])) {
    $mid= $_GET['mid'];
mysql_select_db("CS143", $db_connection);
$query = "SELECT AVG(rating) FROM Review WHERE Review.mid=$mid";
$rs = mysql_query($query, $db_connection);
if (!$rs) {
    die('Invalid query: ' . mysql_error());
}

$aveScore = mysql_fetch_row($rs);
$aveScore = $aveScore[0];
$query = "SELECT COUNT(*) FROM Review WHERE Review.mid=$mid";
$rs = mysql_query($query, $db_connection);
if (!$rs) {
    die('Invalid query: ' . mysql_error());
}

$countPeople = mysql_fetch_row($rs);
$countPeople = $aveScore[0];

}
mysql_close($db_connection);
?>

<h4> The average score for this Movie is <?php echo $aveScore ?> based on <?php echo $countPeople ?> review(s). </h4>

<div>
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
if (!$db_connection) {
    die('Connection failed: ' . mysql_error());
}

if(($_GET['mid'])) {
    $mid= $_GET['mid'];
mysql_select_db("CS143", $db_connection);
$query = "SELECT * FROM Review WHERE Review.mid=$mid";
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
        $aid = 0;
        echo "<tr>";
        while ($y < $count)
        {
            $c_row = current($row);
            if($y == 0)
            $aid = $c_row;
            echo "<td>";
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

<button href="addComments.php"> Add a Comment </button>
</div>



</body>

</html>

