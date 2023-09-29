<?php 

session_start();
if (isset($_SESSION['user'])) {
	unset($_SESSION['user']);
}

if (isset($_REQUEST['register'])) {
	$name = $_REQUEST['name'];
	$dob = $_REQUEST['dob'];
	$email = $_REQUEST['email'];
	$pass = $_REQUEST['pass'];
	$conf = $_REQUEST['conf'];

	include "conn.php";

	if ($pass == $conf) {

		$query = "INSERT INTO user(name, dob, email, password) VALUES('$name', '$dob', '$email', '$pass')";
		$execute = mysqli_query($conn, $query);
		if ($execute) {
			mysqli_close($conn);
			session_start();
			$_SESSION['user'] = $email;
			$_SESSION['status'] = "yes";
			header("location:regshop.php");
			exit;
		}else {
			echo '<script>alert("Something Went Wrong! Try Again!!!");</script>';
		}

	}else {
		echo '<script>alert("Password & Confirm Password Not Matched!!!");</script>';
	}
}


 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Billy | Register User</title>
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
						<img class="reg-img" src="img/bill1.png" alt="Billing System">
					</div>
					<div class="col-md-6">
						<center>
							<h2 class="text-black mb-3 p-5" >Get Started</h2>
						</center>
						<form class="row g-3 form-reg" method="POST" onsubmit="return check();">		
							<div class="col-6">
								<label for="name" class="form-label">Name</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" onblur="valid_name();">
								<div class="text-success" id="vname" style="display:none">
									Looks good!
								</div>
								<div class="text-danger" id="iname" style="display:none">
								    Please Enter A Valid Name!
								</div>
							</div>
							<div class="col-6 mb-2">
								<label for="dob" class="form-label">Date Of Birth</label>
								<input type="text" class="form-control" id="dob" name="dob" placeholder="Enter Your DOB" onclick="this.type='date'" onblur="valid_dob();">
								<div class="text-success" id="vdob" style="display:none">
									Looks good!
								</div>
								<div class="text-danger" id="idob" style="display:none">
								    Please Enter Valid DOB!
								</div>
							</div>
							<div class="col-md-12 mb-2">
								<label for="email" class="form-label">Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" onblur="valid_email();">
								<div class="text-success" id="vemail" style="display:none">
									Looks good!
								</div>
								<div class="text-danger" id="iemail" style="display:none">
								    Please Enter A Valid Email!
								</div>
							</div>
							<div class="col-md-6">
								<label for="password" class="form-label">Password</label>
								<input type="password" class="form-control" id="password" name="pass" placeholder="Create Password" onblur="valid_password();">
								<div class="text-success" id="vpassword" style="display:none">
									Looks good!
								</div>
								<div class="text-danger" id="ipassword" style="display:none">
								    Password Should Be 5-10 Characters!
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="confirm" class="form-label">Confirm Password</label>
								<input type="password" class="form-control" id="confirm" name="conf" placeholder="Confirm Password" onkeyup="valid_confirm();">
								<div class="text-success" id="vconfirm" style="display:none">
									Looks good!
								</div>
								<div class="text-danger" id="iconfirm" style="display:none">
								    Password & Confirm Password Not Matched!
								</div>
							</div>
							<div class="col-12">
								<center>
									<button type="submit" class="col-3 btn btn-primary" name="register">Submit</button>
								</center>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script type="text/javascript">
		function valid_name(){
			nm = document.getElementById("name").value;
			if(nm.length <= 2){
				document.getElementById("iname").style = "display:block";
				document.getElementById("vname").style = "display:none";
				document.getElementById("name").style = "border: 2px solid red";
				return false;
			}else {
				document.getElementById("vname").style = "display:block";
				document.getElementById("iname").style = "display:none";
				document.getElementById("name").style = "border: 2px solid green";
				return true;
			}
		}

		function valid_dob(){
			dob = document.getElementById("dob");
			if(!dob.value){
				document.getElementById("idob").style = "display:block";
				document.getElementById("vdob").style = "display:none";
				document.getElementById("dob").style = "border: 2px solid red";
				return false;
			}else {
				document.getElementById("vdob").style = "display:block";
				document.getElementById("idob").style = "display:none";
				document.getElementById("dob").style = "border: 2px solid green";
				return true;
			}
		}

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

		function valid_confirm(){
			cf = document.getElementById("confirm").value;
			pw = document.getElementById("password").value;
			if(cf != pw || cf.length <= 4 || cf.length >= 11){
				document.getElementById("iconfirm").style = "display:block";
				document.getElementById("vconfirm").style = "display:none";
				document.getElementById("confirm").style = "border: 2px solid red";
				return false;
			}else {
				document.getElementById("vconfirm").style = "display:block";
				document.getElementById("iconfirm").style = "display:none";
				document.getElementById("confirm").style = "border: 2px solid green";
				return true;
			}
		}

		function check(){
			cnm = valid_name();
			cem = valid_email();
			cdob = valid_dob();
			cpw = valid_password();
			ccf = valid_confirm();
			if (cnm == true && cem == true && cdob == true && cpw == true && ccf == true) {
				return true;
			}else {
				return false;
			}
		}
	</script>
	<script type="text/javascript" src="js/bundle.min.js"></script>
</body>
</html>