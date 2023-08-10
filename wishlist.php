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

$uid=$_COOKIE['USER_ID'];

$res=mysqli_query($con,"select product.name,product.image,product.price,product.mrp,product.id as pid,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid' and wishlist.merchant_id='$merchant_id'");
?>

 <div class="ht__bradcaump__area" style="background: #eee  ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php?merchant_name=<?=$merchant_name?>">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Wishlist</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="cart-main-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="#">               
                            <div class="table-content table-responsive">
                                <table  id='example' class="table table-hover">
                                    <thead>
                                        <tr class="bg__cat--3">
                                            <th class="product-thumbnail">products</th>
                                            <th class="product-name">name of products</th>
											<th class="product-name">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										while($row=mysqli_fetch_assoc($res)){
										?>
											<tr>
												<td class="product-thumbnail"><a href="#"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']?>"  /></a></td>
												<td class="product-name"><a href="#"><?php echo $row['name']?></a>
													<ul  class="pro__prize">
														<li class="old__prize">RM<?php echo $row['mrp']?></li>
														<li>RM<?php echo $row['price']?></li>
													</ul>
												</td>
												
												
												<td class="product-remove"><a href="wishlist.php?wishlist_id=<?php echo $row['id']?>&merchant_name=<?=$merchant_name?>"><i class="icon-trash icons"></i></a>
                                                <a href="javascript:void(0)" onclick="manage_cart('<?php echo $row['pid']?>','add','','<?=$merchant_name?>')"><i class="icon-handbag icons"></i></a></td>
											</tr>
											<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="buttons-cart--inner">
                                        <div class="buttons-cart">
                                            <a href="<?php echo SITE_PATH?>index.php?merchant_name=<?=$merchant_name?>">Continue Shopping</a>
                                        </div>
                                        <div class="buttons-cart checkout--btn">
                                            <a href="<?php echo SITE_PATH?>checkout.php?merchant_name=<?=$merchant_name?>">checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        
		<input type="hidden" id="qty" value="1"/>						
<?php require('footer.php')?>        