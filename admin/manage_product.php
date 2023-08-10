<?php
require "functions.inc.php";
isadmin();
require('top.inc.php');
// $condition='';
// $condition1='';
// if($_SESSION['ADMIN_ROLE']==1){
// 	$condition=" and product.added_by='".$_SESSION['ADMIN_ID']."'";
// 	$condition1=" and added_by='".$_SESSION['ADMIN_ID']."'";
// }
$categories_id = '';
$name = '';
$mrp = '';
$price = '';
$qty = '';
$image = '';
$short_desc = '';
$description = '';
$meta_title = '';
$meta_desc = '';
$meta_keyword = '';
$best_seller = '';
$sub_categories_id = '';
$multipleImageArr = [];
$msg = '';
$image_required = 'required';

if (isset($_GET['pi']) && $_GET['pi'] > 0) {
    $pi = get_safe_value($con, $_GET['pi']);
    $stmt = $con->prepare("SELECT product_images FROM product_images WHERE id = ?");
    $stmt->bind_param("i", $pi);
    $stmt->execute();
    $delete_multiple_image_path = $stmt->get_result();
    $check = mysqli_num_rows($delete_multiple_image_path);
    if ($check > 0) {
        $row_delete_multiple_image_path = mysqli_fetch_assoc($delete_multiple_image_path);

        $current_image_multiple = PRODUCT_MULTIPLE_IMAGE_SITE_PATH . $row_delete_multiple_image_path['product_images'];
        unlink($current_image_multiple);
    }
    $delete_sql = "DELETE FROM product_images WHERE id = ?";
    $stmt = $con->prepare($delete_sql);
    $stmt->bind_param("i", $pi);
    $stmt->execute();
}

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $stmt = $con->prepare("SELECT * FROM product WHERE id = ? ");
$stmt->bind_param("i", $id);

    $stmt->execute();
    $res = $stmt->get_result();
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $categories_id = $row['categories_id'];
        $sub_categories_id = $row['sub_categories_id'];
        $name = $row['name'];
        $mrp = $row['mrp'];
        $price = $row['price'];
        $qty = $row['qty'];
        $short_desc = $row['short_desc'];
        $description = $row['description'];
        $meta_title = $row['meta_title'];
        $meta_desc = $row['meta_desc'];
        $meta_keyword = $row['meta_keyword'];
        $best_seller = $row['best_seller'];
        $image = $row['image'];

        $stmtMultipleImage = $con->prepare("SELECT id, product_images FROM product_images WHERE product_id = ?");
        $stmtMultipleImage->bind_param("i", $id);
        $stmtMultipleImage->execute();
        $resMultipleImage = $stmtMultipleImage->get_result();

        if (mysqli_num_rows($resMultipleImage) > 0) {
            $jj = 0;
            while ($rowMultipleImage = mysqli_fetch_assoc($resMultipleImage)) {
                $multipleImageArr[$jj]['product_images'] = $rowMultipleImage['product_images'];
                $multipleImageArr[$jj]['id'] = $rowMultipleImage['id'];
                $jj++;
            }
        }
    } else {
        echo "<script>location.href='product.php?merchant_name=$merchant_name'</script>";

        die();
    }
}

