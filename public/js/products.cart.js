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
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});
});