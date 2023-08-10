<?php
require "functions.inc.php";
isAdmin();
require('top.inc.php');
$coupon_code='';
$coupon_type='';
$coupon_value='';
$cart_min_value='';

$msg='';
if(isset($_GET['id']) && $_GET['id']!=''){
	$image_required='';
	$id=get_safe_value($con,$_GET['id']);
	$stmt = mysqli_prepare($con, "SELECT * FROM coupon_master WHERE id = ? AND merchant_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $id, $merchant_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$check = mysqli_num_rows($res);
mysqli_stmt_close($stmt);

	if($check>0){
		$row=mysqli_fetch_assoc($res);
		$coupon_code=$row['coupon_code'];
		$coupon_type=$row['coupon_type'];
		$coupon_value=$row['coupon_value'];
		$cart_min_value=$row['cart_min_value'];
	}else{
		echo ("<script>location.href='coupon_master.php?merchant_name=$merchant_name'</script>");
		
		die();
	}
}

if(isset($_POST['submit'])){
	$coupon_code=get_safe_value($con,$_POST['coupon_code']);
	$coupon_type=get_safe_value($con,$_POST['coupon_type']);
	$coupon_value=get_safe_value($con,$_POST['coupon_value']);
	$cart_min_value=get_safe_value($con,$_POST['cart_min_value']);
	
	
	
	
	if($msg==''){
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$update_sql = "UPDATE coupon_master SET coupon_code=?, coupon_value=?, coupon_type=?, cart_min_value=? WHERE id=?";
			$stmt = mysqli_prepare($con, $update_sql);
			mysqli_stmt_bind_param($stmt, "ssssi", $coupon_code, $coupon_value, $coupon_type, $cart_min_value, $id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else {
			$stmt = mysqli_prepare($con, "SELECT * FROM coupon_master WHERE coupon_code = ?");
mysqli_stmt_bind_param($stmt, "s", $coupon_code);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$check = mysqli_stmt_num_rows($stmt);
mysqli_stmt_close($stmt);

	// if($check>0){
	// 	if(isset($_GET['id']) && $_GET['id']!=''){
	// 		$getData=mysqli_fetch_assoc($res);
	// 		if($id==$getData['id']){
			
	// 		}else{
	// 			$msg="Coupon code already exist";
	// 		}
	// 	}else{
	// 		$msg="Coupon code already exist";
	// 	}
	// }
			$insert_sql = "INSERT INTO coupon_master (coupon_code, coupon_value, coupon_type, cart_min_value, status, merchant_id) VALUES (?, ?, ?, ?, 1, ?)";
			$stmt = mysqli_prepare($con, $insert_sql);
			mysqli_stmt_bind_param($stmt, "ssssi", $coupon_code, $coupon_value, $coupon_type, $cart_min_value, $merchant_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		
		echo ("<script>location.href='coupon_master.php?merchant_name=$merchant_name'</script>");
		
		die();
	}
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Coupon</strong><small> Form</small></div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
							   
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Coupon Code</label>
									<input type="text" name="coupon_code" placeholder="Enter coupon code" class="form-control" required value="<?php echo $coupon_code?>">
								</div>
								<div class="form-group">
									<label for="categories" class=" form-control-label">Coupon Value</label>
									<input type="text" name="coupon_value" placeholder="Enter coupon value" class="form-control" required value="<?php echo $coupon_value?>">
								</div>
								<div class="form-group">
									<label for="categories" class=" form-control-label">Coupon Type</label>
									<select class="form-control" name="coupon_type" required>
										<option value=''>Select</option>
										<?php
										if($coupon_type=='Percentage'){
											echo '<option value="Percentage" selected>Percentage</option>
												<option value="MYR">MYR</option>';
										}elseif($coupon_type=='MYR'){
											echo '<option value="Percentage">Percentage</option>
												<option value="MYR" selected>MYR</option>';
										}else{
											echo '<option value="Percentage">Percentage</option>
												<option value="MYR">MYR</option>';
										}
										?>
									</select>
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Cart Min Value</label>
									<input type="text" name="cart_min_value" placeholder="Enter cart min value" class="form-control" required value="<?php echo $cart_min_value?>">
								</div>
								
								
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">Submit</span>
							   </button>
							   <div class="field_error"><?php echo $msg?></div>
							</div>
						</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
		 
		 
         
<?php
require('footer.inc.php');
?>