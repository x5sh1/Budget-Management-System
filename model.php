<?php
session_start();
if(!empty($_REQUEST['usrId'])){
$_SESSION['UserId']=$_REQUEST['usrId'];
}
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/modelStyle.css">
    <!-- function for user information -->
    <script type="text/javascript">
        window.onload=function(){
            var Pp=document.getElementById('one');
            var inf=document.getElementById('info');
                Pp.onmouseover=function(){
                    inf.style.display='block';
                };
                Pp.onmouseout=function(){
                    inf.style.display='none';
                };

                inf.onmouseover=function(){
                    inf.style.display='block';
                };
                inf.onmouseout=function(){
                    inf.style.display='none';
                };
        };

        function addIn(){
            var inc=document.getElementById('addInc');
                inc.style.display='block';            
        }
        function addExp(){
            var exp=document.getElementById('addExp');
                exp.style.display='block';            
        }
        function addAcc(){
            var acc=document.getElementById('addAcc');
                acc.style.display='block';            
        }
        function addNoti(){
            var noti=document.getElementById('addNoti');
                noti.style.display='block';            
        }
        function addInType(){
            var inType=document.getElementById('addInType');
                inType.style.display='block';            
        }
        function addCurr(){
            var curr=document.getElementById('addCurr');
                curr.style.display='block';            
        }
        function addExpType(){
            var expType=document.getElementById('addExpType');
                expType.style.display='block'; 
        }
    </script>
</head>
<body>
	<!-- Title of webs -->
	<div id="item1">
    	<p>Family Budget Management Service</p>
	</div>
	<!-- Navigation -->
	<div id="item2">
		<ul>                   
            <li><button class="butt" onclick="window.location.href='budget.php'">Budget</button></li>
            <li><button class="butt" onclick="window.location.href='report.php'">Reports</button></li>
            <li><button class="butt" onclick="window.location.href='notification.php'">Notifications</button></li>
            <li><button class="butt" onclick="window.location.href='accounts.php'">Accounts & Currencies</button></li>
    	</ul>
    	<?php
    	$firstDay=date("Y-m-01");
    	$currentDay=date("Y-m-d");
    	$sql="SELECT Income_sum FROM Incomes WHERE User_id=".$_SESSION['UserId']." AND Date BETWEEN '".$firstDay."' AND '".$currentDay."'";
    	$result = mysqli_query($conn,$sql);
        $result || die("Database access failed: ".mysqli_error($conn));
        $rowcount=mysqli_num_rows($result);
    	$totIncome=0;
    	if($rowcount>0){
    		while($row = mysqli_fetch_row($result)){
    			$totIncome+=$row[0];
        	}
    	}

        $sql="SELECT Expense_sum FROM Expenses WHERE User_id=".$_SESSION['UserId']." AND Date_expenses BETWEEN '".$firstDay."' AND '".$currentDay."'";
    	$result = mysqli_query($conn,$sql);
        $result || die("Database access failed: ".mysqli_error($conn));
        $rowcount=mysqli_num_rows($result);
    	$totExpense=0;
    	if($rowcount>0){
    	   	while($row = mysqli_fetch_row($result)){
    	    	$totExpense+=$row[0];
        	}	
   		}
        $balance=$totIncome-$totExpense;
        echo "<ul class='three'>
        <li class='center'>".date("Y")."</li>
		<li class='monthSize'>".date("M")."</li>
		<hr class='hrStyle'>
		<li class='center'>Total Income</li>
		<li class='center'>".$totIncome."</li>
		<hr class='hrStyle'>
		<li class='center'>Total Expense</li>
		<li class='center'> ".$totExpense."</li>
        <hr class='hrStyle'>
        <li class='center'>Balance</li>
        <li class='center'> ".$balance."</li>
		</ul>";
    	?>

	</div>
	<!-- User information -->
	<div id="userinfo">
		<?php
		$sql="SELECT * FROM User WHERE User_id=".$_SESSION['UserId'];
		$result = mysqli_query($conn,$sql);
        $result || die("Database access failed: ".mysqli_error($conn));
        while($row = mysqli_fetch_row($result)){
        	$usrName=$row[1];
            $usrPhone=$row[2];
            $usrMail=$row[3];
            $currencyId=$row[5];
        }
        $sql="SELECT Abbreviation FROM CurrencyType WHERE Currency_id=".$currencyId;
		$result = mysqli_query($conn,$sql);
        $result || die("Database access failed: ".mysqli_error($conn));
        while($row = mysqli_fetch_row($result)){
        	$abb=$row[0];
        }
		echo "<p id='one'>".$usrName."</p>
		<p id='one'>Currency: ".$abb."</p>";
		?>
	</div>
	<div id="info">
		<?php
		echo "<ul class='two'>
		<li>Phone: ".$usrPhone."</li>
		<li>E-mail: ".$usrMail."</li>
        <li><a href='userEdit.php?aId=".$_SESSION['UserId']."'>EDIT</a></li>
		<li><a href='index.php'>LOG OUT</a></li>
		</ul>";
		?>
	</div>
</body>
</html>