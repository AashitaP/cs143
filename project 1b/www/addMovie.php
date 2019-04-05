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
$titleErr = $yearErr = $ratingErr = $comErr = $genreErr = "";
$title = $year = $rating = $company = $igenre = "";

if (isset($_GET["submit"])) {
  if (empty($_GET["title"])) {
    $titleErr = "Title is required";
  } else {
    $title = test_input($_GET["title"]);
  }

  if (empty($_GET["year"])) {
    $yearErr = "Year is required";
  } else if (!(isValidYear($_GET["year"]))) {
    $yearErr = "Please enter a valid year";
  } else {
    $year = test_input($_GET["year"]);
  }

  if (empty($_GET["rating"])) {
    $ratingErr = "Rating is required";
  } else {
    $rating = test_input($_GET["rating"]);
  }

  if (empty($_GET["company"])) {
    $comErr = "Company is required";
  } else {
    $company = test_input($_GET["company"]);
  }

  if (empty($_GET["genre"])) {
    $genreErr = "Genre is required";
  } 

}

function isValidYear($year)
{
  $year = (int)$year;
  if($year>1000 && $year<2100)
  { return true; }
  else 
  return false;
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h3> Add a new movie </h3>

<div>
<p><span class="error">* required field</span></p>
<p>
<form method="GET" action="addMovie.php" class = "form-style">
Title: <input type="text" name="title" /> 
<span class="error">* <?php echo $titleErr ?></span>
<br><br>
Year: <input type="text" name="year" /> (YYYY)
<span class="error">* <?php echo $yearErr ?></span>
<br><br>
MPAA Rating: 
<select name="rating">
<option value="G">G</option>
<option value="PG">PG</option>
<option value="PG-13">PG-13</option>
<option value="R">R</option>
<option value="NC-17">NC-17</option>
</select>
<span class="error">* <?php echo $ratingErr ?></span>
<br><br>
Company: <input type="text" name="company" />
<span class="error">* <?php echo $comErr ?></span>
<br><br>
Genre:
<input type="checkbox" name="genre[]" value="Action"> Action
<input type="checkbox" name="genre[]" value="Adult"> Adult
<input type="checkbox" name="genre[]" value="Animation"> Animation
<input type="checkbox" name="genre[]" value="Comedy"> Comedy
<input type="checkbox" name="genre[]" value="Crime"> Crime
<input type="checkbox" name="genre[]" value="Documentary"> Documentary
<input type="checkbox" name="genre[]" value="Drama"> Drama
<input type="checkbox" name="genre[]" value="Family"> Family
<input type="checkbox" name="genre[]" value="Fantasy"> Fantasy
<input type="checkbox" name="genre[]" value="Horror"> Horror
<input type="checkbox" name="genre[]" value="Musical"> Musical
<input type="checkbox" name="genre[]" value="Mystery"> Mystery
<input type="checkbox" name="genre[]" value="Romance"> Romance
<input type="checkbox" name="genre[]" value="Sci-Fi"> Sci-Fi
<input type="checkbox" name="genre[]" value="Short"> Short
<input type="checkbox" name="genre[]" value="Thriller"> Thriller
<input type="checkbox" name="genre[]" value="War"> War
<span class="error">* <?php echo $genreErr ?></span>
<br><br>

<input type="submit" value="Submit" name="submit" />
</form>
</p>

<p>
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
if (!$db_connection) {
    die('Connection failed: ' . mysql_error());
}

if ($title != "" && $year != "" && $rating !=  "" && $company != "" && $genreErr == "" && isset($_GET["submit"])) {
    $idUpdate = "UPDATE MaxMovieID SET id = id+1";
    $idQuery = "SELECT id FROM MaxMovieID";
    mysql_select_db("CS143", $db_connection);
    $rs = mysql_query($idUpdate, $db_connection);
    if (!$rs) {
        die('Invalid query: ' . mysql_error());
    } else {
      $idResource = mysql_query($idQuery, $db_connection);
      if (!$idResource) {
        die('Invalid query: ' . mysql_error());
      }
      $row = mysql_fetch_assoc($idResource);
      $id = $row[id];
      $query = "INSERT INTO Movie VALUES ('{$id}','{$title}', '{$year}', '{$rating}', '{$company}')";
      $res = mysql_query($query, $db_connection);
      if (!$res) {
        die('Invalid query: ' . mysql_error());
      }
      foreach($_GET['genre'] as $genre) {
        $query = "INSERT INTO MovieGenre VALUES('$id', '$genre')";
        $res = mysql_query($query, $db_connection);
        if (!$res) {
          die('Invalid query: ' . mysql_error());
        }
      }
    }
    echo "Added Movie!";
} 


mysql_close($db_connection);
?>

</p>
</div>

</body>



</html>

