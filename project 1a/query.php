<html>
<head>
    <title>My SQL query site</title>
</head>
<body>
<h3> Enter your select query below: </h3>
<p>
<form action="query.php" method="GET">
   <textarea name="query" cols="60" rows="8"><?php print "$query" ?></textarea><br />
   <input type="submit" value="Submit" />
</form>

</p>

<h3>Results from your query:</h3>
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
if (!$db_connection) {
    die('Connection failed: ' . mysql_error());
}

if(isset($_GET['query'])) {
    $query = $_GET['query'];
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


</body>
</html>

