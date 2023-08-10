<?php
require "functions.inc.php";
isAdmin();
require('top.inc.php');
$categories='';
$msg='';
if(isset($_GET['id']) && $_GET['id']!=''){
	$id=get_safe_value($con,$_GET['id']);
	$stmt = mysqli_prepare($con, "SELECT * FROM categories WHERE id = ? AND merchant_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $id, $merchant_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$check = mysqli_num_rows($res);
mysqli_stmt_close($stmt);

	if($check>0){
		$row=mysqli_fetch_assoc($res);
		$categories=$row['categories'];
	}else{
		
		echo ("<script>location.href='categories.php?merchant_name=$merchant_name'</script>");
		die();
	}
}

if(isset($_POST['submit'])){
	$categories=get_safe_value($con,$_POST['categories']);
	$stmt = mysqli_prepare($con, "SELECT * FROM categories WHERE categories = ? AND merchant_id = ?");
mysqli_stmt_bind_param($stmt, "si", $categories, $merchant_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$check = mysqli_num_rows($res);
mysqli_stmt_close($stmt);

	if($check>0){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$getData=mysqli_fetch_assoc($res);
			if($id==$getData['id']){
			
			}else{
				$msg="Categories already exist";
			}
		}else{
			$msg="Categories already exist";
		}
	}
	
	if($msg==''){
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$stmt = mysqli_prepare($con, "UPDATE categories SET categories = ? WHERE id = ?");
			mysqli_stmt_bind_param($stmt, "si", $categories, $id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else {
			$stmt = mysqli_prepare($con, "INSERT INTO categories (categories, status,merchant_id) VALUES (?, '1',?)");
			mysqli_stmt_bind_param($stmt, "si", $categories,$merchant_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		
		echo ("<script>location.href='categories.php?merchant_name=$merchant_name'</script>");
		
		die();
	}
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Categories</strong><small> Form</small></div>
                        <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="categories" class=" form-control-label">Categories</label>
									<input type="text" onkeypress="return event.charCode != 32" name="categories" placeholder="Enter categories name" class="form-control" required value="<?php echo $categories?>">
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