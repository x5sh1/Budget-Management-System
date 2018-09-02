<?php
session_start();
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
if(isset($_REQUEST['addInsubmit'])){		
	$sql="INSERT IGNORE INTO IncomeType(Income_name) VALUES('".$_REQUEST['text1']."')";
	$result = mysqli_query($conn,$sql);
    $result || die("Database access failed: ".mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>	
	<link rel="stylesheet" href="css/addWebs.css">
	<link rel="stylesheet" href="css/addInType.css">
</head>
<body>
	<div id="addInType">
		<p>Add Type</p>
		<hr id="hr1"/>
		<form name="form" method="POST">
			<label id="lab">
				Type name:
				<input type="text" name="text1" required>
			</label>
			<hr id="hr2"/>
			<input id ="create" class="addBut" type="submit" name="addInsubmit" value="Create"  />
		</form>
		   <button id ="cancel" class="addBut" name="submitBut" value="Cancel" onclick="window.location.href='budget.php'">Cancel</button>
	</div>
</body>
</html>