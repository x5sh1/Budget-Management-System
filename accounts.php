<?php
session_start();
include "model.php";
include "newaccount.php";
include "addCurr.php";
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/accStyle.css">
</head>
<body>
	<!-- subtitle -->
	<div id="subtitle">
		<p>Accounts & Currencies</p>
	</div>

	<div id="accTit">
		<p>Accounts</p>
		<button class="but" onclick="addAcc()">Add Account</button>
	</div>

	<div id="accTabTit">
		<table class="dataintable">
			<tr>
                <th>Account Name</th>
                <th>Account Type</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
		</table>
	</div>

	<!-- account table -->
	<div id="accTable">
		<table class="dataintable">
		<?php
		$sql="SELECT * FROM BankAccount WHERE User_id=".$_SESSION['UserId'];
		$result = mysqli_query($conn,$sql);
        $result || die("Database access failed: ".mysqli_error($conn));
        $rowcount=mysqli_num_rows($result);
        if($rowcount>0){
        	while($row = mysqli_fetch_row($result)){
        		$accName=$row[1];
        		$typeId=$row[2];
        		$sql1="SELECT AccountType_name FROM AccountType WHERE AccountType_id=".$typeId;
        		$result1 = mysqli_query($conn,$sql1);
                $result1 || die("Database access failed: ".mysqli_error($conn));
                $row1=mysqli_fetch_row($result1);
                echo "<tr><td>".$accName."</td><td>".$row1[0]."</td>
                <td><a href='accEdit.php?aId=".$row[0]."'>Edit</a></td>
                <td><a href='delete.php?delete=accD&deleteId=".$row[0]."'>Delete</a></td></tr>";
        	}
        }
		?>
		</table>
	</div>

	<!-- currency -->
		<div id="curTit">
		<p>Currencies</p>
		<button class="but" onclick="addCurr()">Add Currency</button>
	</div>

	<div id="curTabTit">
		<table class="dataintable">
			<tr>
                <th>Currency Name</th>
                <th>Abbreviation</th>
            </tr>
		</table>
	</div>

		<!-- currency table -->
	<div id="curTable">
		<table class="dataintable">
		<?php
		$sql="SELECT * FROM CurrencyType";
		$result = mysqli_query($conn,$sql);
        $result || die("Database access failed: ".mysqli_error($conn));
        $rowcount=mysqli_num_rows($result);
        if($rowcount>0){
        	while($row = mysqli_fetch_row($result)){
                echo "<tr><td>".$row[1]."</td><td>".$row[2]."</td></tr>";
        	}
        }
		?>
		</table>

</body>
</html>