<?php
$content=$_GET['delete'];
$deleteId=$_GET['deleteId'];
session_start();
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
if($content=="incD"){
	$sql="DELETE FROM Incomes WHERE Income_id=".$deleteId;
	$result = mysqli_query($conn,$sql);
	$result || die("Database access failed: ".mysqli_error($conn));
	echo"<script>window.location.href='budget.php';</script>";
}else if($content=="expD"){
	$sql="DELETE FROM Expenses WHERE Expense_id=".$deleteId;
	$result = mysqli_query($conn,$sql);
	$result || die("Database access failed: ".mysqli_error($conn));
	echo"<script>window.location.href='budget.php';</script>";
}else if($content=="accD"){
	$sql="DELETE FROM BankAccount WHERE BankAccount_id=".$deleteId;
	$result = mysqli_query($conn,$sql);
		if(!$result){
		echo"<script>window.location.href='accounts.php';</script>";
	}
	$result || die("Database access failed: ".mysqli_error($conn));
	echo"<script>window.location.href='accounts.php';</script>";
}else{
	$sql="DELETE FROM Notification WHERE Notification_id=".$deleteId;
	$result = mysqli_query($conn,$sql);
	$result || die("Database access failed: ".mysqli_error($conn));
	echo"<script>window.location.href='notification.php';</script>";
}

?>