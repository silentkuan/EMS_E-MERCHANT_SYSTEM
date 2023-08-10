<?php
require "functions.inc.php";
isadmin();
require('top.inc.php');


$sql = "SELECT * FROM users WHERE merchant_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $merchant_id);
$stmt->execute();
$res = $stmt->get_result();
$stmt->close();

?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">List of Customers </h4>
				</div>
				<div class="card-body--">
				<div class="table-stats order-table ov-h pl-4 pr-4 ">
					  <table id='example' class='table table-striped table-bordered'>
						 <thead>
							<tr>
							   
							   
							   <th>Name</th>
							   <th>Email</th>
							   <th>Mobile</th>
							   <th>Date</th>
							 
							</tr>
						 </thead>
						 <tbody>
							<?php
       $i = 1;
       while ($row = mysqli_fetch_assoc($res)) { ?>
							<tr>
							   
							   
							   <td><?php echo $row['name']; ?></td>
							   <td><?php echo $row['email']; ?></td>
							   <td><?php echo $row['mobile']; ?></td>
							   <td><?php echo $row['added_on']; ?></td>
							   
							</tr>
							<?php }
       ?>
						 </tbody>
					  </table>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>
<?php require 'footer.inc.php';
?>
