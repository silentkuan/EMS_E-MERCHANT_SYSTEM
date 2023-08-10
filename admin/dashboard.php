<?php
require "functions.inc.php";
isAdmin();
require('top.inc.php');
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


$stmt = $con->prepare("SELECT COUNT(*) AS total_orders FROM `order` WHERE merchant_id = ? AND MONTH(added_on) = MONTH(CURRENT_DATE)");
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



$sql="select date(added_on) as date, sum(total_price) as total_sales,count(order_id) as customer_quantity FROM `order` 
    where order_status = 5 and month(added_on)=month(current_date) and merchant_id=$merchant_id group by date(added_on);";
	$report_title= "This month's Sales";
    $res=mysqli_query($con,$sql);
    $chart=mysqli_query($con,$sql);
    $data = mysqli_fetch_all($chart, MYSQLI_ASSOC);
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Dashboard</strong></div>
                        <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
                               <div class="row">
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title font-weight-bold">Total Month of Sales </h4>
        <p class="card-text display-4" style="font-size: 30px;"><?=$total_sales!="" ?$total_sales:0?></p>
       
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title font-weight-bold">Total of Orders</h5>
        <p class="card-text display-4 " style="font-size: 30px;"><?=$totalOrders!="" ?$totalOrders:0?></p>
       
      </div>
      
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title font-weight-bold">Total of Products</h5>
        <p class="card-text display-4" style="font-size: 30px;"><?=$totalProducts!="" ?$totalProducts:0?></p>
       
      </div>
      
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title font-weight-bold">Total of Customers</h5>
        <p class="card-text display-4" style="font-size: 30px;"><?=$totalUser!="" ?$totalUser:0?></p>
       
      </div>
      
    </div>
  </div>
  
</div>
								</div>
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
							   <td><?php echo "RM ".$total_sales?></td>
							   <td><?php echo $row['customer_quantity']?></td>
							   
							   
							</tr>
							<?php } ?>
						 </tbody>
					  </table>
				   </div>
                   
				</div>
							   
							</div>
                            
						</form>
                     </div>
                     
                  </div>
                  
               </div>
               
            </div>
            <?php
require('footer.inc.php');
?>
         </div>



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

