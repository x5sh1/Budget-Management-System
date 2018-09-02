<?php
session_start();
$aId=$_GET['aId'];
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql="SELECT * FROM BankAccount WHERE BankAccount_id=".$aId;
$result = mysqli_query($conn,$sql);
$result || die("Database access failed: ".mysqli_error($conn));
$row = mysqli_fetch_row($result)
?>
<!-- account edit -->
<!DOCTYPE html>
<html>
<head> 
  <link rel="stylesheet" href="css/addWebs.css">
  <link rel="stylesheet" href="css/accEdit.css">
</head>
<body>
  <div id="accEdit">
    <p>Account Edit</p>
    <hr id="hr1"/>
    <form name="form" method="POST">
      <label id="lab1">
        Name:
        <input type="text" name="text1" value=<?php echo "'".$row[1]."'";?> required>
      </label>
      <label id="lab2">
        Type:
        <select name="select1">
          <option value="1" <?php if($row[2]==1){echo "selected='selected'";}?>>Debit Card</option>
          <option value="2" <?php if($row[2]==2){echo "selected='selected'";}?>>Credit Card</option>
          <option value="3" <?php if($row[2]==3){echo "selected='selected'";}?>>Bank Account</option>
        </select>
      </label>
      <hr id="hr2"/>
            <input id ="create" class="addBut" type="submit" name="submit" value="Submit" />
    </form>
    <button id ="cancel" class="addBut" name="cancel" onclick="window.location.href='accounts.php'">Cancel</button>
  </div>
</body>
</html>
<?php
if(isset($_REQUEST['submit'])){
$sql="UPDATE BankAccount SET Account_name='".$_REQUEST['text1']."',AccountType_id=".$_REQUEST['select1']." WHERE BankAccount_id=".$aId;
$result = mysqli_query($conn,$sql);
$result || die("Database access failed: ".mysqli_error($conn));
echo "<script>window.location.href='accounts.php'</script>";
}
?>