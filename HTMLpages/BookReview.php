<?php 

session_start();
	$accession_id = $_SESSION['accession_id'];
	include('../config/connectDB.php');
   $sql1 = "select r.gr_no,b.name from record r,book b where r.accession_id='$accession_id' and r.gr_no=b.gr_no";
	$result = mysqli_query($conn, $sql1);
	$infos = mysqli_fetch_assoc($result);
	$gr_no = $infos['gr_no'];
	$bname =$infos['name'];
	mysqli_free_result($result);


      if(isset($_POST['submit']))
      {
         
      	$data= mysqli_real_escape_string($conn, $_POST['data']);
      	
        $sql="update record set review='$data' where accession_id='$accession_id'";
          mysqli_query($conn, $sql);
        $rate= mysqli_real_escape_string($conn, $_POST['rating']);
      	
        $sql01="update record set rating='$rate' where accession_id='$accession_id'";
          mysqli_query($conn, $sql01);

        $sql02="update book set rating=(select AVG(rating) from record r where r.gr_no='$gr_no') where book.gr_no='$gr_no' ";
                mysqli_query($conn, $sql02);
      }
      

 ?>

  <!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Give Book Review </title>
		<link rel="stylesheet"  href="../CSS/styles.css">
	</head>
	<body>
		<nav id="main-navigation">
                <ul>
                	 <li><a href = "Myprofile.php" >My Profile</a></li>
                	 <li><a href = "History.php" >My history</a> </li>
                	  <li><a href = "userhomepage.php"> Back</a></li>

                </ul>    
            </nav>
	
	<div class = "content">
	<form action="BookReview.php" method="POST">
	<table>
		<tr>
			<td>Book Id</td>
			<?php  echo "<td>". $gr_no ."</td>"; ?>
			
		</tr>
		<tr>
			<td>Book Name</td>
			<?php  echo "<td>". $bname ."</td>"; ?>
		</tr>	
         <tr>
			<td>Enter book review</td>
			
				<td>
					<input type = "text"  placeholder = "enter the review" name = "data" value = "">
				</td>
		</tr>
		<tr>
			<td>Give book a Rating</td>
			
				<td>
					<input type = "text"  placeholder = "enter rating (out of 5)" name = "rating" value = "">
				</td>
		</tr>

	</table>
	<input type="submit" name="submit" class = "buttons" value="submit">
  </form>
</div>
</body>
</html>
