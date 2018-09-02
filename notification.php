<?php
session_start();
include "addNoti.php";
include "model.php";
require_once('connection.php');
$conn = mysqli_connect($servername, $username_d, $password, $dbname);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/notiStyle.css">
	<!-- function for user information -->
</head>
<body>
	<!-- notification table -->
	<div id="subtitle">
		<p>Notifications</p>
	</div>

	<div id="tabTit">
		<table class="dataintable">
			<tr>
			<th>Name of notification </th>
    		<th>Date of notification </th>
    		<th>Type of notification</th>
    		<th>Edit</th>
    		<th>Delete</th>
    		</tr>
		</table>
	</div>

	<div id="notiTab">
		<?php
		$delete=isset($_GET["delete"]) && !empty($_GET["delete"]) && !is_null($_GET["delete"]);
   		if ($delete){
   		$sql = "delete FROM  Notification where Notification_id=".$_GET["delete"];
   
   		$result = $conn->query($sql);    
   		}
   		$sql = "SELECT u.User_email,n.Notification_id,n.Notification_date,n.Notification_info, n.Notification_type  FROM  Notification n INNER JOIN  User u ON n.User_id = u.User_id where u.User_id=".$_SESSION['UserId'];  
    	$result = $conn->query($sql);
		?>
		<table class="dataintable">
  <tbody>
  <?php
  while ($row = $result->fetch_row()){
    
    ?>  
    
    <tr>
      </td>
      <td><?php echo $row[3]; ?></td>
      <td><?php echo $row[2]; ?></td>
      <td>
  <?php if ($row[4]=="1") {echo "monthly";} ?>
<?php if ($row[4]=="2") {echo "quarterly";} ?>
<?php if ($row[4]=="3") {echo "weekly";} ?>
  </td>
      <td><?php echo "<a href='notiEdit.php?nId=".$row[1]."'>Edit</a>"; ?></td>
      <td><?php echo "<a href='delete.php?delete=NotiD&deleteId=".$row[1]."'>Delete</a>"; ?></td>
    </tr>
    <?php }  $conn->close();?>
  </tbody>
</table>
<button class="but" onclick="addNoti()">Add Notification</button>
	</div>
</body>
</html>