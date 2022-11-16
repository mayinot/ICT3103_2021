<?php 
	session_start();
		
	if(!isset($_SESSION['user_id']))
	{
		header('location:index.php');
		exit;
	}
	 
	
	if(isset($_POST['submit']))
	{
		if((isset($_POST['contactemail']) && $_POST['contactemail'] !='') && (isset($_POST['petname']) && $_POST['petname'] !=''))
		{
			$contactemail = trim($_POST['contactemail']);
			$petname = trim($_POST['petname']);

			 //sanitise string
			//$petname = filter_var($petname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
			
			if($contactemail == "user@example.com")
			{	
				if($petname == "postmancat")
				{
					unset($errorMsg);
					$resultMsg = "Postman cat is requested.";
					
				}else{
					$errorMsg = "No pet allow named: " .$petname; 
				}
			}
			$errorMsg = "Submit failed";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard | PHP Login and logout example with session</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="container-dashboard">
		Welcome to the dashboard! <span class="user-name"><?php echo ucwords($_SESSION['first_name'])?> <?php echo ucwords($_SESSION['last_name']);?> </span> 
		<br>
		<h1> Adopt a pet!</h1> 
		<?php 
			if(isset($errorMsg))
			{
				echo "<div class='error-msg'>";
				echo $errorMsg;
				echo "</div>";
				unset($errorMsg);
			}
			
			if(isset($resultMsg))
			{
				echo "<div class='success-msg'>";
				echo "You have successfully submitted an adoption request. ";
				echo $resultMsg;
				echo "</div>";
				unset($resultMsg);
			}
		?>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
			<div class="field-container">
				<label>Pet Name</label>
				<input type="text" name="petname" required placeholder="Enter Pet Name">
			</div>
			<div class="field-container">
				<label>Contect Email</label>
				<input type="email" name="contactemail" required placeholder="Enter Your Email">
			</div>
			<div class="field-container">
				<button type="submit" name="submit">Submit</button>
			</div>
			
		</form>
		<a href="logout.php?logout=true" class="logout-link">Logout</a>
	</div>
</body>
</html>