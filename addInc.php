<?php
session_start();
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/addWebs.css">
  <link rel="stylesheet" href="css/addInc.css">
</head>
<body>
  <div id="addInc">
    <p>Add Income</p>
    <hr id="hr1"/>
    <form name="form1" method="POST">
      <label id="lab1">
        Type:
        <select name="select1">
          <option value="None">Select Type</option>
          <?php
            $sql="SELECT * FROM IncomeType";
            $result = mysqli_query($conn,$sql);
            $result || die("Database access failed: ".mysqli_error($conn));
            while($row = mysqli_fetch_row($result)){
              echo "<option value='".$row[0]."'>".$row[1]."</option>";
            }
          ?>
        </select>
      </label>
      <label id="lab2">
        Account:
        <select name="select2">
          <option value="None">Select Account</option>
          <?php
            $sql="SELECT * FROM BankAccount WHERE User_id=".$_SESSION['UserId'];
            $result = mysqli_query($conn,$sql);
            $result || die("Database access failed: ".mysqli_error($conn));
            while($row = mysqli_fetch_row($result)){
              echo "<option value='".$row[0]."'>".$row[1]."</option>";
            }
          ?>
        </select>
      </label>
      <hr id="hr2"/>
      <label id="lab3">
        Amount:
        <input type="number" name="amount" step="any" required>
      </label>
      <label id="lab4">
        Date:
        <input class="dateSele" type="date" name="date" id="date" required value=<?php echo "'".date("Y-m-d")."'"; ?> required>
      </label>
      <hr id="hr3"/>
      <input id ="create" class="addBut" type="submit" name="submitBut" value="Create" />
    </form>
    <button id ="cancel" class="addBut" name="submitBut" value="Cancel" onclick="window.location.href='budget.php'">Cancel</button>
  </div>
</body>
</html>
<?php
if(isset($_REQUEST['submitBut'])&&!empty($_REQUEST['select1'])&&!empty($_REQUEST['select2'])&&!empty($_REQUEST['amount'])){
    $sql="INSERT INTO Incomes(IncomeType_id, Date,BankAccount_id,Income_sum,User_id) VALUES('".$_REQUEST['select1']."','".$_REQUEST['date']."','".$_REQUEST['select2']."','".$_REQUEST['amount']."','".$_SESSION['UserId']."')";
    $result = mysqli_query($conn,$sql);
    $result || die("Database access failed: ".mysqli_error($conn));
    echo"<script>window.location.href='budget.php';</script>";
}
?>