<?php
// require "connection.inc.php";
$sessionStart = false;
require "functions.inc.php";
// isAdmin();
date_default_timezone_set("Asia/Kuala_Lumpur");
$stmt = $con->prepare("SELECT COUNT(*) AS total_product FROM product WHERE merchant_id = ?");
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalProducts = $row['total_product'];
$stmt->close();



$stmt = $con->prepare("SELECT COUNT(*) AS total_user FROM users WHERE merchant_id = ?");
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalUser = $row['total_user'];
$stmt->close();


$stmt = $con->prepare("SELECT COUNT(*) AS total_orders FROM `order` WHERE merchant_id = ?");
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalOrders = $row['total_orders'];
$stmt->close();



$stmt = $con->prepare("SELECT SUM(total_price) AS total_sales FROM `order` 
WHERE order_status = 5 AND MONTH(added_on) = MONTH(CURRENT_DATE) AND merchant_id = ?");
$stmt->bind_param("i", $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_sales = number_format($row['total_sales'], 2);
$stmt->close();

?>
<!doctype html>
<html class="no-js" lang="" style="overflow: hidden;">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Dashboard Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
      
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
      
	  <script type="text/javascript" class="init">
	

	$(document).ready(function () {
		$('#example').DataTable();
	});
	
	
		</script>
    <style>

@media print {
    .noprint {
        display: none
    }
}
	</style>
<?php
isAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    
    if (!empty($startDate) && !empty($endDate)) {
        $sql = "SELECT date(added_on) AS date, SUM(total_price) AS total_sales, COUNT(order_id) AS customer_quantity 
                FROM `order` 
                WHERE merchant_id='$merchant_id' AND order_status = 5 AND DATE(added_on) BETWEEN '$startDate' AND '$endDate'  
                GROUP BY date(added_on)";
                $totalSalesQuery = "SELECT SUM(total_price) AS total_sales FROM `order` WHERE merchant_id='$merchant_id' AND 
                order_status = 5   AND DATE(added_on) BETWEEN '$startDate' AND '$endDate'  ";
        $report_title = "Sales from " . $startDate . " to " . $endDate;
    } else {
        $sql = "SELECT date(added_on) AS date, SUM(total_price) AS total_sales, COUNT(order_id) AS customer_quantity 
                FROM `order` 
                WHERE merchant_id='$merchant_id' AND order_status = 5 AND MONTH(added_on) = MONTH(CURRENT_DATE) 
                GROUP BY date(added_on)";

$totalSalesQuery = "SELECT SUM(total_price) AS total_sales FROM `order` WHERE merchant_id='$merchant_id' AND order_status = 5  
AND MONTH(added_on) = MONTH(CURRENT_DATE) ";
        $report_title = "This month's Sales";
    }
} else {
    $sql = "SELECT date(added_on) AS date, SUM(total_price) AS total_sales, COUNT(order_id) AS customer_quantity 
            FROM `order` 
            WHERE merchant_id='$merchant_id' AND order_status = 5 AND MONTH(added_on) = MONTH(CURRENT_DATE) 
            GROUP BY date(added_on)";
            $totalSalesQuery = "SELECT SUM(total_price) AS total_sales FROM `order` WHERE merchant_id='$merchant_id' AND order_status = 5  
            AND MONTH(added_on) = MONTH(CURRENT_DATE) ";
    $report_title = "This month's Sales";
}

$res = mysqli_query($con, $sql);

// Query to get the total sales

$totalSalesResult = mysqli_query($con, $totalSalesQuery);
$row = mysqli_fetch_assoc($totalSalesResult);

// $totalSales = $row['total_sales'] ;
$totalSales = number_format($row['total_sales'], 2);
// echo "Total Sales: " . $totalSales;


    

$res=mysqli_query($con,$sql);
$chart=mysqli_query($con,$sql);
$data = mysqli_fetch_all($chart, MYSQLI_ASSOC);

?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Sales Report <?php echo '('.$report_title.')'; ?> </h4>
				  
                   <form id="dateRangeForm" method="POST" >
      <div class="form-row">
        <div class="col noprint">
          <label for="startDate">Start Date:</label>
          <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo !empty($startDate) ? $startDate : ''; ?>">
        </div>
        <div class="col noprint">
          <label for="endDate">End Date:</label>
          <input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo !empty($endDate) ? $endDate : ''; ?>">
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3 noprint">Generate Report</button>
      <input type="button" class="btn btn-danger mt-3 noprint" onclick="window.print();" value="Export as PDF">
    </form>
				   <!-- <h4 class="box-link"><a href="manage_banner.php">Add Banner</a> </h4> -->
				</div>
				<div class="card-body--" id="printableDiv">
                <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title font-weight-bold">Total of Sales (<?=$report_title?>)</h4>
        <p class="card-text display-4" style="font-size: 30px;">RM <?=$totalSales!="" ?$totalSales:0?></p>
       
      </div>
    </div>
  </div>
 
            <br>
                <canvas class=" pl-4 pr-4 pb-4" id="salesChart" width="400" height="200"></canvas>
				<div class="table-stats order-table ov-h pl-4 pr-4 ">
					  <table id='example' class='table table-striped table-bordered'>
						 <thead>
							<tr>
							   
							   <th>Date</th>
							   <th>Total Sales</th>
							   <th>Total Customer</th>
							  
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){?>
							<tr>
							 
							   </td>
							   <td><?php echo $row['date']?></td>
							   <td><?php echo "RM ".$total_sales ?></td>
							   <td><?php echo $row['customer_quantity']?></td>
							   
							   
							</tr>
							<?php } ?>
						 </tbody>
					  </table>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>

<script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
      <script type="text/javascript" language="javascript" src="assets/js/jquery-3.5.1.js"></script>
	<script type="text/javascript" language="javascript" src="assets/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="assets/js/dataTables.bootstrap4.min.js"></script>
   <script type="text/javascript" class="init">
	

$(document).ready(function () {
	$('#example').DataTable();
});


	</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Assuming you have retrieved the data as mentioned in step 2

// Prepare data for the chart
var labels = <?php echo json_encode(array_column($data, 'date')); ?>;
var salesData = <?php echo json_encode(array_column($data, 'total_sales')); ?>;
var a= labels;
var b=salesData;
// Create a chart using Chart.js
var ctx = document.getElementById('salesChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Total Sales (MYR)',
            data: salesData,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>