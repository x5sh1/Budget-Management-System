<?php
session_start();
include "model.php";
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if($_SESSION['start']==""){
    $_SESSION['start']=date("Y-m-01");
    $_SESSION['end']=date("Y-m-d");
}
            $colors=array("rgba(255, 99, 132, 0.2)",
            "rgba(54, 162, 235, 0.2)",
            "rgba(255, 206, 86, 0.2)",
            "rgba(75, 192, 192, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)");
            $bColors=array("rgba(255, 99, 132, 1)",
            "rgba(54, 162, 235, 1)",
            "rgba(255, 206, 86, 1)",
            "rgba(75, 192, 192, 1)",
            "rgba(153, 102, 255, 1)",
            "rgba(255, 159, 64, 1)");

?>
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="css/reportStyle.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <script type="text/javascript">
            //show categoty info
            function r1(){
                var redio1=document.getElementById('radio1');
                var redio2=document.getElementById('radio2');
                redio1.checked=true;
                radio2.checked=false;
                if(redio1.checked==true){
                    document.getElementById('cate').style.display='block';
                    document.getElementById('typesSel').style.display='none';
                    document.getElementById('ty').style.display='none';
                    document.getElementById('selBut').style.display='none';
                }
            }
            //show type info
            function r2(){
                var redio1=document.getElementById('radio1');
                var redio2=document.getElementById('radio2');
                redio1.checked=false;
                radio2.checked=true;
                if(redio2.checked==true){
                    document.getElementById('cate').style.display='none';
                    document.getElementById('typesSel').style.display='block';
                    document.getElementById('ty').style.display='block';
                    document.getElementById('selBut').style.display='block';
                }
            }
            //show doungt chart
            function r4(){
                var redio4=document.getElementById('radio4');
                var redio5=document.getElementById('radio5');
                redio4.checked=true;
                radio5.checked=false;
                if(redio4.checked==true){
                     document.getElementById('Chart1').style.display='block';
                     document.getElementById('Chart2').style.display='block';
                     document.getElementById('Chart3').style.display='block';
                     document.getElementById('Chart4').style.display='none';
                     document.getElementById('Chart5').style.display='none';
                     document.getElementById('Chart6').style.display='none';
                }
            }
            //show bar chart
            function r5(){
                var redio4=document.getElementById('radio4');
                var redio5=document.getElementById('radio5');
                redio5.checked=true;
                radio4.checked=false;
                if(redio5.checked==true){
                     document.getElementById('Chart1').style.display='none';
                     document.getElementById('Chart2').style.display='none';
                     document.getElementById('Chart3').style.display='none';
                     document.getElementById('Chart4').style.display='block';
                     document.getElementById('Chart5').style.display='block';
                     document.getElementById('Chart6').style.display='block';
                }
            }

        </script>
