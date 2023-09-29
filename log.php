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

if (isset($_REQUEST['login'])) {
	$email = $_REQUEST['email'];
	$pass = $_REQUEST['pass'];

	include "conn.php";
	$logquery = "SELECT * FROM user";
	$executelog = mysqli_query($conn, $logquery); 
	if ($executelog) {
		$logdata = mysqli_fetch_array($executelog);
		if ($email == $logdata[3]) {
			if ($pass == $logdata[4]) {
				session_start();
				$_SESSION['user'] = $email;
				mysqli_close($conn);
				header("location:index.php");
				exit;
			}else {
				echo '<script>alert("Invalid Password! Try Again!!!");</script>';
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
	<title>Billy | User Login</title>
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
							<h2 class="text-black mb-3 p-5" >Login</h2>
						</center>
						<form class="row g-3 form-log mb-5" method="POST" onsubmit="return check();">
							<center>
								<div class="col-md-8 mb-2">
									<label for="email" class="form-label">Email</label>
									<input type="email" class="form-control" id="email" value="shubham14243@email.com" name="email" placeholder="Enter Your Email" onblur="valid_email();">
									<div class="text-success" id="vemail" style="display:none">
										Looks good!
									</div>
									<div class="text-danger" id="iemail" style="display:none">
									    Please Enter A Valid Email!
									</div>
								</div>
								<div class="col-md-8">
									<label for="password" class="form-label">Password</label>
									<input type="password" class="form-control" id="password" value="shubham123" name="pass" placeholder="Enter Your Password" onblur="valid_password();">
									<div class="text-success" id="vpassword" style="display:none">
										Looks good!
									</div>
									<div class="text-danger" id="ipassword" style="display:none">
									    Password Should Be 5-10 Characters!
									</div>
								</div>
							</center>
							<div class="col-12">
								<center>
									<button type="submit" name="login" class="col-3 btn btn-primary mb-3">Submit</button>
									<br>
									<a href="reset.php">Forgot Password</a>
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

	<script type="text/javascript">
		function valid_email(){
			em = document.getElementById("email").value;
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			if(em.match(mailformat)){
				document.getElementById("vemail").style = "display:block";
				document.getElementById("iemail").style = "display:none";
				document.getElementById("email").style = "border: 2px solid green";
				return true;
			}else {
				document.getElementById("iemail").style = "display:block";
				document.getElementById("vemail").style = "display:none";
				document.getElementById("email").style = "border: 2px solid red";
				return false;
			}
		}

		function valid_password(){
			pw = document.getElementById("password").value;
			if(pw.length <= 4 || pw.length >= 11){
				document.getElementById("ipassword").style = "display:block";
				document.getElementById("vpassword").style = "display:none";
				document.getElementById("password").style = "border: 2px solid red";
				return false;
			}else {
				document.getElementById("vpassword").style = "display:block";
				document.getElementById("ipassword").style = "display:none";
				document.getElementById("password").style = "border: 2px solid green";
				return true;
			}
		}

		function check(){
			cem = valid_email();
			cpw = valid_password();
			if (cem == true && cpw == true) {
				return true;
			}else {
				return false;
			}
		}
	</script>
	<script type="text/javascript" src="js/bundle.min.js"></script>
</body>
</html>