<?php 

session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['status'])) {
	header("location:reg.php");
	exit;
}else {
	$email = $_SESSION['user'];
}

if (isset($_REQUEST['registershop'])) {
	$sname = $_REQUEST['sname'];
	$sphone = $_REQUEST['sphone'];
	$semail = $_REQUEST['semail'];
	$saddress = $_REQUEST['saddress'];

	include "conn.php";

	$query = "UPDATE user SET sname = '$sname', sphone = '$sphone', semail = '$semail', saddress = '$saddress' WHERE email = '$email' ";
	$execute = mysqli_query($conn, $query);
	if ($execute) {
		unset($_SESSION['status']);
		mysqli_close($conn);
		header("location:index.php");
		exit;
	}else {
		echo '<script>alert("Something Went Wrong! Try Again!!!");</script>';
	}
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Billy | Register Shop</title>
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
						<img class="reg-img" src="img/bill3.png" alt="Billing System">
					</div>
					<div class="col-md-6">
						<center>
							<h2 class="text-black mb-3 p-4" >Shop Details</h2>
						</center>
						<form class="row g-3 form-reg" method="POST" onsubmit="return check();">		
							<div class="col-12">
								<label for="name" class="form-label">Name Of Shop</label>
								<input type="text" class="form-control" id="name" name="sname" placeholder="Enter Name Of Your Shop" onblur="valid_name();">
								<div class="text-success" id="vname" style="display:none">
									Looks good!
								</div>
								<div class="text-danger" id="iname" style="display:none">
								    Please Enter A Valid Name!
								</div>
							</div>
							<div class="col-md-12">
								<label for="phone" class="form-label">Contact Phone No</label>
								<input type="text" class="form-control" id="phone" name="sphone" placeholder="Enter Contact Phone No" onblur="valid_phone();">
								<div class="text-success" id="vphone" style="display:none">
									Looks good!
								</div>
								<div class="text-danger" id="iphone" style="display:none">
								    Please Enter A Valid Phone No!
								</div>
							</div>
							<div class="col-md-12">
								<label for="email" class="form-label">Contact Email</label>
								<input type="email" class="form-control" id="email" name="semail" placeholder="Enter Contact Email" onblur="valid_email();">
								<div class="text-success" id="vemail" style="display:none">
									Looks good!
								</div>
								<div class="text-danger" id="iemail" style="display:none">
								    Please Enter A Valid Email!
								</div>
							</div>
							<div class="col-12 mb-2">
								<label for="address" class="form-label">Shop Address</label>
								<input type="text" class="form-control"  id="address" name="saddress" placeholder="Enter Shop Address"onblur="valid_address();">
								<div class="text-success" id="vaddress" style="display:none">
									Looks good!
								</div>
								<div class="text-danger" id="iaddress" style="display:none">
								    Please Enter A Valid Address!
								</div>
							</div>
							<div class="col-12">
								<center>
									<button type="submit" name="registershop" class="col-3 btn btn-primary">Submit</button>
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
			if(nm.length <= 4){
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

		function valid_phone(){
			ph = document.getElementById("phone").value;
			var phnformat =  /^\d{10}$/;
			if(ph.match(phnformat)){
				document.getElementById("vphone").style = "display:block";
				document.getElementById("iphone").style = "display:none";
				document.getElementById("phone").style = "border: 2px solid green";
				return true;
			}else {
				document.getElementById("iphone").style = "display:block";
				document.getElementById("vphone").style = "display:none";
				document.getElementById("phone").style = "border: 2px solid red";
				return false;
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

		function valid_address(){
			ad = document.getElementById("address").value;
			if(ad.length < 5){
				document.getElementById("iaddress").style = "display:block";
				document.getElementById("vaddress").style = "display:none";
				document.getElementById("address").style = "border: 2px solid red";
				return false;
			}else {
				document.getElementById("vaddress").style = "display:block";
				document.getElementById("iaddress").style = "display:none";
				document.getElementById("address").style = "border: 2px solid green";
				return true;
			}
		}

		function check(){
			cnm = valid_name();
			cem = valid_email();
			cph = valid_phone();
			cad = valid_address();
			if (cnm == true && cem == true && cph == true && cad == true) {
				return true;
			}else {
				return false;
			}
		}
	</script>
	<script type="text/javascript" src="js/bundle.min.js"></script>
</body>
</html>