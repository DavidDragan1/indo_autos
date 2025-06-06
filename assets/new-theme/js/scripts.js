(function ($) {
	'use strict';

	$(document).on('click', '.show-password', function () {
		let input = $($(this).parent('.input-password').find('input'));
		if (input.attr('type') == 'password') {
			input.attr('type', 'text');
			$(this).text('visibility_off');
		} else {
			input.attr('type', 'password');
			$(this).text('visibility');
		}
	});

	$('.play-video').magnificPopup({
		disableOn: 700,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false,
	});

	$('.popup-img').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true,
		},
	});

	var btn = $('.scrollTopBtn');
	$(window).scroll(function () {
		if ($(window).scrollTop() > 300) {
			btn.addClass('show');
			$('.seller-popup').css('bottom', '80px');
		} else {
			$('.seller-popup').css('bottom', '10px');
			btn.removeClass('show');
		}
	});
	btn.on('click', function (e) {
		e.preventDefault();
		$('html, body').animate({ scrollTop: 0 }, '300');
	});
	$('.preview_profile').hide();
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$(input).parents('.upload-img').find('.preview_profile').show();
				$(input).parents('.upload-img').find('.preview_profile').attr('src', e.target.result);
				$(input).parent('.upload_btn-wrap').css('opacity', 0);

				// $(input).parent('.upload_btn-wrap').css('opacity', '.5')
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

	$(document).on('change', '.upload_btn-wrap input', function () {
		readURL(this);
	});

	$('input[type="tel"],.number').on('keyup',function (e) {
		if (/\D/g.test(this.value)) {
			this.value = this.value.replace(/\D/g, '');
		}
	});

	$('.responsive-menu-admin').on('click', function () {
		$('.sidebar-nav').toggleClass('show');
		$(this).toggleClass('active');
		$('.backdrop-body-admin,.cancel-menu').css('display', 'block');
	});
	$('.backdrop-body-admin,.cancel-menu').on('click', function () {
		$('.backdrop-body-admin').css('display', 'none');
		$('.cancel-menu').css('display', 'none');
		$('.sidebar-nav').removeClass('show');
		$('.responsive-menu-admin').toggleClass('active');
	});

	// jquery scroll bar
	$('.scrollbar-inner,.chat_box-scrollbar').scrollbar();

	// material
	$('.tabs').tabs();
	$('.collapsible').collapsible();
	$('.collapsible.expandable').collapsible({
		accordion: false,
	});
	// $('.modal').modal({ dismissible: false });

	M.Modal.prototype._handleFocus = function (e) {
		// Only trap focus if this modal is the last model opened (prevents loops in nested modals).
		if (!this.el.contains(e.target) && this._nthModalOpened === M.Modal._modalsOpen) {
			var s2 = 'select2-search__field';
			if (e.target.className.indexOf(s2) < 0) {
				this.el.focus();
			}
		}
	};
    $(document).on('click','#chat_list li',function(){
        $('html,body').animate({
            scrollTop: $(".chat_box-wrap").offset().top + 200},
            'slow');
    })
	$('.modal').modal();
	$('.dropdown-profile').dropdown();
	$('.select2-item').select2({ width: '100%' });
	$('.material-select').formSelect();
	$('.tooltipped').tooltip();
})(jQuery);
