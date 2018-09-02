<?php
session_start();
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
    $sql="SELECT * From CategoryOfExpenses";
    $result = mysqli_query($conn,$sql);
    $result || die("Database access failed: ".mysqli_error($conn));
    $cateList=array();
    $cateId=array();
    $index=0;
    while($row = mysqli_fetch_row($result)){
      $cateList[$index]=$row[1];
      $cateId[$index]=$row[0];
      $index++;
    }
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/addWebs.css">
<link rel="stylesheet" href="css/addExp.css">
<script type="text/javascript">
    cate = new Object();
  cateId = new Object();
  var test=1;
  <?php
  for($x=0;$x<$index;$x++){
    $sql="SELECT * From ExpenseTypes WHERE CategoryExpense_id=".$cateId[$x];
    $result = mysqli_query($conn,$sql);
    $result || die("Database access failed: ".mysqli_error($conn));
    $typeId=array();
    $type=array();
    $in=0;
    while($row = mysqli_fetch_row($result)){
      $typeId[$in]=$row[0];
      $type[$in]=$row[1];
      $in++;
    }

    echo"cate['".$cateId[$x]."']=new Array(";
    for($i=0;$i<$in;$i++){
      echo "'".$type[$i]."',";
    }
    echo ");";

    echo"cateId['".$cateId[$x]."']=new Array(";
    for($i=0;$i<$in;$i++){
      echo "'".$typeId[$i]."',";
    }
    echo ");";
  }
?>

function set_sel(category, type)
{
    var pv, cv;
    var i, ii;
    pv=category.value;
    cv=type.value;

    type.length=1;

    if(pv=='0') return;
    if(typeof(cate[pv])=='undefined') return;

    for(i=0; i<cate[pv].length; i++)
    {
       ii = i+1;
       type.options[ii] = new Option();
       type.options[ii].text = cate[pv][i];
       type.options[ii].value = cateId[pv][i];
    }

}
</script>
</head>
<body>
	<!-- <iframe name='frameFile1' style='display: none;'></iframe> -->
  <div id="addExp">
    <p>Add Expense</p>
    <hr id="hr1"/>
    <form name="form2" method="POST">
        <label id="lab1">
            Category:
            <select name="select1" onChange="set_sel(this, this.form.select2);">
                <option value="0">Select Category</option>
                <?php
                for($i=0;$i<$index;$i++){
                    echo"<option value='".$cateId[$i]."'>".$cateList[$i]."</option>";
                }
                ?>
            </select>
            
        </label>
    	<label id="lab2">
    		Type:
    		<select name="select2" required>
    			<option value="None">Select Type</option>
    		</select>
    	</label>
      <hr id="hr2"/>
        <label id="lab3">
            Expense:
            <input type="number" name="expense" step="any" required>
        </label>
        <label id="lab4">
            Budget(plan):
            <input type="number" name="plan" step="any" required>
        </label>
        <label id="lab5">
        Date:
        <input class="dateSele" type="date" name="date" id="date" required value=<?php echo "'".date("Y-m-d")."'"; ?>>
      </label>
      <hr id="hr3"/>
        <input id ="create" class="addBut" type="submit" name="submit" value="Create" />
    </form>
    <button id ="cancel" class="addBut" name="cancel" onclick="window.location.href='budget.php'">Cancel</button>
    <!-- <hr id="hr2"/> -->
  </div>
</body>
</html>
<?php
if(isset($_REQUEST['submit'])){
    $sql="INSERT INTO Expenses(CategoryExpense_id,Expense_sum,User_id,ExpenseType_id,Date_expenses,Budget_amount) VALUES('".$_REQUEST['select1']."','".$_REQUEST['expense']."','".$_SESSION['UserId']."','".$_REQUEST['select2']."','".$_REQUEST['date']."','".$_REQUEST['plan']."')";
    $result = mysqli_query($conn,$sql);
    $result || die("Database access failed: ".mysqli_error($conn));
    echo"<script>window.location.href='budget.php';</script>";
}
?>