if (isset($_POST['submit'])) {
    $categories_id = get_safe_value($con, $_POST['categories_id']);
    $sub_categories_id = get_safe_value($con, $_POST['sub_categories_id']);
    $name = get_safe_value($con, $_POST['name']);
    $mrp = get_safe_value($con, $_POST['mrp']);
    $price = get_safe_value($con, $_POST['price']);
    $qty = get_safe_value($con, $_POST['qty']);
    $short_desc = get_safe_value($con, $_POST['short_desc']);
    $description = get_safe_value($con, $_POST['description']);
    $meta_title = get_safe_value($con, $_POST['meta_title']);
    $meta_desc = get_safe_value($con, $_POST['meta_desc']);
    $meta_keyword = get_safe_value($con, $_POST['meta_keyword']);
    $best_seller = get_safe_value($con, $_POST['best_seller']);
    if(empty($sub_categories_id)){
        $sub_categories_id=0;
    }
    $stmt = $con->prepare("SELECT * FROM product WHERE name = ? AND merchant_id = ?");
$stmt->bind_param("si", $name, $merchant_id);

    $stmt->execute();
    $res = $stmt->get_result();
    $check = mysqli_num_rows($res);

    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
            } else {
                $msg = "Product already exist";
            }
        } else {
            $msg = "Product already exist";
        }
    }

    if (isset($_GET['id']) && $_GET['id'] == 0) {
        if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
            $msg = "Please select only png,jpg and jpeg image formate";
        }
    } else {
        if ($_FILES['image']['type'] != '') {
            if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
                $msg = "Please select only png,jpg and jpeg image formate";
            }
        }
    }

    if (isset($_FILES['product_images'])) {
        foreach ($_FILES['product_images']['type'] as $key => $val) {
            if ($_FILES['product_images']['type'][$key] != '') {
                if ($_FILES['product_images']['type'][$key] != 'image/png' && $_FILES['product_images']['type'][$key] != 'image/jpg' && $_FILES['product_images']['type'][$key] != 'image/jpeg') {
                    $msg = "Please select only png,jpg and jpeg image formate in multipel product images";
                }
            }
        }
    }

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $id = $_GET['id'];
            if ($_FILES['image']['name'] != '') {
                $delete_image_path = mysqli_prepare($con, "SELECT image FROM product WHERE id = ?");
                $delete_image_path->bind_param("i", $id);
                $delete_image_path->execute();
                $delete_image_path->store_result();
                $check = $delete_image_path->num_rows;
                if ($check > 0) {
                    $delete_image_path->bind_result($image);
                    $delete_image_path->fetch();

                    $current_image = PRODUCT_IMAGE_SITE_PATH . $image;
                    unlink($current_image);
                }

                $delete_image_path->close();

                $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
                $update_sql = "UPDATE product SET categories_id = ?, name = ?, mrp = ?, price = ?, qty = ?,
					short_desc = ?, description = ?, meta_title = ?, meta_desc = ?, meta_keyword = ?,
					image = ?, best_seller = ?, sub_categories_id = ? WHERE id = ?";
                $stmt = $con->prepare($update_sql);
                $stmt->bind_param("isddissssssiii", $categories_id, $name, $mrp, $price, $qty, $short_desc, $description,
				 $meta_title, $meta_desc, $meta_keyword, $image, $best_seller, $sub_categories_id, $id);
                $stmt->execute();
                $stmt->close();
            } else {
                $update_sql = "UPDATE product SET categories_id = ?, name = ?, mrp = ?, price = ?, qty = ?,
					short_desc = ?, description = ?, meta_title = ?, meta_desc = ?, meta_keyword = ?,
					best_seller = ?, sub_categories_id = ? WHERE id = ?";
                $stmt = $con->prepare($update_sql);
                $stmt->bind_param("isddisssssiii", $categories_id, $name, $mrp, $price, $qty, $short_desc, $description,
				 $meta_title, $meta_desc, $meta_keyword, $best_seller, $sub_categories_id, $id);
                $stmt->execute();
                $stmt->close();
            }
        } else {
            $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
            $insert_sql = "INSERT INTO product (categories_id, name, mrp, price, qty, short_desc, description,
				meta_title, meta_desc, meta_keyword, status, image, best_seller, sub_categories_id, added_by,merchant_id,pending_qty,sales_qty)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?,?,0,0)";
            $stmt = $con->prepare($insert_sql);
            $stmt->bind_param("isddissssssiiii", $categories_id, $name, $mrp, $price, $qty, $short_desc, $description,
			 $meta_title, $meta_desc, $meta_keyword, $image, $best_seller, $sub_categories_id, $_SESSION['ADMIN_ID'],$merchant_id);
            $stmt->execute();
            $id = $stmt->insert_id;
            $stmt->close();
        }

        /*Product Multiple Images Start*/
        if (isset($_GET['id']) && $_GET['id'] != '') {
            if (isset($_FILES['product_images']['name'])) {
                foreach ($_FILES['product_images']['name'] as $key => $val) {
                    if ($_FILES['product_images']['name'][$key] != '') {
                        if (isset($_POST['product_images_id'][$key])) {
                            $image = rand(111111111, 999999999) . '_' . $_FILES['product_images']['name'][$key];
                            move_uploaded_file($_FILES['product_images']['tmp_name'][$key], PRODUCT_MULTIPLE_IMAGE_SERVER_PATH . $image);
                            $update_product_images_sql = "UPDATE product_images SET product_images = ? WHERE id = ?";
                            $stmt = $con->prepare($update_product_images_sql);
                            $stmt->bind_param("si", $image, $_POST['product_images_id'][$key]);
                            $stmt->execute();
                            $stmt->close();
                        } else {
                            $image = rand(111111111, 999999999) . '_' . $_FILES['product_images']['name'][$key];
                            move_uploaded_file($_FILES['product_images']['tmp_name'][$key], PRODUCT_MULTIPLE_IMAGE_SERVER_PATH . $image);
                            $insert_product_images_sql = "INSERT INTO product_images (product_id, product_images,merchant_id) VALUES (?, ?,?)";
                            $stmt = $con->prepare($insert_product_images_sql);
                            $stmt->bind_param("isi", $id, $image,$merchant_id);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }
            }
        } else {
            if (isset($_FILES['product_images']['name'])) {
                foreach ($_FILES['product_images']['name'] as $key => $val) {
                    if ($_FILES['product_images']['name'][$key] != '') {
                        $image = rand(111111111, 999999999) . '_' . $_FILES['product_images']['name'][$key];
                        move_uploaded_file($_FILES['product_images']['tmp_name'][$key], PRODUCT_MULTIPLE_IMAGE_SERVER_PATH . $image);
                        $insert_product_images_sql = "INSERT INTO product_images (product_id, product_images,merchant_id) VALUES (?, ?,?)";
                        $stmt = $con->prepare($insert_product_images_sql);
                        $stmt->bind_param("isi", $id, $image,$merchant_id);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }
        }
        /*Product Multiple Images End*/

        echo "<script>location.href='product.php?merchant_name=$merchant_name'</script>";

        die();
    }
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Product</strong><small> Form</small></div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
							   <div class="form-group">
									<div class="row">
									  <div class="col-lg-6">
										<label for="categories" class=" form-control-label">Categories</label>
										<select class="form-control" name="categories_id" id="categories_id" onchange="get_sub_cat('')" required>
											<option>Select Category</option>
											<?php
           $res = mysqli_query($con, "select id,categories from categories where merchant_id= '$merchant_id' order by categories asc");
           while ($row = mysqli_fetch_assoc($res)) {
               if ($row['id'] == $categories_id) {
                   echo "<option selected value=" . $row['id'] . ">" . $row['categories'] . "</option>";
               } else {
                   echo "<option value=" . $row['id'] . ">" . $row['categories'] . "</option>";
               }
           }
           ?>
										</select>
									  </div>
									   <div class="col-lg-6">
										<label for="categories" class=" form-control-label">Sub Categories</label>
										<select class="form-control" name="sub_categories_id" id="sub_categories_id">
											<option>Select Sub Category</option>
										</select>
									  </div>
									</div>
								</div>	
								<div class="form-group">
									<label for="categories" class=" form-control-label">Product Name</label>
									<input type="text" name="name" placeholder="Enter product name" class="form-control" required value="<?php echo $name; ?>">
								</div>
								<div class="form-group">
									<div class="row">
									  <div class="col-lg-3">
										<label for="categories" class=" form-control-label">Best Seller</label>
										<select class="form-control" name="best_seller" required>
											<option value=''>Select</option>
											<?php if ($best_seller == 1) {
               echo '<option value="1" selected>Yes</option>
													<option value="0">No</option>';
           } elseif ($best_seller == 0) {
               echo '<option value="1">Yes</option>
													<option value="0" selected>No</option>';
           } else {
               echo '<option value="1">Yes</option>
													<option value="0">No</option>';
           } ?>
										</select>
									  </div>
									  <div class="col-lg-3">
										<label for="categories" class=" form-control-label">Previous Price</label>
										<input type="number" name="mrp" placeholder="Enter product mrp" class="form-control" required value="<?php echo $mrp; ?>">
									  </div>
									  <div class="col-lg-3">
										<label for="categories" class=" form-control-label">Price</label>
										<input type="number" name="price" placeholder="Enter product price" class="form-control" required value="<?php echo $price; ?>">
									  </div>
									  <div class="col-lg-3">
										<label for="categories" class=" form-control-label">Qty</label>
										<input type="number" name="qty" placeholder="Enter qty" class="form-control" required value="<?php echo $qty; ?>">
									  </div>
									</div>
									
								</div>
								
								
								
								<div class="form-group">
									<div class="row"  id="image_box">
									  <div class="col-lg-10">
									   <label for="categories" class=" form-control-label">Image</label>
										<input type="file" name="image" class="form-control" <?php echo $image_required; ?>>
										<?php if ($image != '') {
              echo "<br><a target='_blank' href='" . PRODUCT_IMAGE_SITE_PATH . $image . "'><img width='100px' src='" . PRODUCT_IMAGE_SITE_PATH . $image . "'/></a>";
          } ?>
									  </div>
									  <div class="col-lg-2">
										<label for="categories" class=" form-control-label"></label>
										<button id="" type="button" class="btn btn-lg btn-info btn-block" onclick="add_more_images()">
											<span id="payment-button-amount">Add Image</span>
										</button>
									 </div>
									 
									 <?php if (isset($multipleImageArr[0])) {
              foreach ($multipleImageArr as $list) {
                  echo '<div class="col-lg-6" style="margin-top:20px;" id="add_image_box_' .
                      $list['id'] .
                      '"><label for="categories" class=" form-control-label">Image</label><input type="file" name="product_images[]" class="form-control" ><a href="manage_product.php?id=' .
                      $id .
                      '&pi=' .
                      $list['id'] .
                      '" style="color:white;"><button type="button" class="btn btn-lg btn-danger btn-block"><span id="payment-button-amount"><a href="manage_product.php?merchant_name='.$merchant_name.'&id=' .
                      $id .
                      '&pi=' .
                      $list['id'] .
                      '" style="color:white;">Remove</span></button></a>';
                  echo "<br><a target='_blank' href='" . PRODUCT_MULTIPLE_IMAGE_SITE_PATH . $list['product_images'] . "'><img width='100px' src='" . PRODUCT_MULTIPLE_IMAGE_SITE_PATH . $list['product_images'] . "'/></a>";
                  echo '<input type="hidden" name="product_images_id[]" value="' . $list['id'] . '"/></div>';
              }
          } ?>
									 
								  </div>
									 
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Short Description</label>
									<textarea name="short_desc" placeholder="Enter product short description" class="form-control" required><?php echo $short_desc; ?></textarea>
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Description</label>
									<textarea name="description" placeholder="Enter product description" class="form-control" id="desc" required><?php echo stripcslashes(str_replace( '\\\\', '', $description)); ?></textarea>
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Meta Title</label>
									<textarea name="meta_title" placeholder="Enter product meta title" class="form-control"><?php echo $meta_title; ?></textarea>
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Meta Description</label>
									<textarea name="meta_desc" placeholder="Enter product meta description" class="form-control"><?php echo $meta_desc; ?></textarea>
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Meta Keyword</label>
									<textarea name="meta_keyword" placeholder="Enter product meta keyword" class="form-control"><?php echo $meta_keyword; ?></textarea>
								</div>
								
								
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">Submit</span>
							   </button>
							   <div class="field_error"><?php echo $msg; ?></div>
							</div>
						</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
		 
		 <script>
			function get_sub_cat(sub_cat_id){
				var categories_id=jQuery('#categories_id').val();
				jQuery.ajax({
					url:'get_sub_cat.php?merchant_name=<?=$merchant_name?>',
					type:'post',
					data:'categories_id='+categories_id+'&sub_cat_id='+sub_cat_id,
					success:function(result){
						jQuery('#sub_categories_id').html(result);
					}
				});
			}
			
			var total_image=1;
			function add_more_images(){
				total_image++;
				var html='<div class="col-lg-6" style="margin-top:20px;" id="add_image_box_'+total_image+'"><label for="categories" class=" form-control-label">Image</label><input type="file" name="product_images[]" class="form-control" required><button type="button" class="btn btn-lg btn-danger btn-block" onclick=remove_image("'+total_image+'")><span id="payment-button-amount">Remove</span></button></div>';
				jQuery('#image_box').append(html);
			}
			
			function remove_image(id){
				jQuery('#add_image_box_'+id).remove();
			}
		 </script>
         
<?php require 'footer.inc.php'; ?>
<script>
<?php if (isset($_GET['id'])) { ?>
get_sub_cat('<?php echo $sub_categories_id; ?>');
<?php } ?>
</script>

<script>
    $("textarea").each(function () {
  this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
}).on("input", function () {
  this.style.height = 0;
  this.style.height = (this.scrollHeight) + "px";
});
	// $('#desc').val(document.getElementById("desc").value.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br />").replaceAll('\\', ""));
	</script>