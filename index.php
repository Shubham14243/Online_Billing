<?php 

session_start();
if(isset($_SESSION['user'])){
    $email = $_SESSION['user'];
}else {
	header("location:log.php");
	exit;
}

include "conn.php";
$query = "SELECT * FROM user WHERE email = '$email'";
$execute = mysqli_query($conn, $query);
if (mysqli_num_rows($execute) > 0) {
	$userdata = mysqli_fetch_array($execute);
}
mysqli_close($conn);

if (isset($_REQUEST['logout'])) {
	session_destroy();
	header("location:log.php");
	exit;
}

if (isset($_REQUEST['next'])) {
	$cname = $_REQUEST['cname'];
	$cphone = $_REQUEST['cphone'];
	$cemail = $_REQUEST['cemail'];
	$caddress = $_REQUEST['caddress'];

	include "conn.php";
	$savequery = "INSERT INTO customer(name, phone, email, address) VALUES('$cname', '$cphone', '$cemail', '$caddress') ";
	$save = mysqli_query($conn, $savequery);
	if ($save) {
		$customer = mysqli_insert_id($conn);
		session_start();
		$_SESSION['cust'] = $customer;
		mysqli_close($conn);
		header("location:billing.php");
		exit;
	}else {
		echo '<script>alert("Something Went Wrong! Try Again!!!");</script>';
	}
}

include "conn.php";
$query2 = "SELECT * FROM customer";
$execute2 = mysqli_query($conn, $query2);

if (isset($_REQUEST['deleteinv'])) {
	$getcid = $_REQUEST['cid'];

	include "conn.php";

	$del1 = "DELETE FROM payment WHERE cid = '$getcid'";
	$ex1 = mysqli_query($conn, $del1);
	if ($ex1) {
		$del2 = "DELETE FROM product WHERE cid = '$getcid'";
		$ex2 = mysqli_query($conn, $del2);
		if ($ex2) {
			$del3 = "DELETE FROM customer WHERE cid = '$getcid'";
			$ex3 = mysqli_query($conn, $del3);
			if ($ex3) {
				mysqli_close($conn);
				header("location:index.php");
				exit;
			}else {
				mysqli_close($conn);
				echo '<script>alert("Something Went Wrong! Try Again!!!");</script>';
			}
		}else {
			mysqli_close($conn);
			echo '<script>alert("Something Went Wrong! Try Again!!!");</script>';
		}
	}else {
		mysqli_close($conn);
		echo '<script>alert("Something Went Wrong! Try Again!!!");</script>';
	}
}

if (isset($_REQUEST['viewinv'])) {
	$getcid = $_REQUEST['cid'];
	session_start();
	$_SESSION['view'] = $getcid;
	header("location:view.php");
	exit;
}

if (isset($_REQUEST['editinv'])) {
	$getcid = $_REQUEST['cid'];
	session_start();
	$_SESSION['edit'] = $getcid;
	header("location:edit.php");
	exit;
}

if (isset($_REQUEST['updpro'])) {
	$uname = $_REQUEST['uname'];
	$udob = $_REQUEST['udob'];
	$sname = $_REQUEST['sname'];
	$sphone = $_REQUEST['sphone'];
	$semail = $_REQUEST['semail'];
	$saddress = $_REQUEST['saddress'];

	include "conn.php";

	$updp = "UPDATE user SET name = '$uname', dob = '$udob', sname = '$sname', sphone = '$sphone', semail = '$semail', saddress = '$saddress' WHERE email = '$email'  ";
	$exep = mysqli_query($conn, $updp);
	if ($exep) {
		mysqli_close($conn);
		header("location:index.php");
		exit;
	}else {
		mysqli_close($conn);
		echo '<script>alert("Something Went Wrong! Try Again!!!");</script>';
	}
}

