<?php 
require('top.php');
if(!isset($_COOKIE['USER_LOGIN']) || $_COOKIE['USER_LOGIN']==""){
	?>
	<script>
	window.location.href='index.php?merchant_name=<?=$merchant_name?>';
	</script>
	<?php
}
if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']!=""){
    checkProfileInformation($con,$_COOKIE['USER_LOGIN'],$_COOKIE['USER_ID'],$_COOKIE['MERCHANT_ID']);}

?>
<div class="ht__bradcaump__area" style="#eee;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php?merchant_name=<?=$merchant_name?>">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Thank you for your support</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        
        <div class="wishlist-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="alert-message" class="alert alert-success fade in  ">Your order placed sucessfully. Thank you for your support. Hope you shop with us again.</div>
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                <table id='example' class="table table-hover">
                                    <thead>
                                        <tr class="bg__cat--3">
                                                <th class="product-thumbnail">Order ID</th>
                                                <th class="product-name"><span class="nobr">Order Date</span></th>
                                                <th class="product-price"><span class="nobr"> Address </span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> Payment Type </span></th>
												<th class="product-stock-stauts"><span class="nobr"> Payment Status </span></th>
												<th class="product-stock-stauts"><span class="nobr"> Order Status </span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$uid=$_COOKIE['USER_ID'];
											$res=mysqli_query($con,"select `order`.*,order_status.name as order_status_str from `order`,order_status where `order`.user_id='$uid' and order_status.id=`order`.order_status order by `order`.order_id desc");
											while($row=mysqli_fetch_assoc($res)){
											?>
                                            <tr>
												<td class="product-add-to-cart"><a href="my_order_details.php?order_id=<?php echo $row['order_id']?>&merchant_name=<?=$merchant_name?>"> <?php echo $row['order_id']?></a>
												<!-- <br/>
												<a href="order_pdf.php?order_id=<?php echo $row['order_id']?>"> PDF</a> -->
												</td>
                                                <td class="product-name"><?php echo $row['added_on']?></td>
                                                <td class="product-name">
												<?php echo $row['address']?><br/>
												<?php echo $row['city']?><br/>
												<?php echo $row['pincode']?>
												</td>
												<td class="product-name"><?php echo $row['payment_type']?></td>
												<td class="product-name"><?php echo ucfirst($row['payment_status'])?></td>
												<td class="product-name"><?php echo $row['order_status_str']?></td>
                                                
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        
                                    </table>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        						
<?php require('footer.php')?>        