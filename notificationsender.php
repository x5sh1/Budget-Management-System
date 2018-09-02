<?php
// error_reporting(E_ALL | E_WARNING | E_NOTICE);
// ini_set('display_errors', TRUE);
// flush();

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
require_once('connection.php');
$conn = new mysqli($servername, $username_d, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
   } 
   
   $sql = "SELECT u.User_email,n.Notification_date,n.Notification_info, n.Notification_type,n.Notification_id  FROM  Notification n INNER JOIN  User u ON n.User_id = u.User_id ";
   
   $result = $conn->query($sql);
   if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    
 }
 
 while ($row = $result->fetch_row()){
    $date = strtotime($row[1]);
     $currentDate=strtotime(date('Y-m-d'));     
     if ($date<=$currentDate){        
        if ($row[3]==='1')
        $notificationBeginDate=date('Y-m-d', strtotime("+30 days"));
        if ($row[3]==='2')
        $notificationBeginDate=date('Y-m-d', strtotime("+91 days"));
        if ($row[3]==='3')
        $notificationBeginDate=date('Y-m-d', strtotime("+7 days"));
  $mail->Subject =$row[2];
  $mail->Body = $row[2]." - next will be ".$notificationBeginDate;
  $mail->AddAddress($row[0]);
  try {
  if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
  echo $row[0]." - Message has been sent";
  }
   $conn->query("update Notification set Notification_date='".$notificationBeginDate."' where Notification_id=".$row[4]);
       }
   catch(Exception $e) {
       
     echo 'Message: ' .$e->getMessage();
  }
   
 }
}


   

?>
