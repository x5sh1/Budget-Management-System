<?php
session_start();
$nId=$_GET['nId'];
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql="SELECT * FROM Notification WHERE Notification_id=".$nId;
$result = mysqli_query($conn,$sql);
$result || die("Database access failed: ".mysqli_error($conn));
$row = mysqli_fetch_row($result);
?>
<!-- notification edit -->
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/addWebs.css">
  <link rel="stylesheet" href="css/notiEdit.css">
</head>
<body>
  <div id="notiEdit">
    <p>Notification Edit</p>
    <hr id="hr1"/>
    <form name="form1" method="POST">
      <label id="lab1">
        Name:
        <input type="text" name="text1" value=<?php echo "'".$row[1]."'";?> required>
      </label>
        <label id="lab2">Date of notification:
          <input type="date" name="Date" id="notificationBeginDate" value=<?php echo "'".$row[2]."'";?> required >  
        </label>
        <label id="lab3">
          Type:
          <select name="select1">
            <option value="1" <?php if ($row[4]==1) {echo "selected";} ?>>monthly  </option>
            <option value="2" <?php if ($row[4]==2) {echo "selected";} ?>>quarterly </option>
            <option value="3" <?php if ($row[4]==3) {echo "selected";} ?>>weekly</option>  
          </select>
        </label>
        <hr id="hr2"/>
            <input id ="create" class="addBut" type="submit" name="submit" value="Submit" />
    </form>
    <button id ="cancel" class="addBut" name="cancel" onclick="window.location.href='notification.php'">Cancel</button>
  </div>
</body>
</html>
<?php
if(isset($_REQUEST['submit'])){
$sql="UPDATE NOTIFICATION SET Notification_info='".$_REQUEST['text1']."',Notification_date='".$_REQUEST['Date']."',Notification_type=".$_REQUEST['select1']." WHERE Notification_id=".$nId;
    $result = mysqli_query($conn,$sql);
    $result || die("Database access failed: ".mysqli_error($conn));
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
   $mail->Subject ="Notification: ".$row[1]." was changed to ".$_REQUEST['text1'];
   $mail->Body = $_REQUEST['text1']." - starting from ".$_REQUEST['Date'];
   echo $_SESSION['mail'];
   $usrId=$row[3];
   $sql3="SELECT User_email FROM User WHERE User_id=".$usrId;
   $result3 = mysqli_query($conn,$sql3);
   $result3 || die("Database access failed: ".mysqli_error($conn));
   $row3 = mysqli_fetch_row($result3);
   $mail->AddAddress($row3[0]);

 if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
 } else {

    echo "Message has been sent";
 }
   }catch(Exception $e) {
          
        echo 'Message: ' .$e->getMessage();
      }
    

     // header("Location: notiEdit.php");
}
?>