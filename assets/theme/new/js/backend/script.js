(function ($) {
    "use strict";

    $(window).on("load", function () {
        $('.product-slider-active').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.product-slider-thumbnil'
        });
        $('.product-slider-thumbnil').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.product-slider-active',
            dots: false,
            focusOnSelect: true
        });
    });

    $("#addProduct").steps({
        headerTag: "h3",
        bodyTag: ".step-wrapper",
        transitionEffect: "slideLeft",
        labels: {
            current: false,
            pagination: "Pagination",
            finish: "Submit",
            next: "Save & Continue",
            previous: "Previous",
            loading: "Loading ..."
        },
        autoFocus: true,

        onInit: function (event, currentIndex) {

        }
    });


    $('.replyBtn').on('click', function () {
        $('.replymail').slideToggle();
        $('.readmailHiden').slideToggle();
        $('.readmail-Cancle').slideToggle();
    })
    $('.readmoreCancel').on('click', function () {
        $('.replymail').slideToggle();
        $('.readmail-Cancle').slideToggle();
        $('.readmailHiden').slideToggle();
    })

    $('.popup-img').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        },
    });

    $('.video-gallary').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });

    $(".input-style").select2({
        selectOnClose: true
    });

    $(".preloader-wrapper").fadeIn(500, function () {
        $(".preloader-wrapper").fadeOut(2000, function () {

        });
    });


    $('.toggleNav').on('click', function () {
        $('.main-container').toggleClass('active')
    })
    $('.scrollbar-inner').scrollbar();

    var btn = $('.scrollTopBtn');
    $(window).scroll(function () {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });

    btn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, '300');
    });


    $('.business-hour-item .business-hour-left .check label').on('click', function () {
        $(this).closest('.business-hour-item').toggleClass('disabled')
    })

    $('#previewBtn').on('click', function () {
        $('.product-slider-active').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.product-slider-thumbnil'
        });
        $('.product-slider-thumbnil').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.product-slider-active',
            dots: false,
            focusOnSelect: true
        });
    })

    $(document.body).on("click", ".chat-item", function () {
        if (!$(this).hasClass("active")) {
            $(".chat-item.active").removeClass("active");
            $(this).addClass("active");
        };
        $('.chat-box-wrap').addClass('active');
        $('.chat-default-box').hide();
        $('.chat-box-wrap').show();
    });

})(jQuery);