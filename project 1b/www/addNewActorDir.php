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


<h3> Add a New Actor or Director </h3>

<?php
// define variables and set to empty values
$fnameErr = $sexErr = $typeErr = $dobErr = $dodErr = "";
$typeAD = $firstName = $sex = $lastName = $dob = $dod = "";

if (isset($_GET["submit"])) {
  if (empty($_GET["dob"])) {
    $dobErr = "Date of birth is required";
  } else if (!(isValidDate($_GET["dob"])))
  {
    $dobErr = "Please enter a valid date of birth";
  } else {
    $dob = test_input($_GET["dob"]);
  }
  
  if (!(isValidDate($_GET["dod"])) && !(empty($_GET["dod"])))
  {
    $dodErr = "Please enter a valid date of death";
  } else if (!(empty($_GET["dod"]))){
    $dod = test_input($_GET["dod"]);
  }

  $lastName = test_input($_GET["lastName"]);

  if (empty($_GET["sex"])) {
    $sexErr = "Sex is required";
  } else {
    $sex = test_input($_GET["sex"]);
  }

  if (empty($_GET["typeAD"])) {
    $typeErr = "Type is required";
  } else {
    $typeAD = test_input($_GET["typeAD"]);
  }

  if (empty($_GET["firstName"])) {
    $fnameErr = "First name is required";
  } else {
    $firstName = test_input($_GET["firstName"]);
  }
}

function isValidDate($date, $format = 'Y-m-d')
  {
      $d = DateTime::createFromFormat($format, $date);
      return $d && $d->format($format) === $date;
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
<form method="GET" action="addNewActorDir.php" class = "form-style">

    Type: 
<input type="radio" name="typeAD" value="Actor"> Actor
<input type="radio" name="typeAD" value="Director"> Director
<span class="error">* <?php echo $typeErr ?></span>
<br><br>
   First Name: <input type="text" name="firstName" />
   <span class="error">* <?php echo $fnameErr ?></span>
   <br><br>
   Last Name: <input type="text" name="lastName" />
   <br><br>
   Date of Birth: <input type="text" name="dob" /> (YYYY-MM-DD)
   <span class="error">* <?php echo $dobErr ?></span>
   <br><br>
   Date of Death: <input type="text" name="dod" /> (YYYY-MM-DD)
   <span class="error"><?php echo $dodErr ?></span>
   <br><br>
   Sex:
<input type="radio" name="sex" value="Female">Female
<input type="radio" name="sex" value="Male">Male
<input type="radio" name="sex" value="Transgender">Transgender
<span class="error">* <?php echo $sexErr ?></span>
<br><br>
<input type="submit" value="Submit" name = "submit"/>
</form>

</p>

<p>
<?php
$db_connection = mysql_connect("localhost", "cs143", "");
if (!$db_connection) {
    die('Connection failed: ' . mysql_error());
}

if ($sex != "" && $firstName != "" && $typeAD != "" && $dob != "" && isset($_GET["submit"])) {
$idUpdate = "UPDATE MaxPersonID SET id = id+1";
$idQuery = "SELECT id FROM MaxPersonID";
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
  if($typeAD == "Actor" && $lastName=="" && $dod == "")
    $query ="INSERT INTO {$typeAD} VALUES ('{$id}', NULL, '{$firstName}', '{$sex}', '{$dob}', NULL)";
  else if($typeAD == "Actor" && $lastName=="")
  $query ="INSERT INTO {$typeAD} VALUES ('{$id}', NULL, '{$firstName}', '{$sex}', '{$dob}', '{$dod}')"; 
  else if($typeAD == "Actor" && $dod=="")
  $query ="INSERT INTO {$typeAD} VALUES ('{$id}', '{$lastName}', '{$firstName}', '{$sex}', '{$dob}', NULL)"; 
  else if($typeAD == "Actor")
  $query ="INSERT INTO {$typeAD} VALUES ('{$id}', '{$lastName}', '{$firstName}', '{$sex}', '{$dob}', '{$dod}')";
  else if($typeAD == "Director" && $lastName=="" && $dod == "")
  $query ="INSERT INTO {$typeAD} VALUES ('{$id}', NULL, '{$firstName}', '{$dob}', NULL)";
  else if($typeAD == "Director" && $dod == "")
  $query ="INSERT INTO {$typeAD} VALUES ('{$id}','{$lastName}', '{$firstName}', '{$dob}', NULL)";
  else if($typeAD == "Director" && $lastName=="")
  $query ="INSERT INTO {$typeAD} VALUES ('{$id}',NULL, '{$firstName}', '{$dob}', '{$dod}')";
  else if($typeAD == "Director")
  $query ="INSERT INTO {$typeAD} VALUES ('{$id}','{$lastName}', '{$firstName}', '{$dob}', '{$dod}')";
  
  $res = mysql_query($query, $db_connection);
  if (!$res) {
    die('Invalid query: ' . mysql_error());
  } else
  {
      echo "Successfully added!";
  }
}
}


mysql_close($db_connection);
?>



</p>
</div>

</body>

</html>

