<?php
require "functions.inc.php";
require('top.inc.php');
ob_start();
// isAdmin();
$username = '';
$password = '';
$email = '';
$mobile = '';
$role_id = '';

$msg = '';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $stmt = mysqli_prepare($con, "SELECT * FROM employee WHERE id = ? AND merchant_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id, $merchant_id);
    
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    $check = mysqli_num_rows($res);

    mysqli_stmt_close($stmt);

    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $username = $row['username'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $password = $row['password'];
        $role_id = $row['role_id'];
    } else {
        echo "<script>location.href='vendor_management.php?merchant_name=$merchant_name</script>";

        die();
    }
}

if (isset($_POST['submit'])) {
    $username = get_safe_value($con, $_POST['username']);
    $email = get_safe_value($con, $_POST['email']);
    $mobile = get_safe_value($con, $_POST['mobile']);
    $password = get_safe_value($con, $_POST['password']);
    $role_id = get_safe_value($con, $_POST['role_id']);

    $hash_variable_salt = password_hash($password, PASSWORD_DEFAULT, ['cost' => 9]);

    $stmt = mysqli_prepare($con, "SELECT * FROM employee WHERE username = ? AND merchant_id = ?");
mysqli_stmt_bind_param($stmt, "si", $username, $merchant_id);

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    $check = mysqli_num_rows($res);

    mysqli_stmt_close($stmt);

    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
            } else {
                $msg = "Username already exist";
            }
        } else {
            $msg = "Username already exist";
        }
    }

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            if ($password == "") {
                $stmt = mysqli_prepare($con, "UPDATE employee SET username=?, 
                email=?, mobile=?, role_id=? WHERE id=?");
                mysqli_stmt_bind_param($stmt, "sssii", $username, $email, $mobile, $role_id, $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else {
                $stmt = mysqli_prepare($con, "UPDATE employee SET username=?,
                 password=?, email=?, mobile=?, role_id=? WHERE id=?");
                mysqli_stmt_bind_param($stmt, "ssssii", $username, $hash_variable_salt, $email, $mobile, $role_id, $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        } else {
            $stmt = mysqli_prepare($con, "INSERT INTO employee (username, password, 
            email, mobile, role_id, status,merchant_id) VALUES (?, ?, ?, ?, ?, 1,?)");
            mysqli_stmt_bind_param($stmt, "sssssi", $username, $hash_variable_salt, $email, $mobile, $role_id,$merchant_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        echo "<script>location.href='vendor_management.php?merchant_name=$merchant_name'</script>";
        die();
    }
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Employees Management</strong><small> Form</small></div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
							   
								
								<div class="form-group">
									<label for="username" class=" form-control-label">Username</label>
									<input type="text" name="username" placeholder="Enter username" class="form-control" required value="<?php echo $username; ?>">
								</div>
								<div class="form-group">
									<label for="password" class=" form-control-label">Password</label>
									<input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters" placeholder="<?php if ($password != '') {
             echo 'Enter a new password';
         } else {
             echo 'Enter password';
         } ?>" class="form-control"  value="<?php if ($password != '') {
    echo '';
} ?>">
								</div>
								
								<div class="form-group">
									<label for="email" class=" form-control-label">Email</label>
									<input type="email" name="email" placeholder="Enter email" class="form-control" required value="<?php echo $email; ?>">
								</div>
								<div class="form-group">
									<label for="mobile" class=" form-control-label">Mobile</label>
									<input type="text" name="mobile" placeholder="Enter mobile" class="form-control" required value="<?php echo $mobile; ?>">
								</div>

								<div class="form-group">
										<label for="position" class=" form-control-label">Role</label>
										<select class="form-control" name="role_id" id="role_id" onchange="get_sub_cat('')" required>
											<option>Select Role</option>
											<?php
           $res = mysqli_query($con, "select id,role_name from role order by role_name asc");
           while ($row = mysqli_fetch_assoc($res)) {
               if ($row['id'] == $role_id) {
                   echo "<option selected value=" . $row['id'] . ">" . $row['role_name'] . "</option>";
               } else {
                   echo "<option value=" . $row['id'] . ">" . $row['role_name'] . "</option>";
               }
           }
           ?>
										</select>
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
		 
		 
         
<?php require 'footer.inc.php';
?>
