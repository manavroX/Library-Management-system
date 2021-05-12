<?php
	include('../config/connectDB.php');
	session_start();
	$college_id = $_SESSION['college_id'];
	// echo $college_id;
	// echo "<br>";
	$sql = "select mem_id from member where college_id = '$college_id'";
	$result = mysqli_query($conn, $sql);
	$mem_ids = mysqli_fetch_assoc($result);
	$mem_id = $mem_ids['mem_id'];
	mysqli_free_result($result);
	$search_book_name = '';
	$error = '';
	$availableBooks = true;
	$notavailableBooks=true;
   	if(isset($_POST['gr_button']))
	{
		$gr_num = mysqli_real_escape_string($conn, $_POST['gr_button']);
		
		$_SESSION["gr_no"] = $gr_num;
		header('Location: BookDetails.php');
	}
	if(isset($_GET['search_book']))
	{
		$search_book_name = mysqli_real_escape_string($conn, $_GET['search_book']);
	}
	else
	{
		$search_book_name = '';
	}
	$sql = "SELECT book.gr_no,book.name,book.rating,book.category,max(copy.status)
 			from book,copy,record where book.gr_no = copy.gr_no and copy.gr_no = record.gr_no and 
 			copy.conditions=1 and book.name like '%$search_book_name%'
 			and book.gr_no not in
			(SELECT gr_no 
			from record
			where record.issued_by = $mem_id)
			group by record.gr_no order by count(*) desc";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0)
	{
		$books1 = mysqli_fetch_all($result);
	}
	else
	{
		$availableBooks = false;
	}
	mysqli_free_result($result);
	//echo $sql;
	//print_r($books1);
/*SELECT count(*),book.gr_no,book.name,book.rating,book.category,copy.status
 from book,copy,record where book.gr_no = copy.gr_no and copy.gr_no = record.gr_no and copy.conditions=1
 and book.gr_no not in
 (SELECT gr_no 
 from record
 where record.issued_by = 3)
 group by record.gr_no,copy.copy_no order by count(*) desc;*/
	if(!$availableBooks)
	{
		$error = "NA";
	}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Book Recommending Page</title>
		<link rel="stylesheet"  href="../CSS/styles.css">
	</head>
	<body>
		<nav id="main-navigation">
                <ul>
                	<li><a href = "Myprofile.php" >My profile</a> </li>
                    <li><a href = "userhomepage.php"> Back</a></li>

                </ul>
                </nav>  
		<table class = "searchbar">
			<tr>
				
				<td>
					<form action="Recommender.php" method="GET">
						<div class = "login-box">
							<input type = "text" placeholder = "SearchBook" name = "search_book" value = "">
							<input type="submit" name="" value="Search">
							<input type="submit" name="" value="Clear">
						</div>
					</form>
				</td>
		

		<table class = "tables" style = "border:collapse; margin-top: 55px;">
			<tr>
				<th>GR number</th>
				<th>Book Name
				<th>Rating</th>
				<th>Genre</th>
				<th>Author</th>
				<th>Availability</th>
			</tr>
				<?php
					if($availableBooks):
						foreach($books1 as $book):
				?>
						<tr>
	                     <form action="Recommender.php" method="POST">
	      					<td>
	      						<input type="submit" name="gr_button" class = "buttons" value="<?php echo $book[0]; ?>" > 
	      					</td>
	                    	</form>	
				
                    	<?php
                      //  
						//echo "<td>". $book[0]."</td>";
						echo "<td>". $book[1] ."</td>";
						echo "<td>". $book[2] ."</td>";
						echo "<td>". $book[3]." </td>";
						//echo "<td>". $book[4]." </td>"; 
						$sql = "SELECT first_name,last_name from author where author.auth_id IN (Select auth_id from book_author where gr_no = '$book[0]')";
						$result = mysqli_query($conn, $sql);
						$authors = mysqli_fetch_all($result);
				?>
						<td>
							<table>
				<?php
							foreach ($authors as $author):
								echo "<tr>";
									echo "<td>";
									echo $author[0] . " " . $author[1];
									echo "</td>";
								echo "</tr>";
							endforeach;
				?>
							</table>
						</td>
				<?php
						if($book[4]==1)
						{
							echo "<td> Available </td>";
						}
						else
						{
							echo "<td>". "Reserved" ."</td>";
						}

				?>
						</tr>
				<?php
						endforeach;
					endif;
					if(!$availableBooks):
						echo "<tr><td colspan=\"6\">".$error."</td></tr>";
					endif;
				?>
			</tr>
				

	
	
	
	</body>
<?php 
	mysqli_close($conn);
?>
	