</head>
<body>
    <!-- subtitle -->
    <div id="subtitle">
        <p>Reports</p>
    </div>
    <!-- date selector -->
        <div id="dateSel">
                <label id="eBoxLab4">
            Donut Chart:    
            <input type="checkbox" id="radio4" onClick="r4()" >
            </label>
            <label id="eBoxLab5">
            Bar Chart:    
            <input type="checkbox" id="radio5" onClick="r5()" checked>
            </label>
        <form name="dateForm" method="POST">
            <label>Period: From
                <input class="dateSele" type="date" name="BeginDate" id="BeginDate" required value=<?php if($_REQUEST['BeginDate']){echo "'".$_REQUEST['BeginDate']."'";}else{if($_SESSION['start']!=""){echo "'".$_SESSION['start']."'";}else{echo "'".date("Y-m-d")."'";}} ?>>
                To
                <input class="dateSele" type="date" name="endDate" id="endDate" required value=<?php if($_REQUEST['endDate']){echo "'".$_REQUEST['endDate']."'";}else{if($_SESSION['end']!=""){echo "'".$_SESSION['end']."'";}else{echo "'".date("Y-m-d")."'";}} ?>>
            </label>
            <input class ="but" type="submit" name="dateSub" value="choose">
        </form>
        <?php
        if(isset($_REQUEST['dateSub'])){
            $_SESSION['start']=$_REQUEST['BeginDate'];
            $_SESSION['end']=$_REQUEST['endDate'];
        }
        ?>
    </div>
    <!-- expense part -->
    <div id="report">
        <div id="expCBoxTit">
            <p>Expenses</p>
        </div>
            <div id="expCBox">
                
        <form name="eBox" method="POST" >
            <label id="eBoxLab1" >
                By Category:
                <input type="checkbox" id="radio1" onClick="r1()" >
            </label>
            <label id="eBoxLab2">
                By Type:
                <input type="checkbox" onClick="r2()" id="radio2" checked>
            </label>
            <div id="typesSel">
                <select name="select1">
                    <option value="None">Select Category</option>
                    <?php
                    $sql="SELECT * From CategoryOfExpenses";
                    $result = mysqli_query($conn,$sql);
                    $result || die("Database access failed: ".mysqli_error($conn));
                    $categories=array();
                    $catesId=array();
                    $cateTot=array();
                    $index=0;
                    while($row = mysqli_fetch_row($result)){
                        $categories[$index]=$row[1];
                        $catesId[$index]=$row[0];
                        $index++;
                        echo"<option value='".$row[0]."'>".$row[1]."</option>";
                    }
                    ?>
                </select>
            </div>
            <input id="selBut" type="submit" class="but" name="ss" value="Choose" >
        </form>
    </div>
        <div id="cate" style="display:none">
            <div id="expTab">
            <table class="dataintable">
                <tr>
                    <th>Category</th>
                    <th>Expenses</th>
                    <th>Persentage</th>
                </tr>
            <?php
            $sql="SELECT * From CategoryOfExpenses";
            $result = mysqli_query($conn,$sql);
            $result || die("Database access failed: ".mysqli_error($conn));
            $categories=array();
            $catesId=array();
            $cateTot=array();
            $index=0;
            while($row = mysqli_fetch_row($result)){
                $categories[$index]=$row[1];
                $catesId[$index]=$row[0];
                $index++;
            }
            $finalCTot=0;
            for ($i=0;$i<$index;$i++){
                $sql="SELECT Expense_sum FROM Expenses WHERE User_Id=".$_SESSION['UserId']." AND CategoryExpense_id=".$catesId[$i]." AND Date_expenses BETWEEN '".$_SESSION['start']."' AND '".$_SESSION['end']."'";
                $result = mysqli_query($conn,$sql);
                $result || die("Database access failed: ".mysqli_error($conn));
                $rowcount=mysqli_num_rows($result);
                $total=0;
                if($rowcount>0){
                    while($row = mysqli_fetch_row($result)){
                        $total+=$row[0];
                    }
                }
                $cateTot[$i]=$total;
                $finalCTot+=$total;
            }
            $cafinalT=0;
            for ($i=0;$i<$index;$i++){
                if($finalCTot==0){
                    echo"<tr><td>".$categories[$i]."</td><td>".$cateTot[$i]."</td><td>0</td></tr>";
                }else{
                    echo"<tr><td>".$categories[$i]."</td><td>".$cateTot[$i]."</td><td>".round($cateTot[$i]/$finalCTot*100,0)."%</td></tr>";
                }
                $cafinalT+=$cateTot[$i];
            }
            echo "<tr><td></td><td>".$cafinalT."</td><td></td></tr>";
            ?>
            </table>    
        </div>
        <!-- category part -->
        <!-- doungt chart -->
            <div class="Chart1" id="Chart1">
            <canvas id="myChart1"></canvas>
            <script>
                var ctx = document.getElementById("myChart1").getContext('2d');
                var myChart1 = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        <?php
                        echo "labels:[";
                        for($i=0;$i<count($categories);$i++){
                            echo "'".$categories[$i]."',";
                        }
                        echo "],"
                        ?>
                        datasets: [{
                            label: 'Categories of expenses',
                            <?php
                            echo"data:[";
                            for($i=0;$i<count($categories);$i++){                       
                                    echo $cateTot[$i].",";                                                          
                            }
                            echo "],";
                            ?>
                            <?php
                                echo "backgroundColor:[";
                                for($i=0;$i<count($categories);$i++){
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$colors[$tmp]."',";
                                }
                                echo "],";
                            ?>
                            <?php

                                echo "borderColor:[";
                                for($i=0;$i<count($categories);$i++){                           
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$bColors[$tmp]."',";                                                                   
                                }
                                echo "],";
                            ?>
                            borderWidth: 1
                        }]
                    },                    options:{
                        title:{
                            display:true,
                            text:"Categories of expenses"
                        },
                    }
                    });
            </script>
        </div>
        <!-- bar chart -->
            <div class="Chart4" id="Chart4">
            <canvas id="myChart4"></canvas>
            <script>
                var ctx = document.getElementById("myChart4").getContext('2d');
                var myChart1 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        <?php
                        echo "labels:[";
                        for($i=0;$i<count($categories);$i++){
                            echo "'".$categories[$i]."',";
                        }
                        echo "],"
                        ?>
                        datasets: [{
                            label: 'Categories of expenses',
                            <?php
                            echo"data:[";
                            for($i=0;$i<count($categories);$i++){                       
                                    echo $cateTot[$i].",";                                                          
                            }
                            echo "],";
                            ?>
                            <?php

                                echo "backgroundColor:[";
                                for($i=0;$i<count($categories);$i++){
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$colors[$tmp]."',";
                                }
                                echo "],";
                            ?>
                            <?php

                                echo "borderColor:[";
                                for($i=0;$i<count($categories);$i++){                           
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$bColors[$tmp]."',";                                                                   
                                }
                                echo "],";
                            ?>
                            borderWidth: 1
                        }]
                    },
                    options:{
                        legend:{
                            display:false
                        },
                        title:{
                            display:true,
                            text:"Categories of expenses"
                        },
                    }
                    });
            </script>
        </div>
    </div>
