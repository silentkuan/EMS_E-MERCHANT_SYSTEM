<?php 
ob_start();
require('top.php');
if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']!=""){
    checkProfileInformation($con,$_COOKIE['USER_LOGIN'],$_COOKIE['USER_ID'],$_COOKIE['MERCHANT_ID']);}

if(isset($_GET['id'])){
	$product_id=get_safe_value($con,$_GET['id']);
	if($product_id>0){
		$get_product=get_product($con,'','',$product_id);
	}else{
		?>
		<script>
		window.location.href='index.php?merchant_name=<?=$merchant_name?>';
		</script>
		<?php
	}
	
	$resMultipleImages=mysqli_query($con,"select product_images from product_images where product_id='$product_id'");
	$multipleImages=[];
	if(mysqli_num_rows($resMultipleImages)>0){
		while($rowMultipleImages=mysqli_fetch_assoc($resMultipleImages)){
			$multipleImages[]=$rowMultipleImages['product_images'];
		}
	}
}else{
	?>
	<script>
	window.location.href='index.php?merchant_name=<?=$merchant_name?>';
	</script>
	<?php
}

if(isset($_POST['review_submit'])){
	$rating=get_safe_value($con,$_POST['rating']);
	$review=get_safe_value($con,$_POST['review']);
	
	$added_on=date('Y-m-d h:i:s');
	mysqli_query($con,"insert into product_review(product_id,user_id,rating,review,status,added_on,merchant_id) values('$product_id','".$_COOKIE['USER_ID']."','$rating','$review','1','$added_on','$merchant_id')");
	echo "<script>location.href='product.php?id=" . $product_id . "&merchant_name=" . $merchant_name . "'</script>";
	
	
}


