<?php 
	include('../config/connectDB.php');
	$error = '';
	$name = '';
	$college_id = '';
	$email = '';
	$contact = '';
	$new_password = '';
	$retype_password = '';
	$designation = '';
	if(isset($_POST['register']))
	{
		if(isset($_POST['name'])&&isset($_POST['college_id']) && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['new_password']) && isset($_POST['retype_password']) && isset($_POST['designation']))
		{
			$name = mysqli_real_escape_string($conn, $_POST['name']);
			$college_id = mysqli_real_escape_string($conn, $_POST['college_id']);
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$contact = mysqli_real_escape_string($conn, $_POST['contact']);
			$new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
			$retype_password = mysqli_real_escape_string($conn, $_POST['retype_password']);
			$designation = mysqli_real_escape_string($conn, $_POST['designation']);
			if(!($new_password===$retype_password))
			{
				$error = "Both passwords Don't match";
			}
			else
			{
				if(!preg_match('/^20[0-9]{2}[A-Z0-9]{2}PS[0-9]{4}H$/',$college_id))
					$error = 'wrong college id';
				if(!filter_var($email,FILTER_VALIDATE_EMAIL))
					$error = "Email id is in incorrect format";
				if(!preg_match('/^[0-9]{10}$/', $contact))
					$error = "Wrong phone number";
				if($error=='')
				{
					$sql = "SELECT college_id,email,phone from member where college_id = '$college_id'";
					$result = mysqli_query($conn, $sql);
					if(mysqli_num_rows($result)==0)
					{
						mysqli_free_result($result);
						$sql = "SELECT college_id,email,phone from member where email = '$email'";
						$result = mysqli_query($conn, $sql);
						if(mysqli_num_rows($result)==0)
						{
							mysqli_free_result($result);
							$sql = "SELECT college_id,email,phone from member where phone = '$contact'";
							$result = mysqli_query($conn, $sql);
							if(mysqli_num_rows($result)==0)
							{
								mysqli_free_result($result);
								$sql = "insert into member(name,phone,email,designation,fine_due,college_id,password,verification_status) values('$name','$contact','$email','$designation',0,'$college_id','$new_password',0)";
								if (mysqli_query($conn, $sql)) {
								  	header('Location: ../index.php');
								} else {
								  	echo "error instering values: " . mysqli_error($conn) . "<br />";
								}
								//echo $sql;
							}
							else
								$error = 'phone number already in use';
						}
						else
							$error = 'Email id already in use';
						
					}
					else
					{
						$error = "User has already registered";
					}
					
				}				
			}
		}
		else
		{
			$error = 'Please Fill all Fields';
		}
		//echo "$error <br>";
		//echo "$name $college_id $email $contact $new_password $retype_password $designation <br>";
	}
	

	mysqli_close($conn);
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Sign Up Page</title>
		<link rel="stylesheet"  href="../CSS/styles.css">
	</head>
	<body>
		<nav id="main-navigation">
                <ul>
                	<li><a href ="../index.php"> Back </a></li>
                   
                </ul>
                </nav>  
		
		<form action="Signup.php" method = "POST">
		<table style= "margin-left: 20%">
			<tr>
				<td>Name</td>
				<td><div class = "textbox">
					 	<input type = "text"  name = "name" value = "<?php echo htmlspecialchars($name);?>">
					</div>
				</td>
			</tr>
			<tr>
				<td>College ID</td>
				<td><div class = "textbox">
					 	<input type = "text"  name = "college_id" value = "<?php echo htmlspecialchars($college_id);?>">
					</div>
				</td>
			</tr>
			<tr>
				<td>Email id</td>
				<td>
					<div class = "textbox">
					 	<input type = "text"  name = "email"  value = "<?php echo htmlspecialchars($email);?>">
					</div>
				</td>
			</tr>
			<tr>
				<td>Contact no.</td>
				<td>
					<div class = "textbox">
					 	<input type = "text" name = "contact"  value = "<?php echo htmlspecialchars($contact);?>">
					</div>
				</td>
			</tr>
			<tr>
				<td>Set Password</td>
				<td>
					<div class = "textbox">
					 	<input type = "password"  name = "new_password">
					</div>
				</td>
			</tr>
			<tr>
				<td>Retype Password</td>
				<td>
					<div class = "textbox">
					 	<input type = "password"  name = "retype_password">
					</div>
				</td>
			</tr>
			<tr>
				<td>Designation</td>
				<td>
					<div class = "textbox">
					 	<input type="radio" id="student" name="designation" value="student">
							<label for="student">Student</label>
						<input type="radio" id="teacher" name="designation" value="teacher">
							<label for="teacher">Teacher</label>
						<input type="radio" id="non_teacher" name="designation" value="non_teacher">
							<label for="non_teacher">Non Teacher</label>
						<input type="radio" id="admin" name="designation" value="admin">
							<label for="admin">Admin</label>
					</div>
				</td>
			</tr>
			<tr>
				<td> <input type="submit" name="register" class = "buttons" value="Register"></td>
			</tr>
			<tr>
				<td><div class="red_text"><?php echo htmlspecialchars($error);?></td>
			</tr>
		</table>

	</form>

	</body>