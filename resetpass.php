<?php 

session_start();
if (isset($_SESSION['user'])) {
	header("location:index.php");
	exit;
}

if (isset($_SESSION['reset'])) {
	$email = $_SESSION['reset'];
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

if (isset($_REQUEST['reset'])) {
	$uncpass = $_REQUEST['uncpass'];

	include "conn.php";
	$qry = "UPDATE user SET password = '$uncpass' WHERE email = '$email' ";
	$exe = mysqli_query($conn, $qry); 
	if ($exe) {
		mysqli_close($conn);
		unset($_SESSION['reset']);
		header("location:log.php");
		exit;	
	}else {
		mysqli_close($conn);
		echo '<script>alert("Error Occured! Try Again!!!");</script>';
	}
	mysqli_close($conn);
}


 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Billy | Reset Password</title>
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
						<form class="row g-3 form-log mb-5" method="POST" onsubmit="return check();">
							<center>
							  	<div class="col-md-8">
							    	<label for="unpass" class="form-label">New Password*</label>
							    	<input type="password" class="form-control" id="unpass" name="unpass" placeholder="User New Password" onblur="paslen();" required>
							  	</div>
							  	<div class="col-md-8">
							    	<label for="ucnpass" class="form-label">Confirm New Password*</label>
							    	<input type="password" class="form-control" id="ucnpass" name="uncpass" placeholder="User Confirm New Password" onblur="match('unpass','ucnpass');" required>
							  	</div>
							</center>
							<div class="col-12">
								<center>
									<button type="submit" name="reset" class="col-3 btn btn-primary mb-3">Submit</button>
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

		function match(id1,id2) {
			p1 = document.getElementById(id1).value;
			p2 = document.getElementById(id2).value;
			if (p1 != p2) {
				alert("Password & Confirm Password Not Same!!!");
				return false;
			}else {
				return true;
			}
		}

		function paslen() {
			pw = document.getElementById("unpass").value;
			if (pw.length <=4 || pw.length >= 11) {
				alert("Password Should Be 5-10 Characters!!!");
				return false;
			} else {
				return true;
			}
		}

		function check() {
			pp = paslen();
			cc = match('unpass','ucnpass');
			if (pp == true && cc == true) {
				return true;
			}else {
				return false;
			}
		}
	</script>
	<script type="text/javascript" src="js/bundle.min.js"></script>
</body>
</html>