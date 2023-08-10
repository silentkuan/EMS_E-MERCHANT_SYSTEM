<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');

$pid=get_safe_value($con,$_POST['pid']);
$qty=get_safe_value($con,$_POST['qty']);
$type=get_safe_value($con,$_POST['type']);

$productPendingByProductId=productPendingByProductId($con,$pid);
$productQty=productQty($con,$pid);

$pending_qty=$productQty-$productPendingByProductId;

if($qty>$pending_qty && $type!='remove'){
	echo "not_avaliable";
	die();
}



if($type=='add'){
	addProduct($pid,$qty);
}

if($type=='remove'){
	removeProduct($pid);
}

if($type=='update'){
	updateProduct($pid,$qty);
}

echo totalProduct();
?>