$product_review_res=mysqli_query($con,"SELECT DISTINCT users.name, product_review.id, product_review.rating, product_review.review, product_review.added_on
FROM users
JOIN product_review ON users.uid = product_review.user_id
WHERE product_review.status = 1 AND product_review.product_id = '$product_id'
ORDER BY product_review.added_on DESC;");

?>

 <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: #eee;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php?merchant_name=<?=$merchant_name?>">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <a class="breadcrumb-item" href="categories.php?id=<?php echo $get_product['0']['categories_id']?>&merchant_name=<?=$merchant_name?>"><?php echo $get_product['0']['categories']?></a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active"><?php echo $get_product['0']['name']?></span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Product Details Area -->
        <section class="htc__product__details bg__white ptb--100">
            <!-- Start Product Details Top -->
            <div class="htc__product__details__top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                            <div class="htc__product__details__tab__content">
                                <!-- Start Product Big Images -->
                                <div class="product__big__images">
                                    <div class="portfolio-full-image tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active " id="img-tab-1">
                                            <img  class="img-product" data-origin="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image']?>" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image']?>">
                                        </div>
										
										<?php if(isset($multipleImages[0])){?>
										<div id="multiple_images">
										<?php
										echo "<img  src='".PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image']."' onclick=showMultipleImage('".PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image']."')>";
											
											foreach($multipleImages as $list){
			echo "<img  src='".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list."' onclick=showMultipleImage('".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list."')>";
											}
											?>
											
										</div>
										<?php } ?>
                                    </div>
                                </div>
                                <!-- End Product Big Images -->
                                
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                            <div class="ht__product__dtl">
                                <h2><?php echo $get_product['0']['name']?></h2>
                                <ul  class="pro__prize">
                                    <li class="old__prize">RM<?php echo $get_product['0']['mrp']?></li>
                                    <li>RM<?php echo $get_product['0']['price']?></li>
                                </ul>
                                <p class="pro__info"><?php echo $get_product['0']['short_desc']?></p>
                                <div class="ht__pro__desc">
                                    <div class="sin__desc">
										<?php
										$productPendingByProductId=productPendingByProductId($con,$get_product['0']['id']);
										
										$current_qty=$get_product['0']['qty']-$productPendingByProductId;
										
										$cart_show='yes';
										if($get_product['0']['qty']>$productPendingByProductId && $get_product['0']['qty']> 0 ){
											$stock='In Stock';			
										}else{
											$stock='Not in Stock';
											$cart_show='';
										}
										?>
                                        <p><span>Availability:</span> <?php echo $stock?></p>
                                    </div>
									<div class="sin__desc">
										<?php
										if($cart_show!=''){
										?>
                                        <p><span>Qty:</span> 
										<select id="qty" class="form-control">
											<?php
											for($i=1;$i<=$current_qty;$i++){
												echo "<option>$i</option>";
											}
											?>
										</select>
										</p>
										<?php } ?>
                                    </div>
                                    <div class="sin__desc align--left">
                                        <p><span>Categories:</span></p>
                                        <ul class="pro__cat__list">
                                            <li><a href="categories.php?id=<?=$get_product['0']['id']?>&merchant_name=<?=$merchant_name?>"><?php echo $get_product['0']['categories']?></a></li>
                                        </ul>
                                    </div>
                                    
                                    </div>
									
                                </div>
								<?php
								if($cart_show!=''){
								?>
								<a class="fr__btn" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add','','<?=$merchant_name?>')">Add to cart</a>
								
								<a style="background:#666666 !important;" class="fr__btn buy_now" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add','yes','<?=$merchant_name?>')">Buy Now</a>
								
								<?php } 
								$sharelink=PATH. 'product.php?id='.$get_product['0']['id'].'&merchant_name='.$merchant_name;
								?>
								
								<div id="social_share_box">
									<a href="https://facebook.com/share.php?u=<?=urlencode($sharelink)?>"><img src='images/icons/facebook.png'/></a>
									<a href="https://twitter.com/share?text=<?=urlencode($sharelink)?>"><img src='images/icons/twitter.png'/></a>
									<a href="https://api.whatsapp.com/send?text=<?=urlencode($sharelink)?>"><img src='images/icons/whatsapp.png'/></a>
								</div>
                            </div>
							
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Product Details Top -->
        </section>
        <!-- End Product Details Area 
		<!-- Start Product Description -->
        <section class="htc__produc__decription bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Start List And Grid View -->
                        <ul class="pro__details__tab" role="tablist">
                            <li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">description</a></li>
							<li role="presentation" class="review"><a href="#review" role="tab" data-toggle="tab" class="active show" aria-selected="true">review</a></li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="description" class="pro__single__content tab-pane fade in active">
                                <div class="pro__tab__content__inner">
                                    <span id="desc"><?php 
									$desciption=(str_replace( '\\\\', '', $get_product['0']['description']));
									echo $desciption?></span>
                                </div>
                            </div>
                            <!-- End Single Content -->
                            
							<div role="tabpanel" id="review" class="pro__single__content tab-pane fade active show">
                                <div class="pro__tab__content__inner">
                                    <?php 
									if(mysqli_num_rows($product_review_res)>0){
									
									while($product_review_row=mysqli_fetch_assoc($product_review_res)){
									?>
									
									<article class="row">
										<div class="col-md-12 col-sm-12">
										  <div class="panel panel-default arrow left">
											<div class="panel-body">
											  <header class="text-left">
												<div><span class="comment-rating"> <?php echo $product_review_row['rating']?></span> (<?php echo $product_review_row['name']?>)</div>
												<time class="comment-date"> 
<?php
$added_on=strtotime($product_review_row['added_on']);
echo date('d M Y',$added_on);
?>
												
												
												
												</time>
											  </header>
											  <div class="comment-post">
												<p>
												  <?php echo $product_review_row['review']?>
												</p>
											  </div>
											</div>
										  </div>
										</div>
									</article>
									<?php } }else { 
										echo "<h3 class='submit_review_hint'>No review added</h3><br/>";
									}
									
									
									
									  if(isset($_COOKIE['USER_LOGIN']) ){
										$review_time=mysqli_query($con,"select * FROM `product_review` where product_id='$product_id' AND user_id='".$_COOKIE['USER_ID']."';");
									
									$buystatus=mysqli_query($con,"select order_detail.product_id from order_detail,`order`
									where  `order`.order_id=order_detail.order_id and `order`.user_id='".$_COOKIE['USER_ID']."'
									and order_detail.product_id='$product_id' and `order`.order_status=5
									 and ((`order`.payment_type='Online Banking' and `order`.payment_status='Paid')
									  or (`order`.payment_type='COD' and `order`.payment_status='Paid'))");
									
										if(mysqli_num_rows($review_time)>0){ ?>
											<p class='submit_review_hint'>You already give your review... </p>
											<?php }
											else if(mysqli_num_rows($buystatus)>0){ ?>
											<div class="row" id="post-review-box" style=>
											<div class="col-md-12">
											<p class='submit_review_hint pb--20'>Give Your Review </p> 
											   <form action="" method="post">
												  <select class="form-control" name="rating" required>
													   <option value="">Select Rating</option>
													   <option>Worst</option>
													   <option>Bad</option>
													   <option>Good</option>
													   <option>Very Good</option>
													   <option>Fantastic</option>
												  </select>	<br/>
												  <textarea class="form-control" cols="50" id="new-review" name="review" placeholder="Enter your review here..." rows="5"></textarea>
												  <div class="text-right mt10">
													 <button class="btn btn-success btn-lg" type="submit" name="review_submit">Submit</button>
												  </div>
											   </form>
											</div>
										 </div>
										 <?php	}else{ ?>
											<p class='submit_review_hint'>Give your review after your order is completed... </p>
											<p class='submit_review_hint'>or </p>
											<p class='submit_review_hint'>Buy this product to give your review after you receive the product...</p>
											
											
											<a class="fr__btn" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add','','<?=$merchant_name?>')">Add to cart</a>
								
								<a class="fr__btn buy_now" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add','yes','<?=$merchant_name?>')">Buy Now</a>
													
												</div>
										 <?php }
									
									
									 } else {
										echo "<span class='submit_review_hint'>Please <a href='login.php?merchant_name=$merchant_name'>login</a> to submit your review</span>";
									}
									?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product Description -->
        
		<?php
		//unset($_COOKIE['recently_viewed']);
		if(isset($_COOKIE['recently_viewed'])){
			$arrRecentView=unserialize($_COOKIE['recently_viewed']);
			$countRecentView=count($arrRecentView);
			$countStartRecentView=$countRecentView-4;
			if($countStartRecentView>4){
				$arrRecentView=array_slice($arrRecentView,$countStartRecentView,4);
			}
			$recentViewId=implode(",",$arrRecentView);
			$res=mysqli_query($con,"select * from product where id IN ($recentViewId) and status=1 and merchant_id=$merchant_id");
			
		?>
		<section class="htc__produc__decription bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h3 style="font-size: 20px;font-weight: bold;">Recently Viewed</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <div class="row">
								<?php while($list=mysqli_fetch_assoc($res)){?>
								<div class="col-md-3 ">
									<div class="category">
												<div class="ht__cat__thumb">
													<a href="product.php?id=<?php echo $list['id']?>&merchant_name=<?=$merchant_name?>">
														<img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="product images">
													</a>
												</div>
												<div class="fr__hover__info">
													<ul class="product__action">
														<li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']?>','add')"><i class="icon-heart icons"></i></a></li>
														<li><a href="javascript:void(0)" onclick="manage_cart('<?php echo $list['id']?>','add')"><i class="icon-handbag icons"></i></a></li>
													</ul>
												</div>
												<div class="fr__product__inner">
													<h4><a href="product.php?id=<?php echo $list['id']?>&merchant_name=<?=$merchant_name?>"><?php echo $list['name']?></a></h4>
													<ul class="fr__pro__prize">
														<li class="old__prize"><?php echo $list['mrp']?></li>
														<li><?php echo $list['price']?></li>
													</ul>
												</div>
											</div>
										
								</div>
								<?php } ?>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		<?php 
			$arrRec=unserialize($_COOKIE['recently_viewed']);
			if(($key=array_search($product_id,$arrRec))!==false){
				unset($arrRec[$key]);
			}
			$arrRec[]=$product_id;
		}else{
			$arrRec[]=$product_id;
		}
		setcookie('recently_viewed',serialize($arrRec),time()+60*60*24*365);
		?>
		
			<script>
			function showMultipleImage(im){
				jQuery('#img-tab-1').html("<img  class='img-product' src='"+im+"' data-origin='"+im+"'/>");
				
			}
			

			</script>			
<?php 
require('footer.php');
ob_flush();
?>        

<script>
	$('#desc').html(document.getElementById("desc").innerText.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br />").replaceAll('\\', ""));
	</script>