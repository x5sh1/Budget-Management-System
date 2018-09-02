<?php
error_reporting(E_ERROR  | E_PARSE);
 $email = $userpassword  =$userphone=$username= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = test_input($_POST["email"]);
  $userpassword = test_input($_POST["password"]);
  $username = test_input($_POST["username"]);
  $userphone = test_input($_POST["userphone"]);
  $currency=test_input($_POST["currency"]);
}
else {
 die ("Error you tried to use Get Mehod. The post method is only acceptable!  <br/><a href='/'>Back</a>");
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$servername = "127.0.0.1";
$username_d = "root";
$password = "hs20131312";
$dbname = "csci6221";

// Create connection
$conn = new mysqli($servername, $username_d, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT User_id, User_name, User_phone,User_email,User_password FROM User where User_email='".$email."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    die("User exists!");
} 
$sql = "insert into User ( User_name, User_phone,User_email,User_password,Currency_id) values('".$username."','".$userphone."','".$email."','".$userpassword."','".$currency."')";
$result = $conn->query($sql);

if ($result==TRUE) {
    echo "New User created successfully!  <br/><a href='index.php'>Back</a>";
    echo"<script>window.location.href='index.php?creat=1';</script>";
} else {
    echo "Password or email is not correct!  <br/><a href='/'>Back</a> ".$sql." ".$result;
}
$conn->close();
?>