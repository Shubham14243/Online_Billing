<?php   

session_start();

if (!isset($_SESSION['user'])) {
  header("location:log.php");
  exit;
}else {
  $email = $_SESSION['user'];
}

include "conn.php";
$query = "SELECT * FROM user WHERE email = '$email'";
$execute = mysqli_query($conn, $query);
if (mysqli_num_rows($execute) > 0) {
  $userdata = mysqli_fetch_array($execute);
}
mysqli_close($conn);

if (isset($_REQUEST['cancel'])) {
  unset($_SESSION['print']);
  header("location:view.php");
  exit;
}


if (!isset($_SESSION['print'])) {
  header("location:view.php");
  exit;
}else {
  $cid = $_SESSION['print'];
}

include "conn.php";
$query1 = "SELECT * FROM customer WHERE cid = '$cid'";
$execute1 = mysqli_query($conn, $query1);
if (mysqli_num_rows($execute1) > 0) {
  $custdata = mysqli_fetch_array($execute1);
}

$query2 = "SELECT * FROM product WHERE cid = '$cid'";
$execute2 = mysqli_query($conn, $query2);

$query3 = "SELECT * FROM payment WHERE cid = '$cid'";
$execute3 = mysqli_query($conn, $query3);
if (mysqli_num_rows($execute3) > 0) {
  $paydata = mysqli_fetch_array($execute3);
}

mysqli_close($conn);

 ?>

<!DOCTYPE html>
<html class="loaded" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>Invoice</title>

    <!-- BEGIN CSS-->
    <link rel="stylesheet" type="text/css" href="inv/bootstrap.min.css">
    <!-- END CSS-->

  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="horizontal-layout horizontal-menu horizontal-menu-padding 2-columns  menu-expanded pace-done" data-open="click" data-menu="horizontal-menu" data-col="2-columns">
    <script type="text/javascript">
      function no(){
        document.getElementById("non").style = "display:none";
      }
    </script>
    <div id="invoice-footer">
      <div class="row">
        <div class="col-md-12 col-12 text-center" id="non">
          <div class="row">
            <div class="col-md-6">
              <button type="button" class="btn btn-primary btn-print" onclick="no();"><i class="la la-paper-plane-o mr-50"></i>Print</button>
            </div>
            <div class="col-md-6">
              <form>
               <button type="submit" name="cancel" class="btn btn-danger">Back</button>
             </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="pace  pace-inactive">
      <div class="pace-activity"></div></div>
        <!-- BEGIN: Content-->
        <div class="app-content container center-layout mt-2">
          <div class="content-overlay"></div>
          <div class="content-wrapper">
            <div class="content-body">
              <section class="card">
                <div id="invoice-template" class="card-body p-4">
                  <!-- Invoice Company Details -->
                  <div id="invoice-company-details" class="row">
                    <div class="col-sm-6 col-12 text-center text-sm-left">
                      <div class="media row">
                        <div class="col-12 col-sm-9 col-xl-10">
                          <div class="media-body">
                            <ul class="ml-2 px-0 list-unstyled">
                              <li class="text-bold-800"><h2><b><?php  echo $userdata[5]; ?></b></h2></li>
                              <li><h4><b><?php  echo $userdata[8]; ?></b></h4></li>
                              <li><h4><b>Phone : <?php  echo $userdata[6]; ?></b></h4></li>
                              <li><h4><b>Email : <?php  echo $userdata[7]; ?></b></h4></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-12 text-center text-sm-right">
                      <h2>INVOICE</h2>
                      <p class="pb-sm-3"><b><font size="4"># INV-<?php  echo $cid; ?></font></b></p>
                    </div>
                  </div>
                  <!-- Invoice Company Details -->

                  <!-- Invoice Customer Details -->
                  <div id="invoice-customer-details" style="color:black;" class="row pt-2">
                    <div class="col-12 text-center text-sm-left">
                      <p class="text-black">Bill To</p>
                    </div>
                    <div class="col-sm-6 col-12 text-center text-sm-left">
                      <ul class="px-0 list-unstyled">
                        <li class="text-bold-800"><?php  echo $custdata[1]; ?></li>
                        <li>Phone : <?php  echo $custdata[2]; ?></li>
                        <li>Email : <?php  echo $custdata[3]; ?></li>
                        <li>Address : <?php  echo $custdata[4]; ?></li>
                      </ul>
                    </div>
                    <div class="col-sm-6 col-12 text-center text-sm-right">
                      <p><span class="text-black">Seller :</span> <?php  echo $userdata[1]; ?></p>
                      <p><span class="text-black">Invoice Date :</span> <?php  echo $paydata[7]; ?></p>
                      <p><span class="text-black">Invoice Time :</span> <?php  echo $paydata[8]; ?></p>
                    </div>
                  </div>
                  <!-- Invoice Customer Details -->

                  <!-- Invoice Items Details -->
                  <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                      <div class="table-responsive col-12">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Item &amp; Description</th>
                              <th class="text-right">Quantity</th>
                              <th class="text-right">MRP</th>
                              <th class="text-right">Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php   
                            $i = 1;
                            if (mysqli_num_rows($execute2) > 0) {
                              while ($prodata = mysqli_fetch_array($execute2)) {
                            ?>
                              <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td>
                                  <p><?php echo '#'.$prodata[4].' - '.$prodata[2].' - '.$prodata[3].' - '.$prodata[5]; ?></p>
                                  <p class="text-muted"><?php echo 'IMEI-1 - '.$prodata[6].' / IMEI-2 - '.$prodata[7]; ?></p>
                                  <p class="text-muted"><?php echo 'Battery No - '.$prodata[8].' / Charger No - '.$prodata[9]; ?></p>
                                </td>
                                <td class="text-right"><?php echo $prodata[10]; ?></td>
                                <td class="text-right"><?php echo $prodata[11]; ?></td>
                                <td class="text-right"><?php echo $prodata[12]; ?></td>
                              </tr>
                            <?php
                            $i = $i + 1;
                              }
                            }
                             ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-7 col-12 text-center text-sm-left">
                        <p class="lead">Payment Details:</p>
                        <div class="row">
                          <div class="col-sm-8">
                            <div class="table-responsive">
                              <table class="table table-borderless table-sm">
                                <tbody>
                                  <tr>
                                    <td>Mode Of Payment :</td>
                                    <td class="text-right"><?php  echo $paydata[2]; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Status Of Payment :</td>
                                    <td class="text-right"><?php  echo $paydata[6]; ?></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-5 col-12">
                        <div class="table-responsive">
                          <table class="table">
                            <tbody>
                              <tr>
                                <td>Net Amount</td>
                                <td class="text-bold-800 text-right"><?php  echo $paydata[3]; ?></td>
                              </tr>
                              <tr>
                                <td>Paid Amount</td>
                                <td class="text-bold-800 text-right">(-)<?php  echo $paydata[4]; ?></td>
                              </tr>
                              <tr>
                                <td>Due Amount</td>
                                <td class="text-bold-800 text-right"><?php  echo $paydata[5]; ?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <br>
                        <div class="text-center">
                          <br><br><br><br>
                          <h6><?php  echo $userdata[1]; ?></h6>
                          <p class="text-muted">Signature</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END: Content-->

    <!-- BEGIN: Vendor JS-->
    <script src="inv/vendors.min.js.download"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="inv/invoice-template.min.js.download"></script>
    <!-- END: Page JS-->

  
  <!-- END: Body-->
</body></html>