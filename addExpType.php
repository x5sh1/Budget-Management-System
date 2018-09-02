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
  <link rel="stylesheet" href="css/addExpType.css">
</head>
<body>
  <div id="addExpType">
    <p>Add Type</p>
    <hr id="hr1"/>
    <form name="form1" method="POST">
      <label id="lab1">
        Category:
        <select name="select1" required>
          <option value="None">Select Category</option>
          <?php
          $sql="SELECT * FROM CategoryOfExpenses";
          $result = mysqli_query($conn,$sql);
          $result || die("Database access failed: ".mysqli_error($conn));
          while($row = mysqli_fetch_row($result)){
            echo "<option value=".$row[0].">".$row[1]."</option>";
          }
          ?>
        </select>
      </label>
      <label id="lab2">
        Name:
        <input type="text" name="text1" required>
      </label>
      <hr id="hr2"/>    
            <input id ="create" class="addBut" type="submit" name="addExpsubmit" value="Create" />
    </form>
    <button id ="cancel" class="addBut" name="cancel" onclick="window.location.href='budget.php'">Cancel</button>
  </div>
</body>
</html>
<?php
if(isset($_REQUEST['addExpsubmit'])){
  $sql="INSERT IGNORE INTO ExpenseTypes(ExpenseType_name,CategoryExpense_id)VALUES('".$_REQUEST['text1']."',".$_REQUEST['select1'].")";
  $result = mysqli_query($conn,$sql);
  $result || die("Database access failed: ".mysqli_error($conn));
  echo"<script>window.location.href='budget.php'</script>";
}
?>