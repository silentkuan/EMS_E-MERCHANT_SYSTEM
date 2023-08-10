<?php
require('functions.inc.php');
if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){

}else{
	echo ("<script>location.href='login.php?merchant_name=<?=$merchant_name?>'</script>");

	die();
}
$categories_id=get_safe_value($con,$_POST['categories_id']);
$sub_cat_id=get_safe_value($con,$_POST['sub_cat_id']);
$stmt = mysqli_prepare($con, "SELECT * FROM sub_categories WHERE categories_id = ? AND status = '1'");
mysqli_stmt_bind_param($stmt, "s", $categories_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $html = '';
    while ($row = mysqli_fetch_assoc($result)) {
        if ($sub_cat_id == $row['id']) {
            $html .= "<option value='" . $row['id'] . "' selected>" . $row['sub_categories'] . "</option>";
        } else {
            $html .= "<option value='" . $row['id'] . "'>" . $row['sub_categories'] . "</option>";
        }
    }
    echo $html;
} else {
    echo "<option value=''>No sub categories found</option>";
}

mysqli_stmt_close($stmt);

?>