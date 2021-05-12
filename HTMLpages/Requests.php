<?php
	include('../config/connectDB.php');
	session_start();
	$college_id = '';
	$error = '';
	//print_r($_GET);
	$flipped_get = array_flip($_GET);
	//echo "<br>";
	//print_r($flipped_get);
	if(isset($flipped_get['Accept']))
	{
		//echo $flipped_get['Accept'];
		$college_id = mysqli_real_escape_string($conn, $flipped_get['Accept']);
		$sql = "update member set verification_status=1 where college_id = '$college_id'";
		if(mysqli_query($conn, $sql))
		{
			//echo "entry altered <br>";
		}
		else 
		{
	  		echo "error altering values: " . mysqli_error($conn) . "<br />";
		}
	}
	if(isset($flipped_get['Reject']))
	{	
		//echo $flipped_get['Reject'];
		$college_id = mysqli_real_escape_string($conn, $flipped_get['Reject']);
		$sql = "delete from member where college_id='$college_id'";
		if(mysqli_query($conn, $sql))
		{
			//echo "entry deleted <br>";
		}
		else 
		{
	  		echo "error deleting values: " . mysqli_error($conn) . "<br />";
		}
	}
	//echo $_SESSION['college_id'];
	$sql = '';
	if($_SESSION['college_id']=='library')
		$sql = "select name,phone,email,designation,college_id from member where verification_status = 0 order by designation";
	else
		$sql = "select name,phone,email,designation,college_id from member where verification_status = 0 and designation!='admin' order by designation";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)>0)
	{
		$users = mysqli_fetch_all($result);
	}
	else
	{
		$error = "No user Requests";
	}
	//print_r($users);
	//echo "<br> $error <br>";
	$college_id = '';
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Pending Requests Page</title>
		<link rel="stylesheet"  href="../CSS/styles.css">
	</head>
 <body>
 	<nav id="main-navigation">
                <ul>
                	<li><a href = "Myprofile.php" >My profile</a> </li>
                    <li><a href = "userhomepage.php"> Back</a></li>

                </ul>
                </nav>  

 
 <form action="Requests.php" method="GET">
	 <table class = "tables">
	 	<?php 
		 	if($error=='')
		 	{
		 ?>
		 <tr>
		 	<th> Name </th>
		 	<th> Phone </th>
		 	<th> Email </th>
		 	<th> Designation </th>
		 	<th> College ID </th>
		 </tr>
		 <?php
			 	foreach($users as $user)
			 	{
			 		echo "<tr>";
			 		foreach($user as $user_data)
			 		{
			 			echo "<td>$user_data</td>";
			 		}
		 ?>
		 	<td>
		 		<!-- <input type="hidden" name="id_to_delete" value = "<?php //echo $user[4]?>"> -->
		 		<input type="submit" name="<?php echo $user[4]?>" value="Accept">
		 	</td>
		 	<td>
		 		<input type="submit" name="<?php echo $user[4]?>" value="Reject">
		 	</td>
		 <?php
		 			echo "</tr>";
		 		/*echo "<td>$user[0]</td>";
		 		echo "<td>$user[1]</td>";
		 		echo "<td>$user[2]</td>";
		 		echo "<td>$user[3]</td>";*/
		 		}
		 	}
		 	else
		 		echo "<td>$error</td>";
		 ?>
	</table>
</form>
 	
</body>