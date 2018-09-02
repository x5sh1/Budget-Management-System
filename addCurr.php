<?php
session_start();
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
  if(isset($_REQUEST['create1'])){
  	$sql="INSERT IGNORE INTO CurrencyType(Currency_name,Abbreviation) VALUES('".$_REQUEST['name1']."','".$_REQUEST['abbr1']."')";
  	$result=mysqli_query($conn, $sql);
    $result || die("Database access failed: " . mysqli_error($con));
  }
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/addWebs.css">
    <link rel="stylesheet" href="css/addCurr.css">
</head>
<body>
	<div id="addCurr">
		<p>Add Currency</p>
		<hr id="hr1">
		<form name="form" method="POST">
			<label id="lab1">
				Name:
				<input type="text" name="name1" required>
			</label>
			<label id="lab2">
				Abbreviation:
				<input type="text" name="abbr1" required>
			</label>
			<hr id="hr2">
		      <input id ="create" class="addBut" type="submit" name="create1" value="Create" />
    </form>
    <button id ="cancel" class="addBut" name="cancel" onclick="window.location.href='accounts.php'">Cancel</button>
	</div>
</body>
</html>