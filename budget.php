<?php
session_start();
session_start();
$startDay=date("Y-m-01");
$endDay=date("Y-m-d");
include "model.php";
include "newaccount.php";
include 'addInType.php';
include "addInc.php";
include 'addExpType.php';
include "addExp.php";



?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/budgetStyle.css">
</head>
<body>
    <!-- subtitle of budget page -->
    <div id="subtitle">
        <p>Budget</p>
    </div>

    <!-- Date selectors -->
    <div id="dateSel">
        <form name="dateForm" method="POST">
            <label>Period: From
                <input class="dateSele" type="date" name="BeginDate" id="BeginDate" required value=<?php if($_REQUEST['BeginDate']){echo "'".$_REQUEST['BeginDate']."'";}else{echo "'".date("Y-m-01")."'";} ?>>
                To
                <input class="dateSele" type="date" name="endDate" id="endDate" required value=<?php if($_REQUEST['endDate']){echo "'".$_REQUEST['endDate']."'";}else{echo "'".date("Y-m-d")."'";} ?>>
            </label>
            <input class ="but" type="submit" name="dateSub" value="choose">
        </form>
    </div>
    <?php
    if(isset($_REQUEST['dateSub'])){
        $startDay=$_REQUEST['BeginDate'];
        $endDay=$_REQUEST['endDate'];
    }
    ?>

    <!-- Income part -->
    <!-- title -->
    <div id="incomeTit">
        <p>Incomes</p>
        <!-- <button id="but1" class ="but" onclick="window.location.href='addInc.php'">Add Income</button> -->
        <button id="but1" class ="but" onclick="addIn()">Add Income</button>
        <button id="but2" class ="but" onclick="addAcc()">Add Account</button>
        <button id="but3" class ="but" onclick="addInType()">Add Income Type</button>
    </div>
    <div id="inTabTit">
        <table class="dataintable">
            <tr>
                <th>Date</th>
                <th>Income Type</th>
                <th>Account</th>
                <th>Account Type</th>
                <th>Amount</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </table>
    </div>
    <!-- table -->
    <div id="incomeTab">
        <table class="dataintable">
        <?php
        $sql="SELECT * FROM Incomes WHERE User_id=".$_SESSION['UserId']." AND Date BETWEEN '".$startDay."' AND '".$endDay."'";
        $result = mysqli_query($conn,$sql);
        $result || die("Database access failed: ".mysqli_error($conn));
        $rowcount=mysqli_num_rows($result);
        if($rowcount>0){
            $total=0;
            while($row = mysqli_fetch_row($result)){
                $inTypeId=$row[1];
                $inDate=$row[2];
                $accId=$row[3];
                $inSum=$row[5];
                $inName="";
                $accName="";
                $accTypeId=0;
                $accTypeName="";
                $total+=$inSum;
                $sql1="SELECT Income_name FROM IncomeType WHERE IncomeType_id=".$inTypeId;
                $result1 = mysqli_query($conn,$sql1);
                $result1|| die("Database access failed: ".mysqli_error($conn));
                while ($row1= mysqli_fetch_row($result1)) {
                    $inName=$row1[0];
                }
                $sql2="SELECT * FROM BankAccount WHERE BankAccount_id=".$accId;
                $result2 = mysqli_query($conn,$sql2);
                $result2|| die("Database access failed: ".mysqli_error($conn));
                while ($row2 = mysqli_fetch_row($result2)) {
                    $accName=$row2[1];
                    $accTypeId=$row2[2];
                }
                $sql3="SELECT AccountType_name FROM AccountType WHERE AccountType_id=".$accTypeId;
                $result3 = mysqli_query($conn,$sql3);
                $result3|| die("Database access failed: ".mysqli_error($conn));
                while ($row3 = mysqli_fetch_row($result3)) {
                    $accTypeName=$row3[0];
                    echo"<tr><td>".$inDate."</td><td>".$inName."</td><td>".$accName."</td><td>".$accTypeName."</td><td>".$inSum."</td><td><a href='inEdit.php?iId=".$row[0]."'>Edit</a></td><td><a href='delete.php?delete=incD&deleteId=".$row[0]."'>Delete</a></td></tr>";
                }
            }
            echo "<tr><td></td><td></td><td></td><td></td><td>total: ".$total."</td></tr>";
        }

        ?>
        </table>
    </div>

    <!-- Expense table -->
    <div id="expTit">
        <p>Expenses</p>
        <button id="but1" class ="but" onclick="addExp()">Add Expense</button>
        <button id="but2" class ="but" onclick="addExpType()">Add Expense Type</button>
    </div>
    <div id="expTabTit">
        <table class="dataintable">
            <tr>
                <th>Date</th>
                <th>Expense Name</th>                
                <th>Budgeted(plan)</th>
                <th>Expense</th>
                <th>Availiable</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </table>
    </div>

    <!-- expense table -->
    <div id="expTab">
        <table class="dataintable">
        <?php
        $sql="SELECT * FROM Expenses WHERE User_id=".$_SESSION['UserId']." AND Date_expenses BETWEEN '".$startDay."' AND '".$endDay."'";
        $result = mysqli_query($conn,$sql);
        $result || die("Database access failed: ".mysqli_error($conn));
        $rowcount=mysqli_num_rows($result);
        if($rowcount>0){
            $planTot=0;
            $expTot=0;
            $avaTot=0;
            while ($row = mysqli_fetch_row($result)) {
                $expense=$row[2];
                $expTypeId=$row[4];
                $plan=$row[6];
                $expDate=$row[5];
                $ava=$plan-$expense;
                $planTot+=$plan;
                $expTot+=$expense;
                $avaTot+=$ava;
                $sql1="SELECT ExpenseType_name FROM ExpenseTypes WHERE ExpenseType_id=".$expTypeId;
                $result1 = mysqli_query($conn,$sql1);
                $result1 || die("Database access failed: ".mysqli_error($conn));
                $row1=mysqli_fetch_row($result1);
                echo "<tr>
                <td>".$expDate."</td>
                <td>".$row1[0]."</td>
                <td>".$plan."</td>
                <td>".$expense."</td>
                <td>".$ava."</td>
                <td><a href='expEdit.php?eId=".$row[0]."'>Edit</a></td>
                <td><a href='delete.php?delete=expD&deleteId=".$row[0]."'>Delete</a></td>
                </tr>";
            }
            echo"<tr><td></td><td></td><td>total: ".$planTot."</td><td>total: ".$expTot."</td><td>total: ".$avaTot."</td></tr>";
        }
        ?>  
        </table>    
    </div>
</body>
</html>