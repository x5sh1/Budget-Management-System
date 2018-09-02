<?php
session_start();
$incomeId=$_GET['iId'];
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql="SELECT * FROM Incomes WHERE Income_id=".$incomeId;
$result = mysqli_query($conn,$sql);
$result || die("Database access failed: ".mysqli_error($conn));
$row = mysqli_fetch_row($result);
if(isset($_REQUEST['submitBut'])){
	$sql="UPDATE Incomes SET IncomeType_id=".$_REQUEST['select1'].",BankAccount_id=".$_REQUEST['select2'].",Income_sum=".$_REQUEST['text1']." WHERE Income_id=".$incomeId;
	$result = mysqli_query($conn,$sql);
    $result || die("Database access failed: ".mysqli_error($conn));
    echo"<script>window.location.href='budget.php'</script>";
}
?>
<!-- income edit -->
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/addWebs.css">
    <link rel="stylesheet" href="css/inEdit.css">
</head>
<body>
	<div id="inEdit">
		<p>Income Edit</p>
		<hr id="hr1"/>
		<form name="form" method="POST" >
			<label id="lab1">
				Type:
				<select name="select1">
				<?php
				$sql1="SELECT * FROM IncomeType";
				$result1 = mysqli_query($conn,$sql1);
				$result1 || die("Database access failed: ".mysqli_error($conn));
				while($row1 = mysqli_fetch_row($result1)){
					if($row1[0]==$row[1]){
						echo "<option value=".$row1[0]." selected = 'selected'>".$row1[1]."</option>";
					}else{
						echo "<option value=".$row1[0].">".$row1[1]."</option>";
					}
				}
				?>
				</select>
			</label>
			<label id="lab2">
				Account:
				<select name="select2">
				<?php
				$sql2="SELECT * FROM BankAccount WHERE User_id=".$_SESSION['UserId'];
				$result2 = mysqli_query($conn,$sql2);
				$result2 || die("Database access failed: ".mysqli_error($conn));
				while($row2 = mysqli_fetch_row($result2)){
					if($row2[0]==$row[3]){
						echo "<option value=".$row2[0]." selected = 'selected'>".$row2[1]."</option>";
					}else{
						echo "<option value=".$row2[0].">".$row2[1]."</option>";
					}
				}
				?>
				</select>
			</label>	
			<label id="lab3">
				Amount:
				<input type="number" name="text1" value=<?php echo "'".$row[5]."'";?> required>
			</label>
			<hr id="hr2"/>
		      <input id ="create" class="addBut" type="submit" name="submitBut" value="Submit" />
    </form>
    <button id ="cancel" class="addBut" name="submitBut" value="Cancel" onclick="window.location.href='budget.php'">Cancel</button>
	</div>
</body>
</html>