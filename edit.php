<?php 

session_start();

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

if (!isset($_SESSION['edit'])) {
	header("location:index.php");
	exit;
}else {
	$cid = $_SESSION['edit'];
}

include "conn.php";
$query1 = "SELECT * FROM customer WHERE cid = '$cid'";
$execute1 = mysqli_query($conn, $query1);
if (mysqli_num_rows($execute1) > 0) {
	$custdata = mysqli_fetch_array($execute1);
	$qqry = "SELECT * FROM payment WHERE cid = '$cid'";
	$eexe = mysqli_query($conn, $qqry);
	if (mysqli_num_rows($eexe) > 0) {
		$paydata = mysqli_fetch_array($eexe);
	}
}
mysqli_close($conn);


if (isset($_REQUEST['cancel'])) {
	unset($_SESSION['edit']);
	header("location:index.php");
	exit;
}


if (isset($_REQUEST['updcust'])) {
	$cname = $_REQUEST['cname'];
	$cphone = $_REQUEST['cphone'];
	$cemail = $_REQUEST['cemail'];
	$caddress = $_REQUEST['caddress'];
	include "conn.php";
	$editc = "UPDATE customer SET name = '$cname', phone = '$cphone', email = '$cemail', address = '$caddress' WHERE cid = '$cid' ";
	$execust = mysqli_query($conn, $editc);
	if ($execust) {
		mysqli_close($conn);
		header("location:edit.php");
		exit;
	}else {
		mysqli_close($conn);
		echo '<script>alert("Customer Not Updated!!!");</script>';
	}
}


if (isset($_REQUEST['addpro'])) {
	$pbrand = $_REQUEST['pbrand'];
	$pname = $_REQUEST['pname'];
	$pcode = $_REQUEST['pcode'];
	$pcolour = $_REQUEST['pcolour'];
	$pimei1 = $_REQUEST['pimei1'];
	$pimei2 = $_REQUEST['pimei2'];
	$pbattery = $_REQUEST['pbattery'];
	$pcharger = $_REQUEST['pcharger'];
	$pquantity = $_REQUEST['pquantity'];
	$pmrp = $_REQUEST['pmrp'];

	$ptotal = floatval($pquantity) * floatval($pmrp);

	include "conn.php";
	$addp = "INSERT INTO product(cid, brand, name, code, colour, imei1, imei2, battery, charger, quantity, mrp, total) VALUES('$cid', '$pbrand', '$pname', '$pcode', '$pcolour', '$pimei1', '$pimei2', '$pbattery', '$pcharger', '$pquantity', '$pmrp', '$ptotal')";
	$exep = mysqli_query($conn, $addp);
	if ($exep) {
		mysqli_close($conn);
		header("location:edit.php");
		exit;
	}else {
		mysqli_close($conn);
		echo '<script>alert("Product Not Added!!!");</script>';
	}
}

include "conn.php";
$query2 = "SELECT * FROM product WHERE cid = '$cid'";
$execute2 = mysqli_query($conn, $query2);


if (isset($_REQUEST['updpayment'])) {
	$paymode = $_REQUEST['paymode'];
	$paynet = $_REQUEST['paynet'];
	$paypaid = $_REQUEST['paypaid'];
	$paydue = $_REQUEST['paydue'];
	$paystatus = $_REQUEST['paystatus'];

	include "conn.php";
	$addpay = "UPDATE payment SET mode = '$paymode', net = '$paynet', paid = '$paypaid', due = '$paydue', status = '$paystatus' WHERE cid = '$cid' ";
	$exepay = mysqli_query($conn, $addpay);
	if ($exepay) {
		session_start();
		$_SESSION['view'] = $cid;
		mysqli_close($conn);
		header("location:edit.php");
		exit;
	}else {
		mysqli_close($conn);
		echo '<script>alert("Payment Not Updated!!!");</script>';
	}
}

