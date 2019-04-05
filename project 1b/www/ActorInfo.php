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

<h3> Actor Information </h3>

<div>
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
if (!$db_connection) {
    die('Connection failed: ' . mysql_error());
}

if(($_GET['aid'])) {
    $aid= $_GET['aid'];
mysql_select_db("CS143", $db_connection);
$query = "SELECT * FROM Actor WHERE id=$aid";
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
        echo "<tr>";
        while ($y < $count)
        {
            $c_row = current($row);
            echo "<td>".$c_row."</td>";
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



<h3> Actor's Role and Movie</h3>

<div>
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
if (!$db_connection) {
    die('Connection failed: ' . mysql_error());
}

if(($_GET['aid'])) {
    $aid= $_GET['aid'];
mysql_select_db("CS143", $db_connection);
$query = "SELECT mid, role, title FROM MovieActor INNER JOIN Movie ON Movie.id = MovieActor.mid WHERE MovieActor.aid=$aid";
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
        $mid = 0;
        echo "<tr>";
        while ($y < $count)
        {
            $c_row = current($row);
            if($y == 0)
            $mid = $c_row;
            echo "<td>";
            if($y == 2)
            {?> 
            <a href="MovieInfo.php?mid=<?php echo $mid ?>"> 
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

</body>

</html>

