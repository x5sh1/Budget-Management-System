<?php
 session_start();
 $errorMsg = "";

 $validUser = isset($_SESSION["User_id"]) && !empty($_SESSION["User_id"]) && !is_null($_SESSION["User_id"]);
 // if(!$validUser) $errorMsg = "Unauthorized!";
 // if($validUser) {    
 // } else{
 //     echo  $errorMsg." <br/><a href='/'>Back</a>";die();
 // } 
if (isset($_REQUEST['create'])) {
  echo"<script>window.location.href='notification.php';</script>";
    try {
        
require_once('lib/phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "kz.tempn@gmail.com";
$mail->Password = "corn53Uni";
$mail->SetFrom("kz.tempn@gmail.com");


$notificationName =$notificationBeginDate =$notificationEndDate= "";
  $notificationName = $_POST["notificationName"];
  $notificationBeginDate = $_POST["notificationBeginDate"];
  
  $notificationType=$_POST["notificationType"];
  require_once('connection.php');
//   $servername = "mysql41.cp.idhost.kz";
//   $username_d = "u1157054_sapar";
//   $password = "corn53Uni";
//   $dbname = "db1157054_sapar";
//   $maxCount=0;
//   // Create connection
  
  $conn = new mysqli($servername, $username_d, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
   } 
  //  echo "edit=".$_POST["edit"];
   $edit = isset($_POST["edit"]) && !empty($_POST["edit"]) && !is_null($_POST["edit"]);
 if ($edit){
  $sql = "update Notification set  Notification_info='".$notificationName."',Notification_date='".$notificationBeginDate."',Notification_type=".$notificationType." where Notification_id=".$_POST["edit"];
  $result = $conn->query($sql);    
 } else {  
   // $sql = "SELECT  User_id,User_email FROM Users where User_id = '".$_SESSION["User_id"]."'";
     $sql = "SELECT  User_id,User_email FROM User where User_id =".$_SESSION['UserId'];

 //  echo $sql;
   $result = $conn->query($sql);
   if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
 }
 $row = $result->fetch_row();
    
 // $sql = "insert into Notification (  Notification_info,Notification_date,User_id,Notification_type) values('".$notificationName."','".$notificationBeginDate."','".$row[0]."',".$notificationType.")";
 $sql = "insert into Notification (  Notification_info,Notification_date,User_id,Notification_type) values('".$notificationName."','".$notificationBeginDate."',".$_SESSION['UserId'].",".$notificationType.")";
   $result = $conn->query($sql); 
 
   $conn->close();
   $mail->Subject ="Notification: ".$notificationName." was created";
   $mail->Body = $notificationName." - starting from ".$notificationBeginDate;
   $mail->AddAddress($row[1]);

 if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
 } else {

    echo "Message has been sent";
 }
   }
          }
      catch(Exception $e) {
          
        echo 'Message: ' .$e->getMessage();
      }
    
      if ($result==TRUE) {
        die( "<br><br>Process is successfully completed  <br/><a href='notificationlist.php'>Back</a>");
     } else {
        die( "<br>Notification is not correct!  <br/><a href='/'>Back</a> ".$sql." ".$result);
     }

     // header("Location: notificationlist.php");
} 
// else {
//   $edit = isset($_SESSION["edit"]) && !empty($_SESSION["edit"]) && !is_null($_SESSION["edit"]);   
//   if ($edit){

//   }
//}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/addWebs.css">
  <link rel="stylesheet" href="css/addNoti.css">
</head>
<body>

<div id="addNoti">
  <hr id="hr1"/>
   <p>Add Notification</p>
  <form  method="post">
  <?php echo '<input type="hidden" id="edit" name="edit" value="'.$_GET["edit"].'">' ?> 
  <label id="lab1">Notification name
    
  <input type="text" name="notificationName" id="notificationName" required >
  </label>
  <label id="lab2">Beginning date of notification 
  <input type="date" name="notificationBeginDate" id="notificationBeginDate" required value=<?php echo "'".date("Y-m-d")."'"; ?>>  
  <!-- <div class="form-gr">
  <label for="notificationDate">Beginning date of notification 
    </label><input type="date" name="notificationEndDate" id="notificationEndDate" required>  
  </div> -->
   </label>
    <label id="lab3">Type of notification
    
  <select id="notificationType" name="notificationType" required>
  <option value="1" <?php if ($_GET["notificationType"]==1) {echo "selected";} ?>>monthly  </option>
  <option value="2" <?php if ($_GET["notificationType"]==2) {echo "selected";} ?>>quarterly </option>
  <option value="3" <?php if ($_GET["notificationType"]==3) {echo "selected";} ?>>weekly</option>  
 </select>
 </label> 
 <hr id="hr2"/>
 <input id="create" type="submit" class="addBut" name="create" value="Create">
   
    </form>
    <button id="cancel" class="addBut" onclick="window.location.href='notification.php'"> Cancel</button>
</div>
</body>
</html>