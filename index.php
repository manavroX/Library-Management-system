<?php
	//echo "hello world";
	include('config/connectDB.php');
	//echo 'included';
	$error = '';
	$college_id = '';
	if(isset($_POST['college_id']))
	{
		$error = '';
		$college_id = mysqli_real_escape_string($conn, $_POST['college_id']);
		$passwordEntered = mysqli_real_escape_string($conn, $_POST['password']);


		//echo "mem id = $college_id entered password = $passwordEntered";
		$sql = "SELECT password FROM member where college_id = '$college_id' and verification_status = 1";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0)
		{
			$passwordActual = mysqli_fetch_assoc($result);
			if($passwordActual['password']===$passwordEntered)
			{
				session_start();
				$_SESSION['college_id'] = $college_id;
				header('Location: HTMLpages/userhomepage.php');
			}
			else
			{
				$error = "Incorrect password";
			}
		}
		else
		{
			$error = "No such user exists";
		}
		mysqli_free_result($result);
	}
	mysqli_close($conn);
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<title>Welcome to our Library Management System</title>
		<link rel="stylesheet"  href="CSS/index_style.css">
		<style>
		body{
  margin: 0;
  padding: 0;
  font-family: sans-serif;
  background: url(images/bg.jpg) no-repeat; 
background-size: cover;
}
</style>
	</head>
	<body>
		<div class = "login-box">
			<h1>Login</h1>
			<form action="index.php" method = "POST">
				<div class = "textbox">
					<input type = "text" placeholder = "Username" name = "college_id" value = "<?php echo $college_id; ?>">
				</div>

				<div class = "textbox">
				 	<input type = "password" placeholder = "Password" name = "password" value = "">
				</div>

				<input class = "buttons" type = "submit" name = "sign_in" value = "Sign in">
			</form>
			<div onclick="location.href='HTMLpages/Signup.php';" style="cursor: pointer;">
				<button class = "buttons">Sign up</button>
			</div>
			 <!--Diya or Ojashvi, please make this text red in color-->
			<div class = "red_text"><?php echo $error ?></div>
			
		</div>

		<!--<a href="HTMLpages/userhomepage.php"> <button class = "buttons"> Go to home page </button></a>-->
		
		
	</body>
</html>
