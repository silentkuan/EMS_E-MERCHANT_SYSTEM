<?php 
require('top.php');
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']=='yes'){

	?>
	<script>
	window.location.href='my_order.php?merchant_name=<?=$merchant_name?>';
	</script>
	<?php
}
?>


        
		<!-- Start Contact Area -->
        <section class="htc__contact__area ptb--100 bg__white">
			<div class="container">
			<div class="col-md-7 col-md-offset-2">
		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Login Your Account</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" role="form">
                    <fieldset>
			    	  	<div class="form-group">
							<label>Your Phone Number:</label>
			    		    <input class="form-control" placeholder="+60132323323" name="phone_number" type="text">
			    		</div>
			    		<div class="form-group">
						<label>OTP:</label>
			    			<input class="form-control" placeholder="123123" name="opt" type="text" >
			    		</div>
			    		<div class="pb--15">
			    	    	
			    	    		<a class="text-danger" href="" >Request OPT</a>
			    	    	
			    	    </div>
                        
			    		<input class="btn  btn-primary btn-block" type="submit" value="Sign in with Phone Number">
						<a href="login_test.php" class="btn  btn-info btn-block">Back</a>
			    	</fieldset>
			      	</form>
                      <hr/>
                    <center><h4>OR</h4></center>
					<br>
                    <input class="btn  btn-facebook btn-block" type="submit" value="Sign in with Facebook">
					<input class="btn  btn-google btn-block" type="submit" value="Sign in with Google">
				
			    </div>
			</div>
</div>
</div>
		</section>
		
		
<?php require('footer.php')?>        