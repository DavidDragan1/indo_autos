
(function ($) {
    "use strict";


    $(".preloader-wrapper").fadeIn(500, function () {
        $(".preloader-wrapper").fadeOut(2000, function () {
        });
    });

    $(document).on("click", ".chat-item", function () {
        if (!$(this).hasClass("active")) {
            $(".chat-item.active").removeClass("active");
            $(this).addClass("active");
        };
        $('#your_div').animate({
            scrollTop: $('#your_div')[0].scrollHeight
        }, 500);

        $('.chat-box-wrap').addClass('active')

    });
    $(document).on("click", ".crose-btn", function () {
        $('.chat-box-wrap').removeClass('active')
    });

    $('.toggle-filtar').on("click", function () {
        $('.rearch-result-sidebar .accordion').slideToggle();
    });

    $(".advanceSearch").on('click', function () {
        $(".advance-searchWrap").slideToggle();
    });
    $(".menuTrigger").on('click', function () {
        $(".responsiveMenu").slideToggle();
    });


    $(".input-style").select2({
        selectOnClose: true
    });

    $('.apply-btn').on('click', function () {
        $('.user-details').slideToggle();
        $(this).slideToggle()
    })

    $('.submit-btn-wrap .cancle').on('click', function () {
        $('.user-details').slideToggle();
        $('.apply-btn').slideToggle()
    })

    $('.back-top-home').on('click', function () {
        $('.hidde-daignostic').addClass('d-block');
        $('.show-daignostic').addClass('d-none');
        $('.show-daignostic').removeClass('d-block');
    })


    $(document).on('click', '.nextQs', function () {

    })

    $(document).on('click', '.previusQs', function () {
        $('.questionMainWrap').addClass('d-block');
        $('.questionMainWrapHidden').addClass('d-none');
        $('.questionMainWrapHidden').removeClass('d-block');
    })

    $(function () {
        $('html').smoothScroll(500);
        $('.scrollbar-inner').scrollbar();
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() >= 115) {
            $('.header-area').addClass('fixed-header');
        }
        else {
            $('.header-area').removeClass('fixed-header');
        }
    });

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

    $('.featured-adverts-active').not('.slick-initialized').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        autoplay: false,
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 770,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    infinite: true,
                    arrows: false,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000
                }
            },
        ]
    });
    $('.client-review-active').slick({
        infinite: false,
        arrows: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
    });
    $('.preview').on('click', function (e) {

        function activaTab(tab) {
            $('.preview-tabs a[href="description"]').tab('show');
        };
        activaTab('description');
    });

    $('.popup-img').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        },
    });
    // $('.product-slider-active').not('.slick-initialized').slick({
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     arrows: false,
    //     fade: true,
    //     asNavFor: '.product-details-thumbnil'
    // });
    // $('.product-details-thumbnil').not('.slick-initialized').slick({
    //     slidesToShow: 4,
    //     slidesToScroll: 1,
    //     asNavFor: '.product-slider-active',
    //     dots: false,
    //     focusOnSelect: true
    // });

    $('.special-featured-active').not('.slick-initialized').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        dots: false,
        autoplay: false,
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    arrows: true,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    infinite: true,
                    arrows: false,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                }
            },
        ]
    });

    function activaTab(tab) {
        $('.preview-tabs a[href="description"]').tab('show');
    };
    activaTab('description');

    $('.product-list-edit-wrap').steps();

    $('.daignostic-info').steps();

    $('.video-popup').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });


    $('.write-review-wrap h5').on('click', function () {
        $('.review-form').slideToggle()
    })
    $('.custom-radio li label').on('click', function () {
        $('.accomodationTriggerWrap').show();
    });
    $('.custom-radio li .off').on('click', function () {
        $('.accomodationTriggerWrap').hide();
    });

    $('.reply').on('click', function () {

        $('.reply-form').show();
        $(this).hide();
    })
    $("#example-basic").steps({
        headerTag: "h3",
        bodyTag: ".content",
        transitionEffect: "slideLeft",
        autoFocus: true
    });

})(jQuery);