<!-- type part -->
    <div id="ty">
            <div id="typeTab">
            <table class="dataintable">
                    <tr>
                    <th>Type</th>
                    <th>Expenses</th>
                    <th>Persentage</th>
                </tr>
            <?php
            $expTypeIDs=array();
            $expTypes=array();
            $typeTot=array();
            $tmpId=1;
            if(isset($_REQUEST['ss'])&&$_REQUEST['select1']!='None'){
                $tmpId=$_REQUEST['select1'];
            }
            $sql="SELECT * From ExpenseTypes WHERE CategoryExpense_id=".$tmpId;
            $result = mysqli_query($conn,$sql);
            $result || die("Database access failed: ".mysqli_error($conn));
            $index=0;
            while($row = mysqli_fetch_row($result)){
                $expTypeIDs[$index]=$row[0];
                $expTypes[$index]=$row[1];
                $index++;
            }
            $finalTTot=0;
            for ($i=0;$i<$index;$i++){
                $total=0;
                $sql="SELECT Expense_sum FROM Expenses WHERE User_Id=".$_SESSION['UserId']." AND ExpenseType_id=".$expTypeIDs[$i]." AND Date_expenses BETWEEN '".$_SESSION['start']."' AND '".$_SESSION['end']."'";
                $result = mysqli_query($conn,$sql);
                $result || die("Database access failed: ".mysqli_error($conn));
                $rowcount=mysqli_num_rows($result);
                if($rowcount>0){
                while($row = mysqli_fetch_row($result)) {
                        $total+=$row[0];
                    }
                }
                $typeTot[$i]=$total;
                $finalTTot+=$total;
                }
                $typefinalT=0;
                for ($i=0;$i<$index;$i++){
                if($finalTTot==0){
                    echo"<tr><td>".$expTypes[$i]."</td><td>".$typeTot[$i]."</td><td>0</td></tr>";
                }else{
                    echo"<tr><td>".$expTypes[$i]."</td><td>".$typeTot[$i]."</td><td>".round($typeTot[$i]/$finalTTot*100,0)."%</td></tr>";
                }
                $typefinalT+=$typeTot[$i];
            }
            echo"<tr><td></td><td>".$typefinalT."</td><td></td></tr>";
            ?>
            </table>
        </div>
        <!-- doungt chart -->
                <div class="Chart2" id="Chart2">
            <canvas id="myChart2"></canvas>
            <script>
                var ctx = document.getElementById("myChart2").getContext('2d');
                var myChart1 = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        <?php
                        echo "labels:[";
                        for($i=0;$i<count($expTypes);$i++){
                            echo "'".$expTypes[$i]."',";
                        }
                        echo "],"
                        ?>
                        datasets: [{
                            label: 'Types of expenses',
                            <?php
                            echo"data:[";
                            for($i=0;$i<count($expTypes);$i++){                             
                                    echo $typeTot[$i].",";                                                              
                            }
                            echo "],";
                            ?>
                            <?php
                                echo "backgroundColor:[";
                                for($i=0;$i<count($expTypes);$i++){
                                    
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$colors[$tmp]."',";                                                                
                                }
                                echo "],";
                            ?>
                            <?php
                                echo "borderColor:[";
                                for($i=0;$i<count($expTypes);$i++){                                 
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$bColors[$tmp]."',";                                                               
                                }
                                echo "],";
                            ?>
                            borderWidth: 1
                        }]
                    },                    options:{
                        title:{
                            display:true,
                            text:<?php if(isset($_REQUEST['select1'])){echo "'".$categories[$_REQUEST['select1']-1]."'";}else{
                                echo "'".$categories[0]."'";}?>
                        },
                    }
                    });
            </script>
        </div>
        <!-- bar chart -->
                        <div class="Chart5" id="Chart5">
            <canvas id="myChart5"></canvas>
            <script>
                var ctx = document.getElementById("myChart5").getContext('2d');
                var myChart1 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        <?php
                        echo "labels:[";
                        for($i=0;$i<count($expTypes);$i++){
                            echo "'".$expTypes[$i]."',";
                        }
                        echo "],"
                        ?>
                        datasets: [{
                            label: <?php if(isset($_REQUEST['select1'])){echo "'".$categories[$_REQUEST['select1']-1]."'";}else{
                                echo "'".$categories[0]."'";}?>,
                            <?php
                            echo"data:[";
                            for($i=0;$i<count($expTypes);$i++){                             
                                    echo $typeTot[$i].",";                                                              
                            }
                            echo "],";
                            ?>
                            <?php
                                echo "backgroundColor:[";
                                for($i=0;$i<count($expTypes);$i++){
                                    
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$colors[$tmp]."',";                                                                
                                }
                                echo "],";
                            ?>
                            <?php
                                echo "borderColor:[";
                                for($i=0;$i<count($expTypes);$i++){                                 
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$bColors[$tmp]."',";                                                               
                                }
                                echo "],";
                            ?>
                            borderWidth: 1
                        }]
                    },
                    options:{
                        legend:{
                            display:false
                        },
                        title:{
                            display:true,
                            text:<?php if(isset($_REQUEST['select1'])){echo "'".$categories[$_REQUEST['select1']-1]."'";}else{
                                echo "'".$categories[0]."'";}?>
                        },
                    }
                    });
            </script>
        </div>
    </div>