if (isset($_REQUEST['deleterec'])) {
	$id = $_REQUEST['id'];
	include "conn.php";
	$del = "DELETE FROM product WHERE pid = '$id'";
	$exe = mysqli_query($conn, $del);
	if ($exe) {
		mysqli_close($conn);
		header("location:edit.php");
		exit;
	}else {
		mysqli_close($conn);
		echo '<script>alert("Something Went Wrong! Try Again!!!");</script>';
	}
}

if (isset($_REQUEST['editrec'])) {
	$id = $_REQUEST['id'];
	$br = $_REQUEST['br'];
	$nm = $_REQUEST['nm'];
	$cd = $_REQUEST['cd'];
	$cl = $_REQUEST['cl'];
	$i1 = $_REQUEST['i1'];
	$i2 = $_REQUEST['i2'];
	$bt = $_REQUEST['bt'];
	$cr = $_REQUEST['cr'];
	$qty = $_REQUEST['qty'];
	$mrp = $_REQUEST['mrp'];

	$total = floatval($qty)*floatval($mrp);

	include "conn.php";
	$upd = "UPDATE product SET brand = '$br', name = '$nm',code = '$cd', colour = '$cl', imei1 = '$i1', imei2 = '$i2', battery = '$bt', charger = '$cr', quantity = '$qty', mrp = '$mrp', total = '$total' WHERE pid = '$id'";
	$exec = mysqli_query($conn, $upd);
	if ($exec) {
		mysqli_close($conn);
		header("location:edit.php");
		exit;
	}else {
		mysqli_close($conn);
		echo '<script>alert("Something Went Wrong! Try Again!!!");</script>';
	}
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Billy | Update Invoice</title>
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
						<h1 class="text-white"><font size="15"><u>Update Invoice</u></font></h1>
					</center>
				</div>
				<div class="col-md-2"></div>
			</div>
			<div class="col-md-12 bg-primary tab-container">
				<div class="btab" style="height: 500px;overflow-y: scroll;overflow-x: scroll;">
					<div class="row">
						<div class="col-md-4 text-white" style="padding-left: 100px;">
							<font size="4">
								Date : <?php echo $paydata[7]; ?>
								<br>
								Time : <?php echo $paydata[8]; ?>
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
							</font><br><br>
							<center>
								<button type="button" data-bs-toggle="modal" data-bs-target="#cust" class="btn btn-light">Update Customer</button>
							</center>
						</div>
					</div>
					<hr class="text-white">
					<div class="row">
						<div class="col-md-10">
							<h3 class="text-white">Products List</h3>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#add">
					    		Add Product
					  		</button>
						</div>
					</div>
					<hr class="text-white">
					<div class="tab">
						<table class="table bg-light" style="border-radius: 20px;">
						  <thead>
						    <tr>
						      <th scope="col">ID</th>
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
					      	  <th scope="col">Actions</th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php 
						  	if (mysqli_num_rows($execute2) > 0) {
						  		while ($prodata = mysqli_fetch_array($execute2)) {
						  	?>
						  	<tr>
						      <th scope="row"><?php echo $prodata[0]; ?></th>
						      	<form method="POST">
						      <td><input type="text" style="width:90px;" name="br" value="<?php echo $prodata[2]; ?>"></td>
						      <td><input type="text" style="width:90px;" name="nm" value="<?php echo $prodata[3]; ?>"></td>
						      <td><input type="text" style="width:90px;" name="cd" value="<?php echo $prodata[4]; ?>"></td>
						      <td><input type="text" style="width:90px;" name="cl" value="<?php echo $prodata[5]; ?>"></td>
						      <td><input type="text" style="width:90px;" name="i1" value="<?php echo $prodata[6]; ?>"></td>
						      <td><input type="text" style="width:90px;" name="i2" value="<?php echo $prodata[7]; ?>"></td>
						      <td><input type="text" style="width:90px;" name="bt" value="<?php echo $prodata[8]; ?>"></td>
						      <td><input type="text" style="width:90px;" name="cr" value="<?php echo $prodata[9]; ?>"></td>
						      <td><input type="text" style="width:90px;" name="qty" value="<?php echo $prodata[10]; ?>"></td>
						      <td><input type="text" style="width:90px;" name="mrp" value="<?php echo $prodata[11]; ?>"></td>
						      <td><?php echo $prodata[12]; ?></td>
						      <td>
						      		<input type="hidden" name="id" value="<?php echo $prodata[0]; ?>">
						      		<div class="row"  style="max-width:150px;">
						      			<div class="col-md-6"><button type="submit" name="editrec" class="btn btn-light"><img src="img/edit.png"></button></div>
						      			<div class="col-md-6"><button type="submit" name="deleterec" class="btn btn-light"><img src="img/delete.png"></button></div>
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
					<hr class="text-white">
					<div class="row">
						<div class="col-md-12">
							<center>
								<button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#pay">
					    		View/Update Payment
					  		</button>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Customer Modal -->
	<div class="modal fade" id="cust" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="staticBackdropLabel">Update Customer</h5>
	        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      	</div>
	      	<div class="modal-body">
	        	<form class="row g-3" method="POST">
				  	<div class="col-md-12">
		        		<h3>Customer Details</h3>
		        		<hr>
		        	</div>
		        	<div class="col-md-6">
				    	<label for="cname" class="form-label">Name*</label>
				    	<input type="text" class="form-control" id="cname" name="cname" value="<?php echo $custdata[1]; ?>" required>
				  	</div>
				 	<div class="col-md-6">
				    	<label for="cphone" class="form-label">Phone*</label>
				    	<input type="text" class="form-control" id="cphone" name="cphone" value="<?php echo $custdata[2]; ?>" required>
				  	</div>
				  	<div class="col-md-6 mb-3">
				    	<label for="cemail" class="form-label">Email</label>
				    	<input type="text" class="form-control" id="cemail" name="cemail" value="<?php echo $custdata[3]; ?>">
				  	</div>
				  	<div class="col-md-6 mb-3">
				    	<label for="caddress" class="form-label">Address*</label>
				    	<input type="text" class="form-control" id="caddress" name="caddress" value="<?php echo $custdata[4]; ?>"required>
				  	</div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="submit" name="updcust" class="btn btn-primary">Update Customer</button>
		    </div>
	  			</form>
	    </div>
	  </div>
	</div>

	<!-- Product Modal -->
	<div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="staticBackdropLabel">Add Product</h5>
	        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      	</div>
	      	<div class="modal-body">
	        	<form class="row g-3" method="POST">
				  	<div class="col-md-12">
		        		<h3>Product Details</h3>
		        		<hr>
		        	</div>
				 	<div class="col-md-6">
				    	<label for="pbrand" class="form-label">Brand*</label>
				    	<input type="text" class="form-control" id="pbrand" name="pbrand" placeholder="Product Brand" required>
				  	</div>
		        	<div class="col-md-6">
				    	<label for="pname" class="form-label">Name*</label>
				    	<input type="text" class="form-control" id="pname" name="pname" placeholder="Product Name" required>
				  	</div>
				 	<div class="col-md-6">
				    	<label for="pcode" class="form-label">Code</label>
				    	<input type="text" class="form-control" id="pcode" name="pcode" placeholder="Product Code No">
				  	</div>
				  	<div class="col-md-6">
				    	<label for="pcolour" class="form-label">Colour*</label>
				    	<input type="text" class="form-control" id="pcolour" name="pcolour" placeholder="Product Colour" required>
				  	</div>
				 	<div class="col-md-6">
				    	<label for="pimei1" class="form-label">IMEI-1*</label>
				    	<input type="text" class="form-control" id="pimei1" name="pimei1" placeholder="Product IMEI-1" required>
				  	</div>
				 	<div class="col-md-6">
				    	<label for="pimei2" class="form-label">IMEI-2</label>
				    	<input type="text" class="form-control" id="pimei2" name="pimei2" placeholder="Product IMEI-2">
				  	</div>
				  	<div class="col-md-6">
				    	<label for="pbattery" class="form-label">Battery No</label>
				    	<input type="text" class="form-control" id="pbattery" name="pbattery" placeholder="Product Battery No">
				  	</div>
				  	<div class="col-md-6 mb-3">
				    	<label for="pcharger" class="form-label">Charger No</label>
				    	<input type="text" class="form-control" id="pcharger" name="pcharger" placeholder="Product Charger No">
				  	</div>
				  	<div class="col-md-6">
				    	<label for="pquantity" class="form-label">Quantity*</label>
				    	<input type="text" class="form-control" id="pquantity" name="pquantity" placeholder="Product Quantity" required>
				  	</div>
				  	<div class="col-md-6 mb-3">
				    	<label for="pmrp" class="form-label">MRP*</label>
				    	<input type="text" class="form-control" id="pmrp" name="pmrp" placeholder="Product MRP" required>
				  	</div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="submit" name="addpro" class="btn btn-primary">Add Product</button>
		    </div>
	  			</form>
	    </div>
	  </div>
	</div>

	<!-- Payment Modal -->
	<div class="modal fade" id="pay" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="staticBackdropLabel">Add Payment</h5>
	        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      	</div>
	      	<div class="modal-body">
	        	<form class="row g-3" method="POST">
				  	<div class="col-md-12">
		        		<h3>Payment Details</h3>
		        		<hr>
		        	</div>
				 	<div class="col-md-6">
				    	<label for="paymode" class="form-label">Mode*</label>
				    	<select class="form-select" id="paymode" name="paymode" required>
						  	<option value="<?php echo $paydata[2]; ?>" selected><?php echo $paydata[2]; ?></option>
						  	<option value="Cash">Cash</option>
						  	<option value="UPI">UPI</option>
						  	<option value="Bank Transfer">Bank Transfer</option>
						  	<option value="Cheque">Cheque</option>
						</select>
				  	</div>
		        	<div class="col-md-6">
				    	<label for="paynet" class="form-label">Net Amount*</label>
				    	<input type="text" class="form-control" id="paynet" name="paynet" value="<?php echo $paydata[3]; ?>" required>
				  	</div>
				 	<div class="col-md-6">
				    	<label for="paypaid" class="form-label">Paid Amount*</label>
				    	<input type="text" class="form-control" id="paypaid" name="paypaid" placeholder="Paid Amount" value="<?php echo $paydata[4]; ?>" onkeyup="getdue();" required>
				  	</div>
				  	<div class="col-md-6 mb-3">
				    	<label for="paydue" class="form-label">Due Amount</label>
				    	<input type="text" class="form-control" id="paydue" name="paydue" placeholder="Due Amount" value="<?php echo $paydata[5]; ?>">
				  	</div>
				  	<div class="col-md-6 mb-3">
				    	<label for="paystatus" class="form-label">Payment Status</label>
				    	<input type="text" class="form-control" id="paystatus" name="paystatus" placeholder="Payment Status" value="<?php echo $paydata[6]; ?>">
				  	</div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="submit" name="updpayment" class="btn btn-primary">Update Payment</button>
		    </div>
	  			</form>
	    </div>
	  </div>
	</div>

	<script type="text/javascript">
		function getdue() {
			tt = document.getElementById("paynet").value;
            pp = document.getElementById("paypaid").value;
            bb = tt-pp;
            if (bb < 0) {
                document.getElementById("paypaid").value = "";
                document.getElementById("paydue").value = "";
                alert("Paid Amount Can't Be More Than Net Amount");
            }else{
                document.getElementById("paydue").value = bb.toFixed(2);
            }

            if (bb > 0) {
            	document.getElementById("paystatus").value = "Due";
            }else {
            	document.getElementById("paystatus").value = "Paid";
            }
		}
	</script>
	<script type="text/javascript" src="js/bundle.min.js"></script>
</body>
</html>