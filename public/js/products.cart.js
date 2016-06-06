jQuery(document).ready(function($) {
	$('.btn.add-to-cart').click(function(event) {
		var name = $(this).data('name');
		var id = $(this).data('id');

		$.ajax({
			url: SITE_URL + '/products/add-to-cart',
			type: 'POST',
			data: {name: name, id: id}
		})
		.done(function(res) {
			$('.cart .items').html(res);
		});
	});

	// Delete cart item
	$('body').delegate('.cart .delete','click', function(event) {
		var rowid = $(this).parents('li').data('rowid');
		
		$.ajax({
			url: SITE_URL + '/products/remove-from-cart',
			type: 'POST',
			data: {rowid: rowid}
		})
		.done(function(res) {
			$('.cart .items').html(res);
		});
	});

	// Checkout
	$('#cartCheckout').click(function(event) {
		if($('.cart .items li').length) {
			$.ajax({
				url: SITE_URL + '/products/checkout',
				type: 'POST'
			})
			.done(function(res) {
				$('.cart .items').html(res);
				alert('Your order have been sent');
			});
		}
	});
});