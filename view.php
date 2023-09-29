<?php 

session_start();

if (isset($_SESSION['cust'])) {
	unset($_SESSION['cust']);
}

if (!isset($_SESSION['user'])) {
	header("location:log.php");
	exit;
}else {
	$email = $_SESSION['user'];
}

include "conn.php";
$query = "SELECT sname, name FROM user WHERE email = '$email'";
$execute = mysqli_query($conn, $query);
if (mysqli_num_rows($execute) > 0) {
	$userdata = mysqli_fetch_array($execute);
}
mysqli_close($conn);

if (!isset($_SESSION['view'])) {
	header("location:index.php");
	exit;
}else {
	$cid = $_SESSION['view'];
}

include "conn.php";
$query1 = "SELECT * FROM customer WHERE cid = '$cid'";
$execute1 = mysqli_query($conn, $query1);
if (mysqli_num_rows($execute1) > 0) {
	$custdata = mysqli_fetch_array($execute1);
}
mysqli_close($conn);

if (isset($_REQUEST['cancel'])) {
	unset($_SESSION['view']);
	header("location:index.php");
	exit;
}

if (isset($_REQUEST['print'])) {
	session_start();
	$_SESSION['print'] = $cid;
	header("location:invoice.php");
	exit;
}

include "conn.php";
$query2 = "SELECT * FROM product WHERE cid = '$cid'";
$execute2 = mysqli_query($conn, $query2);

$query3 = "SELECT pdate, ptime FROM payment WHERE cid = '$cid'";
$execute3 = mysqli_query($conn, $query3);
$datetime = mysqli_fetch_array($execute3);

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Billy | View Payment</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body class="bg-primary" style="--bs-bg-opacity: .5;">

	<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-primary">
	  	<div class="container-fluid">
	    	<a class="navbar-brand" href="#"><font size="6" >BILLY</font></a>
	    	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	      		<span class="navbar-toggler-icon"></span>
	    	</button>
	    	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	      		<ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
	      			<li class="nav-item">
	         			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        		</li>
			        <li class="nav-item">
			          	<a class="nav-link active" aria-current="page" href="#"><font size="4"><?php echo $userdata[0]; ?></font></a>
			        </li>
	      		</ul>
	      		<form class="d-flex" method="POST" role="search">
	        		<button type="submit" name="cancel" class="btn btn-danger">Back to Home</button>	 
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
						<h1 class="text-white"><font size="15"><u>View Invoice</u></font></h1>
					</center>
				</div>
				<div class="col-md-2"></div>
			</div>
			<div class="col-md-12 bg-primary tab-container">
				<div class="btab" style="height: 500px;overflow-y: scroll;overflow-x: scroll;">
					<div class="row">
						<div class="col-md-4 text-white" style="padding-left: 100px;">
							<font size="4">
								Date : <?php echo $datetime[0]; ?>
								<br>
								Time : <?php echo $datetime[1]; ?>
							</font>
						</div>
						<div class="col-md-4 text-white">
							<center>
								<font size="4">
									Seller : <?php echo $userdata[1]; ?>
								</font>
							</center>
						</div>
						<div class="col-md-4 text-white" style="padding-left: 80px;">
							<font size="4">
								Customer : <?php echo $custdata[1]; ?>
								<br>
								Phone : <?php echo $custdata[2]; ?>
								<br>
								Email : <?php echo $custdata[3]; ?>
								<br>
								Address : <?php echo $custdata[4]; ?>
							</font>
						</div>
					</div>
					<hr class="text-white">
					<div class="row">
						<div class="col-md-10">
							<h3 class="text-white">Products List</h3>
						</div>
						<div class="col-md-2">
							<center>
								<form>
									<button type="submit" class="btn btn-light" name="print">
						    			Print
						  			</button>
								</form>
							</center>
						</div>
					</div>
					<hr class="text-white">
					<div class="tab">
						<table class="table bg-light" style="border-radius: 20px;">
						  <thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Brand</th>
						      <th scope="col">Name</th>
						      <th scope="col">Code</th>
						      <th scope="col">Colour</th>
						      <th scope="col">IMEI-1</th>
						      <th scope="col">IMEI-2</th>
						      <th scope="col">Battery No</th>
						      <th scope="col">Charger No</th>
						      <th scope="col">Quantity</th>
						      <th scope="col">MRP</th>
						      <th scope="col">Total</th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php 
						  	if (mysqli_num_rows($execute2) > 0) {
						  		$i = 1;
						  		while ($prodata = mysqli_fetch_array($execute2)) {
						  	?>
						  	<tr>
						      <th scope="row"><?php echo $i; ?></th>
						      <td><?php echo $prodata[2]; ?></td>
						      <td><?php echo $prodata[3]; ?></td>
						      <td><?php echo $prodata[4]; ?></td>
						      <td><?php echo $prodata[5]; ?></td>
						      <td><?php echo $prodata[6]; ?></td>
						      <td><?php echo $prodata[7]; ?></td>
						      <td><?php echo $prodata[8]; ?></td>
						      <td><?php echo $prodata[9]; ?></td>
						      <td><?php echo $prodata[10]; ?></td>
						      <td><?php echo $prodata[11]; ?></td>
						      <td><?php echo $prodata[12]; ?></td>
						    </tr>
						    <?php
						    		$i = $i + 1;
						  		}
						  	}

						  	 ?>
						  </tbody>
					</table>
					</div>
					<hr class="text-white">
					<div class="row">
						<?php 

						$getpay = "SELECT * FROM payment WHERE cid = '$cid'";
						$payexe = mysqli_query($conn,$getpay);
						if (mysqli_num_rows($payexe)>0) {
							$paydata = mysqli_fetch_array($payexe);
						}

						 ?>
						<div class="col-md-4">
							<center>
								<h5 class="text-white">Payment Mode : <?php echo $paydata[2]; ?></h5>
								<br>
								<h5 class="text-white">Payment Status : <?php echo $paydata[6]; ?></h5>
							</center>
						</div>
						<div class="col-md-4">
							<center>
								<h5 class="text-white">Net-Amount : <?php echo $paydata[3]; ?></h5>
							</center>
						</div>
						<div class="col-md-4">
							<center>
								<h5 class="text-white">Paid-Amount : <?php echo $paydata[4]; ?></h5>
								<br>
								<h5 class="text-white">Due-Amount : <?php echo $paydata[5]; ?></h5>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<script type="text/javascript" src="js/bundle.min.js"></script>
</body>
</html>