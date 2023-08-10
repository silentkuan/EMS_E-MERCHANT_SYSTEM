// function send_message() {
// 	var name = jQuery("#name").val();
// 	var email = jQuery("#email").val();
// 	var mobile = jQuery("#mobile").val();
// 	var message = jQuery("#message").val();

// 	if (name == "") {
// 		alert('Please enter name');
// 	} else if (email == "") {
// 		alert('Please enter email');
// 	} else if (mobile == "") {
// 		alert('Please enter mobile');
// 	} else if (message == "") {
// 		alert('Please enter message');
// 	} else {
// 		jQuery.ajax({
// 			url: 'send_message.php',
// 			type: 'post',
// 			data: 'name=' + name + '&email=' + email + '&mobile=' + mobile + '&message=' + message,
// 			success: function (result) {
// 				alert(result);
// 			}
// 		});
// 	}
// }

// function user_register() {
// 	jQuery('.field_error').html('');
// 	var name = jQuery("#name").val();
// 	var email = jQuery("#email").val();
// 	var mobile = jQuery("#mobile").val();
// 	var password = jQuery("#password").val();
// 	var is_error = '';
// 	if (name == "") {
// 		jQuery('#name_error').html('Please enter name');
// 		is_error = 'yes';
// 	} if (email == "") {
// 		jQuery('#email_error').html('Please enter email');
// 		is_error = 'yes';
// 	} if (mobile == "") {
// 		jQuery('#mobile_error').html('Please enter mobile');
// 		is_error = 'yes';
// 	} if (password == "") {
// 		jQuery('#password_error').html('Please enter password');
// 		is_error = 'yes';
// 	}
// 	if (is_error == '') {
// 		jQuery.ajax({
// 			url: 'register_submit.php',
// 			type: 'post',
// 			data: 'name=' + name + '&email=' + email + '&mobile=' + mobile + '&password=' + password,
// 			success: function (result) {
// 				result = result.trim();
// 				if (result == 'email_present') {
// 					jQuery('#email_error').html('Email id already present');
// 				}
// 				if (result == 'mobile_present') {
// 					jQuery('#mobile_error').html('Mobile number already present');
// 				}
// 				if (result == 'insert') {
// 					jQuery('.register_msg p').html('Thank you for registeration');
// 				}
// 			}
// 		});
// 	}

// }


// function user_login() {
// 	jQuery('.field_error').html('');
// 	var email = jQuery("#login_email").val();
// 	var password = jQuery("#login_password").val();
// 	var is_error = '';
// 	if (email == "") {
// 		jQuery('#login_email_error').html('Please enter email');
// 		is_error = 'yes';
// 	} if (password == "") {
// 		jQuery('#login_password_error').html('Please enter password');
// 		is_error = 'yes';
// 	}
// 	if (is_error == '') {
// 		jQuery.ajax({
// 			url: 'login_submit.php',
// 			type: 'post',
// 			data: 'email=' + email + '&password=' + password,
// 			success: function (result) {
// 				result = result.trim();
// 				if (result == 'wrong') {
// 					jQuery('.login_msg p').html('Please enter valid login details');
// 				}
// 				if (result == 'valid') {
// 					window.location.href = window.location.href;
// 				}
// 			}
// 		});
// 	}
// }


function manage_cart(pid, type, is_checkout, merchant_name) {
	console.log(merchant_name);
	if (type == 'update') {
		var qty = jQuery("#" + pid + "qty").val();
	} else {
		var qty = jQuery("#qty").val();
	}
	jQuery.ajax({
		url: 'manage_cart.php?merchant_name=' + merchant_name,
		type: 'post',
		data: 'pid=' + pid + '&qty=' + qty + '&type=' + type,
		success: function (result) {
			result = result.trim();

			if (result == 'not_avaliable') {
				$("#alert-error-message").empty();
				$("#alert-error-message").append("Sorry. This item is out of stock.");
				$("#alert-error-message").show();
				setTimeout(function () { $("#alert-error-message").hide(); }, 1500);
				return;
			} else {
				jQuery('.htc__qua').html(result);
				if (is_checkout == 'yes') {
					window.location.href = 'checkout.php?merchant_name=' + merchant_name;
				}
			}
			if (type == 'add') {
				$("#alert-message").empty();
				$("#alert-message").append("Item is added into the cart.");
				$("#alert-message").show();

				setTimeout(function () { $("#alert-message").hide(); }, 1500);
			}

			if (type == 'update') {
				$("#alert-message").empty();
				$("#alert-message").append("Selected product's quantity is updated into the cart.");
				$("#alert-message").show();

				setTimeout(function () { $("#alert-message").hide(); window.location.href = window.location.href; }, 1500);

			}
			if (type == 'remove') {
				$("#alert-message").empty();
				$("#alert-message").append("Selected product will be removed.");
				$("#alert-message").show();

				setTimeout(function () { $("#alert-message").hide(); window.location.href = window.location.href; }, 1000);


			}
		}
	});
}

function sort_product_drop(cat_id, site_path, merchant_name) {
	var sort_product_id = jQuery('#sort_product_id').val();
	window.location.href = site_path + "categories.php?id=" + cat_id + "&sort=" + sort_product_id + "&merchant_name=" + merchant_name;
}

function wishlist_manage(pid, type, merchant_id, merchant_name) {
	jQuery.ajax({
		url: 'wishlist_manage.php?merchant_name' + merchant_name,
		type: 'post',
		data: 'pid=' + pid + '&type=' + type + '&merchant_id=' + merchant_id,
		success: function (result) {
			result = result.trim();
			if (result == 'not_login') {
				window.location.href = 'login.php';
			} else {
				jQuery('.htc__wishlist').html(result);
			}
			$("#alert-message").empty();
			$("#alert-message").append("Item is added into the wishlist");
			$("#alert-message").show();

			setTimeout(function () { $("#alert-message").hide(); }, 1500);
		}

	});
}

jQuery('.imageZoom').imgZoom();

function confirmRemove(key, merchantName) {
	// Create the modal dialog
	var modal = '    <button type="button" style="display: none" class="btn btn-primary" id="btnModal" data-toggle="modal" data-target="#confirmModal">Large modal</button><div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel">';
	modal += '<div class="modal-dialog" role="document">';
	modal += '<div class="modal-content">';
	modal += '<div class="modal-header">';
	modal += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	modal += '<h4 class="modal-title" id="confirmModalLabel">Confirm Removal</h4>';
	modal += '</div>';
	modal += '<div class="modal-body">';
	modal += 'Are you sure you want to remove this item from the cart?';
	modal += '</div>';
	modal += '<div class="modal-footer">';
	modal += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
	modal += '<button type="button" class="btn btn-danger" onclick="removeCartItem(\'' + key + '\', \'' + merchantName + '\')">Remove</button>';
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

function removeCartItem(key, merchantName) {
	// Perform the actual removal logic here
	manage_cart(key, 'remove', '', merchantName);

	// Close the modal
	$("[data-dismiss=modal]").trigger("click");
}