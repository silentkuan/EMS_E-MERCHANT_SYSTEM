<?php
require "functions.inc.php";
isAdmin();
require('top.inc.php');
$categories='';
$msg='';
$sub_categories='';
if(isset($_GET['id']) && $_GET['id']!=''){
	$id=get_safe_value($con,$_GET['id']);
	$stmt = $con->prepare("SELECT * FROM sub_categories WHERE id = ? AND merchant_id = ?");
$stmt->bind_param("ii", $id, $merchant_id);
$stmt->execute();
$result = $stmt->get_result();
$check = $result->num_rows;

	if($check>0){
		$row=mysqli_fetch_assoc($result);
		$sub_categories=$row['sub_categories'];
		$categories=$row['categories_id'];
	}else{
		echo ("<script>location.href='sub_categories.php?merchant_name=$merchant_name'</script>");
		
		die();
	}
}

if(isset($_POST['submit'])){
	$categories=get_safe_value($con,$_POST['categories_id']);
	$sub_categories=get_safe_value($con,$_POST['sub_categories']);
	$stmt = $con->prepare("SELECT * FROM sub_categories WHERE categories_id = ? AND sub_categories = ? AND merchant_id = ?");
$stmt->bind_param("iss", $categories, $sub_categories, $merchant_id);
$stmt->execute();
$res = $stmt->get_result();

$check = mysqli_num_rows($res);

	if($check>0){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$getData=mysqli_fetch_assoc($res);
			if($id==$getData['id']){
			
			}else{
				$msg="Sub Categories already exist";
			}
		}else{
			$msg="Sub Categories already exist";
		}
	}
	
	if($msg==''){
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$stmt = $con->prepare("UPDATE sub_categories SET categories_id = ?, sub_categories = ? WHERE id = ?");
			$stmt->bind_param("isi", $categories, $sub_categories, $_GET['id']);
			$stmt->execute();
		} else {
			$stmt = $con->prepare("INSERT INTO sub_categories (categories_id, sub_categories, status, merchant_id) VALUES (?, ?, '1', ?)");
			$stmt->bind_param("isi", $categories, $sub_categories, $merchant_id);
			$stmt->execute();
		}
		
		echo ("<script>location.href='sub_categories.php?merchant_name=$merchant_name'</script>");
		
		die();
	}
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Sub Categories</strong><small> Form</small></div>
                        <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="categories" class=" form-control-label">Categories</label>
									<select name="categories_id" required class="form-control">
										<option value="">Select Categories</option>
										<?php
										$stmt = $con->prepare("SELECT * FROM categories WHERE status = '1' AND merchant_id = ?");
										$stmt->bind_param("i", $merchant_id);
										$stmt->execute();
										$res = $stmt->get_result();
										
										while($row=mysqli_fetch_assoc($res)){
											if($row['id']==$categories){
												echo "<option value=".$row['id']." selected>".$row['categories']."</option>";
											}else{
												echo "<option value=".$row['id'].">".$row['categories']."</option>";
											}
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="categories" class=" form-control-label">Sub Categories</label>
									<input type="text" onkeypress="return event.charCode != 32" name="sub_categories" placeholder="Enter sub categories" class="form-control" required value="<?php echo $sub_categories?>">
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