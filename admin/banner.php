<?php
require "functions.inc.php";
isadmin();
require('top.inc.php');
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
        $update_status_sql = "UPDATE banner SET status = ? WHERE id = ?";
        $stmt = $con->prepare($update_status_sql);
        $stmt->bind_param("ii", $status, $id);
        $stmt->execute();
        $stmt->close();
    }

    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM banner WHERE id = ?";
        $stmt = $con->prepare($delete_sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$sql = "SELECT * FROM banner WHERE merchant_id = ? ORDER BY id ASC";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $merchant_id);
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
				   <h4 class="box-title">Banner </h4>
				   <h4 class="box-link"><a href="manage_banner.php?merchant_name=<?= $merchant_name ?>">Add Banner</a> </h4>
				</div>
				<div class="card-body--">
				<div class="table-stats order-table ov-h pl-4 pr-4 ">
					  <table id='example' class='table table-striped table-bordered'>
						 <thead>
							<tr>
							   
							   <th>Heading1</th>
							   <th>Heading2</th>
							   <th>Button's Text</th>
							   <th>Button's Link</th>
							   <th>Image</th>
							   <th width='30%'></th>
							</tr>
						 </thead>
						 <tbody>
							<?php
       $i = 1;
       while ($row = mysqli_fetch_assoc($res)) { ?>
							<tr>
							   
							   <td><?php echo $row['heading1']; ?></td>
							   <td><?php echo $row['heading2']; ?></td>
							   <td><?php echo $row['btn_txt']; ?></td>
							   <td><?php echo $row['btn_link']; ?></td>
							   <td>
							   <?php echo "<a target='_blank' href='" . BANNER_SITE_PATH . $row['image'] . "'><img width='150px' src='" . BANNER_SITE_PATH . $row['image'] . "'/></a>"; ?>
							   </td>
							   <td>
								<?php
        if ($row['status'] == 1) {?>
            <span class="badge badge-pending"><a href="javascript:void(0)" onclick="confirmRemove('<?php echo $row['id']?>', '<?=$merchant_name?>','status','deactive')">Deactive</a></span>&nbsp;<?php
        } else {?>
           <span class="badge badge-complete"><a href="javascript:void(0)" onclick="confirmRemove('<?php echo $row['id']?>', '<?=$merchant_name?>','status','active')">Active</a></span> &nbsp;<?php
        }
        echo "<span class='badge badge-edit'><a href='manage_banner.php?merchant_name=$merchant_name&id=" . $row['id'] . "'>Edit</a></span>&nbsp;";

		?>
		<span class="badge badge-delete"><a href="javascript:void(0)" onclick="confirmRemove('<?php echo $row['id']?>', '<?=$merchant_name?>','delete','delete')">Delete</a></span>
							   </td>
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