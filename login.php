<?php
 error_reporting(E_ERROR  | E_PARSE);
 $email = $userpassword  = "";
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = test_input($_POST["email"]);
  $userpassword = test_input($_POST["password"]);
}
else {
 die ("Error you tried to use Get Mehod. The post method is only acceptable!");
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$servername = "127.0.0.1";
$username = "root";
$password = "hs20131312";
$dbname = "csci6221";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT  User_phone,User_id, User_name,User_email,User_password FROM User where User_email='".$email."' and User_password='".$userpassword."'";
$result = $conn->query($sql);

if ($result->num_rows<1) {
    echo "Password or email is not correct! <br/><a href='index.php'>Back</a> :";
} else
 {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "User_id : " . $row["User_id"]. " - User_name : " . $row["User_name"]. " User_phone:" . $row["User_phone"]. "<br> You successfully logged in!";
        
        echo "<form id='formid' method='POST' action='budget.php'>
              <input type='text' name='usrId' value='".$row["User_id"]."'>
              </form>
              <script type='text/javascript'>
              document.getElementById('formid').submit();
              </script>";
    }
} 
$conn->close();
?>