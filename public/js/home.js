/*============================
 *             HOME
 * ============================*/
// Legal popup:
// Show legal page only first time when user visit the site
jQuery(document).ready(function($) {
    if (localStorage.getItem('mjex.ageRestricted') == null || localStorage.getItem('mjex.ageRestricted') == 'no') {
        $('#legal-page').show();
    } else {
        $('#legal-page').hide();
    }

    $('#legal-page .btn').click(function() {
        if ($(this).hasClass('yes')) {
            $('#legal-page').hide();
            localStorage.setItem('mjex.ageRestricted', 'yes');

            if ($('#legal-page input:checked').length > 0) {
                window.location.href = '/login';
            }
        } else {
            window.location.href = 'about:blank';
            localStorage.setItem('mjex.ageRestricted', 'no');
        }
    });

    // Home sticky banner
    try {
        var stickElemOffsetTop = $('.carousel.sidebar').offset().top;

        function stickyNav() {
            var scrollTop = $(window).scrollTop();
            if (scrollTop >= stickElemOffsetTop) {
                $('.carousel.sidebar').addClass('sticky');
            } else {
                $('.carousel.sidebar').removeClass('sticky');
            }
        }
        $(window).scroll(function(event) {
            stickyNav();
        });
    } catch (e) {
        console.log(e)
    }


});