<!-- income part -->
    <div id="inTit">
        <p>Incomes</p>
    </div>
            <div id="inTab">
            <table class="dataintable">
                <tr>
                    <th>Type</th>
                    <th>Incomes</th>
                    <th>Persentage</th>
                </tr>
            <?php                
            $sql="SELECT * FROM IncomeType";
            $result = mysqli_query($conn,$sql);
            $result || die("Database access failed: ".mysqli_error($conn));
            $incomeType=array();
            $typeId=array();
            $incomeTot=array();
            $index=0;
            while($row = mysqli_fetch_row($result)){
                $typeId[$index]=$row[0];
                $incomeType[$index]=$row[1];
                $index++;
            }
            $finalITot=0;
            for($i=0;$i<$index;$i++){
                $sql="SELECT Income_sum FROM Incomes WHERE User_Id=".$_SESSION['UserId']." AND IncomeType_id=".$typeId[$i]." AND Date BETWEEN '".$_SESSION['start']."' AND '".$_SESSION['end']."'";
                $result = mysqli_query($conn,$sql);
                $result || die("Database access failed: ".mysqli_error($conn));
                $total=0;
                $rowcount=mysqli_num_rows($result);
                if($rowcount>0){
                    while($row = mysqli_fetch_row($result)) {
                        $total+=$row[0];
                    }
                }
                $incomeTot[$i]=$total;
                $finalITot+=$total;
            }
            $incomefinalT=0;
            for ($i=0;$i<$index;$i++){
                if($finalITot==0){
                    echo"<tr><td>".$incomeType[$i]."</td><td>".$incomeTot[$i]."</td><td>0</td></tr>";
                }else{
                    echo"<tr><td>".$incomeType[$i]."</td><td>".$incomeTot[$i]."</td><td>".round($incomeTot[$i]/$finalITot*100,0)."%</td></tr>";
                }
                $incomefinalT+=$incomeTot[$i];
            }
            echo"<tr><td></td><td>".$incomefinalT."</td><td></td></tr>";
            ?>
            </table>
        </div>
                <div class="Chart3" id="Chart3">
        <canvas id="myChart3"></canvas>
        <script>
                var ctx = document.getElementById("myChart3").getContext('2d');
                var myChart1 = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        <?php
                        echo "labels:[";
                        for($i=0;$i<count($incomeType);$i++){
                            echo "'".$incomeType[$i]."',";
                        }
                        echo "],"
                        ?>
                        datasets: [{
                            label: 'Types of incomes',
                            <?php
                            echo"data:[";
                            for($i=0;$i<count($incomeType);$i++){                           
                                    echo $incomeTot[$i].",";                                                            
                            }
                            echo "],";
                            ?>
                            <?php
                                echo "backgroundColor:[";
                                for($i=0;$i<count($incomeType);$i++){
                                    
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$colors[$tmp]."',";                                                                
                                }
                                echo "],";
                            ?>
                            <?php
                                echo "borderColor:[";
                                for($i=0;$i<count($incomeType);$i++){                                   
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$bColors[$tmp]."',";                                                               
                                }
                                echo "],";
                            ?>
                            borderWidth: 1
                        }]
                    },                    options:{
                        title:{
                            display:true,
                            text:"Types of Incomes"
                        },
                    }
                    });
        </script>
        </div>
                        <div class="Chart6" id="Chart6">
        <canvas id="myChart6"></canvas>
        <script>
                var ctx = document.getElementById("myChart6").getContext('2d');
                var myChart1 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        <?php
                        echo "labels:[";
                        for($i=0;$i<count($incomeType);$i++){
                            echo "'".$incomeType[$i]."',";
                        }
                        echo "],"
                        ?>
                        datasets: [{
                            label: 'Types of incomes',
                            <?php
                            echo"data:[";
                            for($i=0;$i<count($incomeType);$i++){                           
                                    echo $incomeTot[$i].",";                                                            
                            }
                            echo "],";
                            ?>
                            <?php
                                echo "backgroundColor:[";
                                for($i=0;$i<count($incomeType);$i++){
                                    
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$colors[$tmp]."',";                                                                
                                }
                                echo "],";
                            ?>
                            <?php
                                echo "borderColor:[";
                                for($i=0;$i<count($incomeType);$i++){                                   
                                        $tmp=$i;
                                        if($tmp==6){
                                            $tmp=0;
                                        }
                                        echo "'".$bColors[$tmp]."',";                                                               
                                }
                                echo "],";
                            ?>
                            borderWidth: 1
                        }]
                    },
                    options:{
                        legend:{
                            display:false
                        },
                        title:{
                            display:true,
                            text:"Types of Incomes"
                        },
                    }
                    });
        </script>
        </div>
    </div>







</body>
</html>