if (isset($_REQUEST['updpass'])) {
	$upass = $_REQUEST['upass'];
	$unpass = $_REQUEST['unpass'];
	$uncpass = $_REQUEST['uncpass'];

	include "conn.php";

	if ($upass == $userdata[4]) {
		$updpass = "UPDATE user SET password = '$uncpass' WHERE email = '$email'  ";
		$exepass = mysqli_query($conn, $updpass);
		if ($exepass) {
			mysqli_close($conn);
			header("location:index.php");
			exit;
		}else {
			mysqli_close($conn);
			echo '<script>alert("Something Went Wrong! Try Again!!!");</script>';
		}
	}else {
		mysqli_close($conn);
		echo '<script>alert("Wrong Password! Try Again!!!");</script>';
	}
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Billy | Home</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body class="bg-primary" style="--bs-bg-opacity: .5;">

	<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-primary">
	  	<div class="container-fluid">
	    	<a class="navbar-brand" href="index.php"><font size="6" >BILLY</font></a>
	    	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	      		<span class="navbar-toggler-icon"></span>
	    	</button>
	    	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	      		<ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
	      			<li class="nav-item">
	         			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        		</li>
			        <li class="nav-item">
			          	<a class="nav-link active" aria-current="page" href="#"><font size="4"><?php echo $userdata[5]; ?></font></a>
			        </li>
	      		</ul>
	      		<form class="d-flex" role="search">
	        		<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#invoice">Generate Invoice</button>
	        		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<div class="btn-group">
					  	<button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					    	 <img class="nav-img" src="img/bill2.png"> <?php echo $userdata[1]; ?>
					  	</button>
					  	<ul class="dropdown-menu">
						    <li><a class="dropdown-item" href="!#" data-bs-toggle="modal" data-bs-target="#profile">View Profile</a></li>
						    <li><a class="dropdown-item" href="!#" data-bs-toggle="modal" data-bs-target="#setting">Settings</a></li>
						    <li><hr class="dropdown-divider"></li>
						    <li><a class="dropdown-item" href="!#" data-bs-toggle="modal" data-bs-target="#logout">Logout</a></li>
					  	</ul>
					</div>	 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     
				</form>
	    	</div>
	  	</div>
	</nav>

	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8 p-3">
					<center>
						<h1 class="text-white"><font size="15"><u>Invoice History</u></font></h1>
					</center>
				</div>
				<div class="col-md-2"></div>
			</div>
			<div class="col-md-12 bg-primary tab-container">
				<div class="tab" style="height: 500px;overflow-y: scroll;">
					<table class="table bg-light" style="border-radius: 20px;">
					  <thead>
					    <tr>
					      <th scope="col">ID</th>
					      <th scope="col">Name</th>
					      <th scope="col">Phone</th>
					      <th scope="col">Email</th>
					      <th scope="col">Address</th>
					      <th scope="col">Product</th>
					      <th scope="col">Date</th>
					      <th scope="col">Time</th>
					      <th scope="col">Net-Amt</th>
					      <th scope="col">Paid</th>
					      <th scope="col">Due</th>
					      <th scope="col">Mode</th>
					      <th scope="col">Status</th>
					      <th scope="col">Actions</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
						  	if (mysqli_num_rows($execute2) > 0) {
						  		while ($data = mysqli_fetch_array($execute2)) {

						  			$query1 = "SELECT brand,name FROM product WHERE cid = '$data[0]' LIMIT 1";
									$execute1 = mysqli_query($conn, $query1);
									$prod = mysqli_fetch_array($execute1);

									$query = "SELECT * FROM payment WHERE cid = '$data[0]' LIMIT 1";
									$execute = mysqli_query($conn, $query);
									$pay = mysqli_fetch_array($execute);

									if ($pay[6] == "Paid") {
										$col = "green";
									}
									if ($pay[6] == "Due") {
										$col = "red";
									}
						  	?>
						  	<tr>
						      <th scope="row"><?php echo $data[0]; ?></th>
						      <td><?php echo $data[1]; ?></td>
						      <td><?php echo $data[2]; ?></td>
						      <td><?php echo $data[3]; ?></td>
						      <td><?php echo $data[4]; ?></td>
						      <td><?php echo $prod[0].' - '.$prod[1]; ?></td>
						      <td><?php echo $pay[7]; ?></td>
						      <td><?php echo $pay[8]; ?></td>
						      <td><?php echo $pay[3]; ?></td>
						      <td><?php echo $pay[4]; ?></td>
						      <td><?php echo $pay[5]; ?></td>
						      <td><?php echo $pay[2]; ?></td>
						      <td style="color:<?php echo $col; ?>;"><b><?php echo $pay[6]; ?></b></td>
						      <td>
						      	<form method="POST">
						      		<input type="hidden" name="cid" value="<?php echo $data[0]; ?>">
						      		<div class="row" style="width:90%;">
						      			<div class="col-md-4"><button type="submit" name="viewinv" class="btn btn-light"><img src="img/view.png"></button></div>
						      			<div class="col-md-4"><button type="submit" name="editinv" class="btn btn-light"><img src="img/edit.png"></button></div>
						      			<div class="col-md-4"><button type="submit" name="deleteinv" class="btn btn-light"><img src="img/delete.png"></button></div>
						      		</div>
						      	</form>
						      </td>
						    </tr>
						    <?php
						  		}
						  	}

						  	 ?>
					  </tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<!-- Customer Modal -->
	<div class="modal fade" id="invoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	    	<div class="modal-content">
		      	<div class="modal-header">
		        	<h5 class="modal-title" id="staticBackdropLabel">Customer Details</h5>
		        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body">
			        <form class="row g-3" method="POST">
					  	<div class="col-md-6">
					    	<label for="cname" class="form-label">Name*</label>
					    	<input type="text" class="form-control" id="cname" name="cname" placeholder="Customer Name" required>
					  	</div>
					 	<div class="col-md-6">
					    	<label for="cphone" class="form-label">Phone*</label>
					    	<input type="text" class="form-control" id="cphone" name="cphone" placeholder="Customer Phone No" required>
					  	</div>
					  	<div class="col-md-6">
					    	<label for="cemail" class="form-label">Email</label>
					    	<input type="email" class="form-control" id="cemail" name="cemail" placeholder="Customer Email">
					  	</div>
					  	<div class="col-md-6 mb-3">
						    <label for="caddress" class="form-label">Address*</label>
						    <textarea class="form-control" id="caddress" name="caddress" rows="3" placeholder="Customer Address" required></textarea>
						</div>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="submit" name="next" class="btn btn-primary">Next</button>
		      	</div>
	  				</form>
	    	</div>
	  	</div>
	</div>

	<!-- Profile Modal -->
	<div class="modal fade" id="profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	    	<div class="modal-content">
		      	<div class="modal-header">
		        	<h5 class="modal-title" id="staticBackdropLabel">User Profile</h5>
		        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body">
			        <div class="row">
			        	<div class="col-md-4">
			        		<img src="img/bill2.png" style="width: 100%;height: auto;">
			        	</div>
			        	<div class="col-md-8 bg-primary text-white">
			        		<div class="det" style="height: 270px; overflow-y: scroll;">
			        			<center><h3>User</h3></center>
			        			<hr class="text-white">
			        			<h4>Name : <?php echo $userdata[1]; ?></h4>
			        			<br>
			        			<h4>Email : <?php echo $userdata[3]; ?></h4>
			        			<br>
			        			<center><h3>Shop</h3></center>
			        			<hr class="text-white">
			        			<h4>Name : <?php echo $userdata[5]; ?></h4>
			        			<br>
			        			<h4>Phone : <?php echo $userdata[6]; ?></h4>
			        			<br>
			        			<h4>Email : <?php echo $userdata[7]; ?></h4>
			        			<br>
			        			<h4>Address : <?php echo $userdata[8]; ?></h4>
			        		</div>
			        	</div>
			        </div>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		      	</div>
	    	</div>
	  	</div>
	</div>

	<!-- Setting Modal -->
	<div class="modal fade" id="setting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	    	<div class="modal-content">
		      	<div class="modal-header">
		        	<h5 class="modal-title" id="staticBackdropLabel">Settings</h5>
		        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body">
		      		<nav class="navbar navbar-dark bg-primary sticky-top">
				  		<div class="container-fluid justify-content-center">
						    <button class="btn btn-sm btn-light" type="button" onclick="call('form', 'pass');">Update Profile</button>
						    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						    <button class="btn btn-sm btn-light" type="button" onclick="call('pass', 'form');">Change Password</button>
						</div>
					</nav>
			        <div class="row">
			        	<div class="col-md-10" id="form" style="display:block;margin-left: auto;margin-right: auto;">
			        		<br>
			        		<form class="row g-3" method="POST">
			        			<div class="col-md-12">
			        				<h4>User Details</h4>
			        			</div>
							  	<div class="col-md-6">
							    	<label for="uname" class="form-label">Name*</label>
							    	<input type="text" class="form-control" id="uname" name="uname" value="<?php echo $userdata[1]; ?>" required>
							  	</div>
							  	<div class="col-md-6">
							    	<label for="udob" class="form-label">DOB*</label>
							    	<input type="text" class="form-control" id="udob" name="udob" value="<?php echo $userdata[2]; ?>" onclick="this.type='date'" required>
							  	</div>
							  	<div class="col-md-12">
							    	<label for="uemail" class="form-label">Email*</label>
							    	<input type="email" class="form-control" id="uemail" name="uemail" value="<?php echo $userdata[3]; ?>" disabled required>
							  	</div>
								<hr>
								<div class="col-md-12">
			        				<h4>Shop Details</h4>
			        			</div>
							  	<div class="col-md-6">
							    	<label for="sname" class="form-label">Name*</label>
							    	<input type="text" class="form-control" id="sname" name="sname" value="<?php echo $userdata[5]; ?>" required>
							  	</div>
							 	<div class="col-md-6">
							    	<label for="sphone" class="form-label">Phone*</label>
							    	<input type="text" class="form-control" id="sphone" name="sphone" value="<?php echo $userdata[6]; ?>" required>
							  	</div>
							  	<div class="col-md-6">
							    	<label for="semail" class="form-label">Email*</label>
							    	<input type="email" class="form-control" id="semail" name="semail" value="<?php echo $userdata[7]; ?>" required>
							  	</div>
							  	<div class="col-md-6 mb-3">
								    <label for="saddress" class="form-label">Address*</label>
								    <input class="form-control" id="saddress" name="saddress" value="<?php echo $userdata[8]; ?>" required>
								</div>
								<div class="col-md-12">
									<center>
										<button type="submit" name="updpro" class="btn btn-primary">Update</button>
									</center>
								</div>
							</form>
			        	</div>
			        	<div class="col-md-10" id="pass" style="display:none;margin-left: auto;margin-right: auto;">
			        		<br>
			        		<form class="row g-3" method="POST" onsubmit="return check();">
			        			<div class="col-md-12">
			        				<h4>Update Password</h4>
			        			</div>
							  	<div class="col-md-12">
							    	<label for="upass" class="form-label">Current Password*</label>
							    	<input type="password" class="form-control" id="upass" name="upass" placeholder="User Current Password" required>
							  	</div>
							  	<div class="col-md-12">
							    	<label for="unpass" class="form-label">New Password*</label>
							    	<input type="password" class="form-control" id="unpass" name="unpass" placeholder="User New Password" onblur="paslen();" required>
							  	</div>
							  	<div class="col-md-12">
							    	<label for="ucnpass" class="form-label">Confirm New Password*</label>
							    	<input type="password" class="form-control" id="ucnpass" name="uncpass" placeholder="User Confirm New Password" onblur="match('unpass','ucnpass');" required>
							  	</div>
								<div class="col-md-12">
									<center>
										<button type="submit" name="updpass" class="btn btn-primary">Update</button>
									</center>
								</div>
							</form>
			        	</div>
			        </div>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		      	</div>
	    	</div>
	  	</div>
	</div>

	<!-- Logout Modal -->
	<div class="modal fade" id="logout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="staticBackdropLabel">Logout</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        Are you sure you want to logout?
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        <form method="POST">
	        	<button type="submit" name="logout" class="btn btn-danger">Logout</button>	
	        </form>
	      </div>
	    </div>
	  </div>
	</div>

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

		function call(id1, id2) {
			document.getElementById(id1).style = "display:block;margin-left: auto;margin-right: auto;";
			document.getElementById(id2).style = "display:none;margin-left: auto;margin-right: auto;";
		}
	</script>
	<script type="text/javascript" src="js/bundle.min.js"></script>
</body>
</html>