<?php
session_start();
$aId=$_GET['aId'];
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql="SELECT * FROM User WHERE User_id=".$aId;
$result = mysqli_query($conn,$sql);
$result || die("Database access failed: ".mysqli_error($conn));
$row = mysqli_fetch_row($result);
?>
<!-- user information edit -->
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/addWebs.css">
  	<link rel="stylesheet" href="css/userEdit.css">
</head>
<body>
	<div id="userEdit">
		<p>User</p>
		<hr id="hr1"/>
		<form name="form" method="POST">
			<label id="lab1">
				Name:
				<input type="text" name="text1" value=<?php echo"'".$row[1]."'";?> required>
			</label>
			<label id="lab2">
				Phone:
				<input type="number" name="text2" value=<?php echo"".$row[2]."";?> required>
			</label>
			<label id="lab3">
				E-mail:
				<input type="text" name="text3" value=<?php echo"'".$row[3]."'";?> required>
			</label>
		    <label id="lab4">
				Currency:
				<select name="select1">
					<?php
					$sql="SELECT * FROM CurrencyType";
					$result = mysqli_query($conn,$sql);
					$result || die("Database access failed: ".mysqli_error($conn));
					while($row1 = mysqli_fetch_row($result)){
						if($row1[0]==$row[5]){
							echo "<option value=".$row1[0]." selected='selected'>".$row1[1]."</option>";
						}else{
							echo "<option value=".$row1[0].">".$row1[1]."</option>";
						}
					}
					?>
				</select>
			</label>
			<hr id="hr2"/>
		<input id ="create" class="addBut" type="submit" name="submit" value="Submit" />
    </form>
    <button id ="cancel" class="addBut" name="cancel" onclick="window.location.href='budget.php'">Cancel</button>
	</div>
</body>
</html>
<?php
if(isset($_REQUEST['submit'])){
$sql="UPDATE User SET User_name='".$_REQUEST['text1']."',User_phone=".$_REQUEST['text2'].",User_email='".$_REQUEST['text3']."',Currency_id=".$_REQUEST['select1']." WHERE User_id=".$aId;
$result = mysqli_query($conn,$sql);
$result || die("Database access failed: ".mysqli_error($conn));
echo"<script>window.location.href='budget.php'</script>";
}

?>