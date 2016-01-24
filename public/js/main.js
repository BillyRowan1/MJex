jQuery(document).ready(function($) {
    $('.nicescroll').niceScroll();
    
    $('#Account a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
    	$('.nicescroll').getNiceScroll().remove();
	    $('.nicescroll').niceScroll();
    });
});
