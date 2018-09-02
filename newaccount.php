<?php
session_start();
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
if(isset($_REQUEST['create'])){
  $sql="INSERT INTO BankAccount(Account_name,AccountType_id,User_id) VALUES('".$_REQUEST['accName']."','".$_REQUEST['select']."','".$_SESSION['UserId']."')";
  $result=mysqli_query($conn, $sql);
  $result || die("Database access failed: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/addWebs.css">
  <link rel="stylesheet" href="css/addAcc.css">
</head>
<body>
  <div id="addAcc">
    <hr id="hr1">
    <p>Add Account</p>
    <form name="form1" method="POST">
      <label id="lab1">
        Account Name:
        <input type="text" name="accName" required>
      </label>
      <label id="lab2">
        Account Type:
        <select name="select">
          <option value="None">Select Type</option>
          <?php
          $sql="SELECT * FROM AccountType";
          $result=mysqli_query($conn, $sql);
          $result || die("Database access failed: " . mysqli_error($con));
          while($row = mysqli_fetch_row($result)){
            echo "<option value='".$row[0]."'>".$row[1]."</option>";
          }
          ?>
        </select>
      </label>
      <hr id="hr2">
      <input id ="create" class="addBut" type="submit" name="create" value="Create" />
    </form>
    <button id ="cancel" class="addBut" name="cancel" onclick="location.reload()">Cancel</button>
  </div>
</body>
</html>