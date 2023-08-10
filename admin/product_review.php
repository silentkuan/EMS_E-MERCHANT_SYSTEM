<?php
require "functions.inc.php";
isAdmin();
require('top.inc.php');


$sql="select users.name,users.email,product_review.id,product_review.rating,product_review.review,product_review.added_on,product_review.status,product.name as pname from users,product_review,product where product_review.user_id=users.uid and product_review.product_id=product.id and product_review.merchant_id=$merchant_id  order by product_review.added_on desc";
$res=mysqli_query($con,$sql);
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Product Review </h4>
				</div>
				<div class="card-body--">
				<div class="table-stats order-table ov-h pl-4 pr-4 ">
					  <table id='example' class='table table-striped table-bordered'>
						 <thead>
							<tr>
							  
							   <th>Name</th>
							   <th>Email</th>
							   <th>Product Name</th>
							   <th>Rating</th>
							   <th>Review</th>
							   <th>Added On</th>
							   
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){?>
							<tr>
							 
							   <td><?php echo $row['name']?></td>
							   <td><?php echo $row['email']?></td>
							   <td><?php echo $row['pname']?></td>
							   <td><?php echo $row['rating']?></td>
							   <td><?php echo $row['review']?></td>
							   <td><?php echo $row['added_on']?></td>
							   
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
<?php
require('footer.inc.php');
?>