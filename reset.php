<?php 

if (isset($_SESSION['user'])) {
	header("location:index.php");
	exit;
}

include "conn.php";
$query = "SELECT * FROM user";
$execute = mysqli_query($conn, $query);
if (mysqli_num_rows($execute) == 0) {
	mysqli_close($conn);
	header("location:reg.php");
	exit;
}
mysqli_close($conn);

if (isset($_REQUEST['res'])) {
	$email = $_REQUEST['email'];
	$dob = $_REQUEST['dob'];

	include "conn.php";
	$logquery = "SELECT * FROM user";
	$executelog = mysqli_query($conn, $logquery); 
	if ($executelog) {
		$logdata = mysqli_fetch_array($executelog);
		if ($email == $logdata[3]) {
			if ($dob == $logdata[2]) {
				session_start();
				$_SESSION['reset'] = $email;
				mysqli_close($conn);
				header("location:resetpass.php");
				exit;
			}else {
				echo '<script>alert("Invalid DOB! Try Again!!!");</script>';
			}
		}else {
			echo '<script>alert("Invalid Email! Try Again!!!");</script>';
		}	
	}else {
		echo '<script>alert("Invalid Credentials! Try Again!!!");</script>';
	}
	mysqli_close($conn);
}


 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Billy | Reset</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body class="bg-primary" style="--bs-bg-opacity: .75;">

	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8 p-3">
					<center>
						<h1 class="text-white"><font size="15">BILLY - Just Billing</font></h1>
					</center>
				</div>
				<div class="col-md-2"></div>
			</div>
			<div class="col-md-10 bg-light form-container">
				<div class="row">
					<div class="col-md-6">
						<img class="reg-img" src="img/bill2.png" alt="Billing System">
					</div>
					<div class="col-md-6">
						<center>
							<h2 class="text-black mb-3 p-5" >Reset Password</h2>
						</center>
						<form class="row g-3 form-log mb-5" method="POST">
							<center>
								<div class="col-md-8 mb-2">
									<label for="email" class="form-label">Email</label>
									<input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" >
								</div>
								<div class="col-md-8">
									<label for="dob" class="form-label">Date Of Birth</label>
									<input type="text" class="form-control" id="dob" name="dob" placeholder="Enter Your DOB" onclick="this.type='date'">
								</div>
							</center>
							<div class="col-12">
								<center>
									<button type="submit" name="res" class="col-3 btn btn-primary mb-3">Submit</button>
								</center>
							</div>
						</form>
						<div class="col-md-10 details">
							<p>
								<br>
								<font size="4"><b>Contact : Shubham Kumar Gupta</b></font>
								<br>
								<font><b>Email : guptashubham14243@gmail.com</b></font>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script type="text/javascript" src="js/bundle.min.js"></script>
</body>
</html>