<?php
	session_start();
	$college_id = $_SESSION['college_id'];
	

	include('../config/connectDB.php');
	$sql101 = "SELECT name from member where college_id='$college_id' ";
	$result101 = mysqli_query($conn, $sql101);
	$inf101 = mysqli_fetch_assoc($result101);
	$name = $inf101['name'];
	mysqli_free_result($result101);
      $today;
	  $sql1 = "SELECT CURRENT_DATE AS Date ";
	$result = mysqli_query($conn, $sql1);
	$inf = mysqli_fetch_assoc($result);
	$today = $inf['Date'];
	mysqli_free_result($result);

    $sql01 = "SELECT due_date from record,member where record.due_date < '$today' and record.issued_by=member.mem_id and member.college_id='$college_id'and return_date is NULL ";
    $amt =0;
    $result01 = mysqli_query($conn, $sql01);
			if(mysqli_num_rows($result01) > 0)
			{
				$finerecord = mysqli_fetch_all($result01);
				foreach($finerecord as $fine):
					$d1 = new DateTime($today);
                    $d2 = new DateTime($fine[0]);
                    $d  = $d1->diff($d2)->format('%a');

					$amt=$amt+(10*$d );
					
				endforeach;
					
          }

     $sql22 = "UPDATE member set fine_due='$amt' where college_id='$college_id' ";
	    mysqli_query($conn, $sql22);
	    


	$sql = "SELECT designation FROM member where college_id = '$college_id'";
	$result = mysqli_query($conn, $sql);
	$homeButtons = array();
	if(mysqli_num_rows($result) > 0)
	{
		$designation = mysqli_fetch_assoc($result);
		if($designation['designation']==='student'||$designation['designation']==='teacher'||$designation['designation']==='non_teacher')
		{
			$homeButtons = [
							['Search Books','BookSearchPage.php'],
							['My Profile','MyProfile.php'],
							['My History','History.php'],
							['Book Recommender','Recommender.php']
							];
		}
		else
		{
			$homeButtons = [
								['Search Books','BookSearchPage.php'],
								['My Profile','MyProfile.php'],
								['My History','History.php'],
								['Book Recommender','Recommender.php'],
								['Return Book','Return.php'],
								['Pending Requests','Requests.php'],
								['Search User','SearchStudent.php'],
								['Add a new Book','addNewBook.php'],
								['All History','allHistory.php']
								];
		}
		//print_r($homeButtons);
	}
	else
	{
		$error = "Error, please login again";
		header('Location: ../index.php');
	}
	mysqli_free_result($result);
	mysqli_close($conn);
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>User Home Page</title>
		<link rel="stylesheet"  href="../CSS/home.css">
	</head>
	<body>
		
		<div class = "background">
			<div class = "blur">
		<nav id="main-navigation">
                <ul>
                	<li><a href ="../index.php">LOG OUT</a></li>
                   
                </ul>
                </nav>
		<table>
			<tr>
				<h3 style = "margin-left: 100px; color:white;">Hello
			<?php
			echo $name;
				for($i=0;$i<count($homeButtons);$i++):
			?>
		</h3>

			<?php
				if(($i>0)&&($i%3==0))
				{
					echo "</tr>";
					echo "<tr>";
				}
			?>
				    
					<td width = "25%">
						<div class="homebuttons">
							<div class = "btns">
						<a href = "<?php echo $homeButtons[$i][1]; ?>">
							
								<?php echo $homeButtons[$i][0]; ?>
							
							
						</a>
					</div>
					</div>
					</td>
					
				<?php endfor; ?>
			</tr>
				<!--<?php //echo "</tr>"; ?>-->
		<!--<tr>
				<td> <a href = "BookSearchPage.php"> <button class = "buttons">  Search Books </button></a></td>		
			<td> <a href = "MyProfile.php" ><button class = "buttons">  My profile </button> </a> </td>
			<td> <a href = "History.php"> <button class = "buttons"> My History  </button></a></td>
			</tr>

		<tr>
			<td> <a href = "Clubs.php"> <button class = "buttons"> My Clubs  </button></a></td>
			<td> <a href = "Recommender.php"> <button class = "buttons"> Book Recommender  </button></a></td>
			<td> <a href = "Return.php"> <button class = "buttons"> Return Book </button></a></td>
        </tr>

        <tr>
        	<td> <a href = "remove.php"> <button class = "buttons"> Remove User </button></a></td>
        	<td> <a href = "Requests.php"> <button class = "buttons"> Pending Requests</button></a></td>
        	<td> <a href = "SearchStudent.php"> <button class = "buttons"> Search Student  </button></a></td>
        	<td> <a href = "add.php"> <button class = "buttons"> Add new book </button></a></td>
        </tr>-->

    </table>
</div>
   </div>
	</body>
	</html>		
