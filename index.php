<?php
session_start();
$isRe=$_GET['creat'];
$_SESSION['start']="";
$_SESSION['end']="";
?>
<html>
<head>
  <style type="text/css">
    #title{
      position: relative;
      top:0px;
      left: 35%;

    }
    #p1{
      font-size: 30px;
      color: #FFF;

    }
      select {
      border: solid 1px #000;
            background: #EEF9FE;
            height: 100%;
            width: 100%;
            font-size: 15px;
            padding-right: 14px;
            font-family: 'Lato', sans-serif;
        }
  </style>
    <meta charset="UTF-8">
    <title>Login & Sign Up Interface</title>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
        <link rel="stylesheet" href="css/style.css">
  </head>
<body>
    <div id="title">
      <p id="p1">Family Budget Management Service</p>
      <?php
      if($isRe){
        echo"<p>New user is created successfully!</p>";
      }
      ?>
    </div>
    <div class="panel">
        <ul class="panel__menu" id="menu">
          <hr/>
          <li id="signIn"> <a href="#">Login</a></li>
          <li id="signUp"><a href="#">Sign up</a></li>
        </ul>
        <div class="panel__wrap">
            
          <div class="panel__box active" id="signInBox">
                <form action="login.php" method="POST">
            <label>Email
              <input type="email" name="email" id="email" required/>
            </label>
            <label>Password
              <input type="password" name="password" id="password" required/>
            </label>
            <input type="submit"/>
            </form>
          </div>
        
        
          <div class="panel__box" id="signUpBox">
        <form action="register.php" method="POST">
            <label>Email*
              <input type="email" name="email" id="email" required/>
            </label>
            <label>User name*
                    <input type="text" name="username" id="username" required/>
            </label>
            <label>User phone*
                    <input type="text" name="userphone" id="userphone" required/>
            </label>
            <label>Password*
              <input type="password"  name="password" id="password" required/>
            </label>
            <label>Confirm password*
              <input type="password"  name="confirmpassword" id="confirmpassword" required/>
            </label>
            <label>Courrency*
              <select name="currency" id="currency" required>
                <option value="None">Select Currency</option>
                <?php
                        $servername = "127.0.0.1";
                        $username = "root";
                        $password = "hs20131312";
                        $db_database = "csci6221";
                        $conn = mysqli_connect($servername, $username, $password,$db_database);
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                        $query="SELECT * FROM CurrencyType";
                        $result = mysqli_query($conn,$query);
                        $result || die("Database access failed: ".mysqli_error($conn));
                        while($row = mysqli_fetch_row($result)){
                          echo"<option value='".$row[0]."'>".$row[1]."</option>";
                        }
                ?>
              </select>  
            </label>
            <input type="submit" required/>
        </form>
          </div>        
        </div>
      </div>
            
      <script  src="js/index.js"></script>
      



<form method="POST" action="budget.php">
  <input type="text" name="usrId" hidden="true">
</form>






</body>

</html>