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

if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == 'status') {
        $operation = get_safe_value($con, $_GET['operation']);
        $id = get_safe_value($con, $_GET['id']);
        if ($operation == 'active') {
            $status = '1';
        } else {
            $status = '0';
        }
        $update_status_sql = "UPDATE product SET status=? WHERE id=?";
        $stmt = $con->prepare($update_status_sql);
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
    }

    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $stmt = $con->prepare("SELECT image FROM product WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $delete_image_path = $stmt->get_result();

        $check = mysqli_num_rows($delete_image_path);
        if ($check > 0) {
            $row_delete_image_path = mysqli_fetch_assoc($delete_image_path);
            $image = PRODUCT_IMAGE_SITE_PATH . $row_delete_image_path['image'];
            unlink($image);
        }

        $stmtMultipleImage = $con->prepare("SELECT id, product_images FROM product_images WHERE product_id=?");
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

        if (isset($multipleImageArr[0])) {
            foreach ($multipleImageArr as $list) {
                $multiImage = PRODUCT_MULTIPLE_IMAGE_SITE_PATH . $list['product_images'];
                unlink($multiImage);
            }
        }

        $stmtDelete = $con->prepare("DELETE FROM product WHERE id=?");
        $stmtDelete->bind_param("i", $id);
        $stmtDelete->execute();
    }
}

$stmt = $con->prepare("SELECT product.*, categories.categories FROM product 
INNER JOIN categories ON product.categories_id = categories.id 
WHERE product.merchant_id = ? 
ORDER BY product.id DESC");

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
				   <h4 class="box-title">Products </h4>
				   <h4 class="box-link"><a href="manage_product.php?merchant_name=<?=$merchant_name?>">Add Product</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h pl-4 pr-4 ">
					  <table id='example' class='table table-striped table-bordered'>
						 <thead>
							<tr>
							   
							 
							   <th width="8%">Categories</th>
							   <th width="10%">Name</th>
							   <th width="11%">Image</th>
							   <th width="8%">Previous Price</th>
							   <th width="7%">Price</th>
							   <th width="5%">In Stock</th>
							   <th width="5%">Pending Qty</th>
							   <th width="5%">Current Qty</th>
							   <th width="5%">Sales</th>
							   <th width="34%"></th>
							</tr>
						 </thead>
						 <tbody>
							<?php while ($row = mysqli_fetch_assoc($res)) { ?>
							<tr>
							  
							  
							   <td><?php echo $row['categories']; ?></td>
							   <td><?php echo $row['name']; ?></td>
							   <td><img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $row['image']; ?>"/></td>
							   <td>RM <?php echo $row['mrp']; ?></td>
							   <td>RM <?php echo $row['price']; ?></td>
							   <td><?php echo $row['qty']; ?></td>
							   <td><?php echo $row['pending_qty']; ?></td>
							   <?php
          $productPendingByProductId = $row['pending_qty'];
          $current_qty = $row['qty'] - $productPendingByProductId;
          ?>
							    <td><?php echo $current_qty; ?><br/>
								<td><?php echo $row['sales_qty']; ?></td>
							   
							   </td>
							   <td>
                               <?php
        if ($row['status'] == 1) {?>
            <span class="badge badge-pending"><a href="javascript:void(0)" onclick="confirmRemove('<?php echo $row['id']?>', '<?=$merchant_name?>','status','deactive')">Deactive</a></span>&nbsp;<?php
        } else {?>
           <span class="badge badge-complete"><a href="javascript:void(0)" onclick="confirmRemove('<?php echo $row['id']?>', '<?=$merchant_name?>','status','active')">Active</a></span> &nbsp;<?php
        }
        echo "<span class='badge badge-edit'><a href='manage_product.php?id=" . $row['id'] . "&merchant_name=$merchant_name'>Edit</a></span>&nbsp;";

		?>
		<span class="badge badge-delete"><a href="javascript:void(0)" onclick="confirmRemove('<?php echo $row['id']?>', '<?=$merchant_name?>','delete','delete')">Delete</a></span>
							   </td>
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
<?php require 'footer.inc.php';
?>
<script>

	
function confirmRemove(key, merchantName,type,operation) {
	// Create the modal dialog
	var modal = '    <button type="button" style="display: none" class="btn btn-primary" id="btnModal" data-toggle="modal" data-target="#confirmModal">Large modal</button><div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel">';
	modal += '<div class="modal-dialog" role="document">';
	modal += '<div class="modal-content">';
	modal += '<div class="modal-header">';
	modal += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	modal += '<h4 style="text-transform: capitalize;" class="modal-title" id="confirmModalLabel">'+operation+' Confirmation</h4>';
	modal += '</div>';
	modal += '<div class="modal-body">';
	modal += 'Are you sure you want to '+operation+' this banner?';
	modal += '</div>';
	modal += '<div class="modal-footer">';
	modal += '<a class="btn btn-secondary" style="text-transform: capitalize;" class="btn btn-success" href="?merchant_name='+merchantName+'">Cancel</a>';
	if(operation=='active'){
		modal += '<a style="text-transform: capitalize;" class="btn btn-success" href="?merchant_name='+merchantName+'&type='+type+'&id='+key+'&operation='+operation+'">'+operation+'</a>';
	}else if (operation=='deactive'){
		modal += '<a style="text-transform: capitalize;" class="btn btn-warning" href="?merchant_name='+merchantName+'&type='+type+'&id='+key+'&operation='+operation+'">'+operation+'</a>';
	}else{
		modal += '<a style="text-transform: capitalize;" class="btn btn-danger" href="?merchant_name='+merchantName+'&type='+type+'&id='+key+'&operation='+operation+'">'+operation+'</a>';
	}
	
	// <a href='?merchant_name=$merchant_name&type=delete&id=".$row['id']."'>Delete</a>
	
	
	modal += '</div>';
	modal += '</div>';
	modal += '</div>';
	modal += '</div>';

	// Append the modal to the body
	$('body').append(modal);

	// Show the modal
	// $('#confirmModal').modal('show');
	$("#btnModal").trigger("click");

}
</script>