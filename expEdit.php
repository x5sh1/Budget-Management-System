<?php
session_start();
$eId=$_GET['eId'];
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
    $sql1="SELECT * FROM Expenses WHERE Expense_id=".$eId;
    $result1 = mysqli_query($conn,$sql1);
    $result1 || die("Database access failed: ".mysqli_error($conn));
    $row1 = mysqli_fetch_row($result1);

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
<!-- exense edit -->
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/addWebs.css">
  <link rel="stylesheet" href="css/expEdit.css">
  <script type="text/javascript">
    cate = new Object();
  cateId = new Object();
  var ti=<?php echo $row1[4];?>;
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

function set_sel(category, type,n)
{
    var pv,cv;
    var i, ii;
    if(n==1){
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
    }else{
          pv=<?php echo $row1[1];?>;
    cv=type.value;
    type.length=1;

    if(pv=='0') return;
    if(typeof(cate[pv])=='undefined'){ return;}

    for(i=0; i<cate[pv].length; i++)
    {

       ii = i+1;

       type.options[ii] = new Option();
       if(cateId[pv][i]==ti){
        type.options[ii].selected='selected';
       }
       type.options[ii].text = cate[pv][i];
       type.options[ii].value = cateId[pv][i];

    }
    }


}
</script>
</head>
<body>
  <div id="expEdit">
    <p>Expense Edit</p>
    <hr id="hr1"/>
    <form name="form1" method="POST">
            <label id="lab2">
        Type:
        <select id="select2" name="select2" required>
          <option value="None">Select Type</option>
        </select>
      </label>
              <label id="lab1">
            Category:
            <select id="select1" name="select1" onChange="set_sel(this, this.form.select2,1);">
                <option value="0">Select Category</option>
                <?php
                for($i=0;$i<$index;$i++){
                    if($row1[1]==$cateId[$i]){
                      echo"<option value='".$cateId[$i]."' selected='selected'>".$cateList[$i]."</option>";
                    }else{
                      echo"<option value='".$cateId[$i]."'>".$cateList[$i]."</option>";
                    }
                }
                echo "<script>set_sel(document.getElementById('select1'),document.getElementById('select2'),2);</script>";
                ?>
            </select>
            
        </label>

        <label id="lab3">
            Expense:
            <input type="text" name="expense" value=<?php echo $row1[2];?> required>
        </label>
        <label id="lab4">
            Budget(plan):
            <input type="text" name="plan" value=<?php echo $row1[6];?> required>
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
$sql="UPDATE Expenses SET CategoryExpense_id=".$_REQUEST['select1'].", Expense_sum=".$_REQUEST['expense'].",ExpenseType_id=".$_REQUEST['select2'].",Budget_amount=".$_REQUEST['plan']." WHERE Expense_id=".$eId;
    $result = mysqli_query($conn,$sql);
    $result || die("Database access failed: ".mysqli_error($conn));
    echo "<script>window.location.href='budget.php'</script>";
}
?>