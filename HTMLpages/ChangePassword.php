<?php 
session_start();
	$college_id = $_SESSION['college_id'];

include('../config/connectDB.php');
$sql1="select password from member where college_id='$college_id'";
$result1=mysqli_query($conn, $sql1);
$fetchedpassword = mysqli_fetch_row($result1);


if(isset($_POST['change']))
{
	$old = mysqli_real_escape_string($conn, $_POST['OldPassword']);
	$new = mysqli_real_escape_string($conn, $_POST['NewPassword']);
	$renew = mysqli_real_escape_string($conn, $_POST['ReNewPassword']);
	if($fetchedpassword[0] != $old)
	{
		echo "you have entered wrong current password";
	}
	else if($new==$renew)
	{
		    $sql="update member set password='$new' where college_id='$college_id' and password='$old'";
		    $result = mysqli_query($conn, $sql);
		    echo "password changed successfully";
	}
	else
	{
		echo "new password and confirm password doesn't match";
	}
	


}

 ?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>User Home Page</title>
		<link rel="stylesheet"  href="../CSS/styles.css">
	</head>
	<body>
		<nav id="main-navigation">
                <ul>
                	<li>
		 <a href ="Myprofile.php"> Back </a></li></ul></nav>

		 <table style ="  background-image: linear-gradient(to bottom, #edf2f9, #d1def4, #b7cbef, #9fb6e9, #8aa2e3);
    background-size: all;
    background-repeat: no-repeat;
    background-attachment: fixed; 
    padding-left: 35%;
    margin-top: 5%;"
    
    >

		<form action="ChangePassword.php" method="POST">
		
			<tr>
				<td>Enter current Password: </td>
				<td><div class = "textbox">
		 	<input type = "password" placeholder = "Old Password" name = "OldPassword" >
		 </div></td>
			</tr>
			<tr>
				<td>Enter new Password: </td>
				<td>
					<div class = "textbox">
		 	<input type = "password" placeholder = "New Password" name = "NewPassword" >
		 </div>
				</td>
			</tr>
			<tr>
				<td>Confirm new Password: </td>
				<td>
					<div class = "textbox">
		 	<input type = "password" placeholder = "New Password" name = "ReNewPassword" >
		 </div>
				</td>
			</tr>
		<tr><td>
		<input type="submit" name="change" class = "buttons" value="SUBMIT"></td></tr>
   </form>
</table>
		

	</body>