/*!
 * jQuery Smart Banner
 * Copyright (c) 2012 Arnold Daniels <arnold@jasny.net>
 * Based on 'jQuery Smart Web App Banner' by Kurt Zenisek @ kzeni.com
 */
(function (root, factory) {
    if (typeof define == 'function' && define.amd) {
        define(['jquery'], factory);
    } else {
        factory(root.jQuery);
    }
})(this, function ($) {
    var UA = navigator.userAgent;
    var isEdge = /Edge/i.test(UA);

    var SmartBanner = function (options) {
        // Get the original margin-top of the HTML element so we can take that into account.
        this.origHtmlMargin = parseFloat($('html').css('margin-top'));
        this.options = $.extend({}, $.smartbanner.defaults, options);

        // Check if it's already a standalone web app or running within a webui view of an app (not mobile safari).
        var standalone = navigator.standalone;

        // Detect banner type (iOS or Android).
        if (this.options.force) {
            this.type = this.options.force;
        }
        else if (UA.match(/Windows Phone/i) !== null && UA.match(/Edge|Touch/i) !== null) {
            this.type = 'windows';
        }
        else if (UA.match(/iPhone|iPod/i) !== null || (UA.match(/iPad/) && this.options.iOSUniversalApp)) {
            if (UA.match(/Safari/i) !== null &&
                (UA.match(/CriOS/i) !== null ||
                    UA.match(/FxiOS/i) != null ||
                    window.Number(UA.substr(UA.indexOf('OS ') + 3, 3).replace('_', '.')) < 6)) {
                // Check webview and native smart banner support (iOS 6+).
                this.type = 'ios';
            }
        }
        else if (UA.match(/\bSilk\/(.*\bMobile Safari\b)?/) || UA.match(/\bKF\w/) || UA.match('Kindle Fire')) {
            this.type = 'kindle';
        }
        else if (UA.match(/Android/i) !== null) {
            this.type = 'android';
        }
        // Don't show banner if device isn't iOS or Android, website is loaded in app or user dismissed banner.
        if (!this.type || standalone || this.getCookie('sb-closed') || this.getCookie('sb-installed')) {
            return;
        }
        // Calculate scale.
        this.scale = this.options.scale == 'auto' ? $(window).width() / window.screen.width : this.options.scale;
        if (this.scale < 1) {
            this.scale = 1;
        }
        // Get info from meta data.
        var meta = $(
            this.type == 'android'
                ? 'meta[name="google-play-app"]'
                : (this.type == 'ios'
                    ? 'meta[name="apple-itunes-app"]'
                    : (this.type == 'kindle'
                        ? 'meta[name="kindle-fire-app"]'
                        : 'meta[name="msApplication-ID"]'
                    )
                )
        );

        if (!meta.length) {
            return;
        }
        // For Windows Store apps, get the PackageFamilyName for protocol launch.
        if (this.type == 'windows') {
            if (isEdge) {
                this.appId = $('meta[name="msApplication-PackageEdgeName"]').attr('content');
            }
            if (!this.appId) {
                this.appId = $('meta[name="msApplication-PackageFamilyName"]').attr('content');
            }
        }
        else {
            // Try to pull the appId out of the meta tag and store the result.
            var parsedMetaContent = /app-id=([^\s,]+)/.exec(meta.attr('content'));
            if (parsedMetaContent) {
                this.appId = parsedMetaContent[1];
            } else {
                return;
            }
        }
        this.title = this.options.title
            ? this.options.title
            : (meta.data('title') || $('title').text().replace(/\s*[|\-·].*$/, ''));

        this.author = this.options.author
            ? this.options.author
            : (meta.data('author') || ($('meta[name="author"]').length ? $('meta[name="author"]').attr('content') : window.location.hostname));

        this.iconUrl = meta.data('icon-url');
        this.price = meta.data('price');

        // Set default onInstall callback if not set in options.
        if (typeof this.options.onInstall == 'function') {
            this.options.onInstall = this.options.onInstall;
        } else {
            this.options.onInstall = function () { };
        }
        // Set default onClose callback if not set in options.
        if (typeof this.options.onClose == 'function') {
            this.options.onClose = this.options.onClose;
        } else {
            this.options.onClose = function () { };
        }
        // Create banner.
        this.create();
        this.show();
        this.listen();
    };

    SmartBanner.prototype = {

        constructor: SmartBanner,

        create: function () {
            var iconURL;
            var price = this.price || this.options.price;

            var link = this.options.url || (function () {
                switch (this.type) {
                    case 'android':
                        return 'market://details?id=';
                    case 'kindle':
                        return 'amzn://apps/android?asin=';
                    case 'windows':
                        return isEdge
                            ? 'ms-windows-store://pdp/?productid='
                            : 'ms-windows-store:navigate?appid=';
                }
                return 'https://itunes.apple.com/' + this.options.appStoreLanguage + '/app/id';
            }.call(this) + this.appId);

            var inStore = !price ? '' : (function () {
                var result = price + ' - ';
                switch (this.type) {
                    case 'android':
                        return result + this.options.inGooglePlay;
                    case 'kindle':
                        return result + this.options.inAmazonAppStore;
                    case 'windows':
                        return result + this.options.inWindowsStore;
                }
                return result + this.options.inAppStore
            }.call(this));

            var gloss = this.options.iconGloss == null
                ? (this.type == 'ios')
                : this.options.iconGloss;

            if (this.type == 'android' && this.options.GooglePlayParams) {
                link += '&referrer=' + this.options.GooglePlayParams;
            }
            var banner = (
                '<div id="smartbanner" class="' + this.type + '">' +
                '<div class="sb-container">' +
                '<a href="#" class="sb-close">&times;</a>' +
                '<span class="sb-icon"></span>' +
                '<div class="sb-info">' +
                '<strong>' + this.title + '</strong>' +
                '<span>' + this.author + '</span>' +
                '<span>' + inStore + '</span>' +
                '</div>' +
                '<a href="' + link + '" class="sb-button">' +
                '<span>' + this.options.button + '</span>' +
                '</a>' +
                '</div>' +
                '</div>'
            );
            if (this.options.layer) {
                $(this.options.appendToSelector).append(banner);
            } else {
                $(this.options.appendToSelector).prepend(banner);
            }
            if (this.options.icon) {
                iconURL = this.options.icon;
            } else if (this.iconUrl) {
                iconURL = this.iconUrl;
            } else if ($('link[rel="apple-touch-icon-precomposed"]').length > 0) {
                iconURL = $('link[rel="apple-touch-icon-precomposed"]').attr('href');
                if (this.options.iconGloss == null) {
                    gloss = false;
                }
            } else if ($('link[rel="apple-touch-icon"]').length > 0) {
                iconURL = $('link[rel="apple-touch-icon"]').attr('href');
            } else if ($('meta[name="msApplication-TileImage"]').length > 0) {
                iconURL = $('meta[name="msApplication-TileImage"]').attr('content');
            } else if ($('meta[name="msapplication-TileImage"]').length > 0) {
                // Redundant because ms docs show two case usages.
                iconURL = $('meta[name="msapplication-TileImage"]').attr('content');
            }
            if (iconURL) {
                $('#smartbanner .sb-icon').css('background-image', 'url(' + iconURL + ')');
                if (gloss) {
                    $('#smartbanner .sb-icon').addClass('gloss');
                }
            } else {
                $('#smartbanner').addClass('no-icon');
            }
            this.bannerHeight = $('#smartbanner').outerHeight() + 2;

            if (this.scale > 1) {
                $('#smartbanner')
                    .css('top', parseFloat($('#smartbanner').css('top')) * this.scale)
                    .css('height', parseFloat($('#smartbanner').css('height')) * this.scale)
                    .hide();
                $('#smartbanner .sb-container')
                    .css('-webkit-transform', 'scale(' + this.scale + ')')
                    .css('-msie-transform', 'scale(' + this.scale + ')')
                    .css('-moz-transform', 'scale(' + this.scale + ')')
                    .css('width', $(window).width() / this.scale);
            }
            $('#smartbanner')
                .css('position', this.options.layer ? 'absolute' : 'static');
        },

        listen: function () {
            $('#smartbanner .sb-close').on('click', $.proxy(this.close, this));
            $('#smartbanner .sb-button').on('click', $.proxy(this.install, this));
        },

        show: function (callback) {
            var banner = $('#smartbanner');
            banner.stop();

            if (this.options.layer) {
                banner
                    .animate({ top: 0, display: 'block' }, this.options.speedIn)
                    .addClass('shown')
                    .show();
                $('body').animate().addClass('smartbanner-open')
                $(this.pushSelector)
                    .animate({
                        paddingTop: this.origHtmlMargin + (this.bannerHeight * this.scale)
                    }, this.options.speedIn, 'swing', callback);
            }
            else {
                if ($.support.transition) {
                    banner.animate({ top: 0 }, this.options.speedIn).addClass('shown');
                    var transitionCallback = function () {
                        $('html').removeClass('sb-animation');
                        if (callback) {
                            callback();
                        }
                    };
                    $(this.pushSelector)
                        .addClass('sb-animation')
                        .one($.support.transition.end, transitionCallback)
                        .emulateTransitionEnd(this.options.speedIn)
                        .css('margin-top', this.origHtmlMargin + (this.bannerHeight * this.scale));
                }
                else {
                    banner
                        .slideDown(this.options.speedIn)
                        .addClass('shown');
                    $('body').animate().addClass('smartbanner-open')

                }
            }
        },

        hide: function (callback) {
            var banner = $('#smartbanner');
            banner.stop();
            $('body').animate().removeClass('smartbanner-open')

            if (this.options.layer) {
                banner.animate({
                    top: -1 * this.bannerHeight * this.scale,
                    display: 'block'
                }, this.options.speedIn)
                    .removeClass('shown');
                $('body').animate().removeClass('smartbanner-open')


                $(this.pushSelector)
                    .animate({
                        paddingTop: this.origHtmlMargin
                    }, this.options.speedIn, 'swing', callback);
            }
            else {
                if ($.support.transition) {
                    if (this.type !== 'android') {
                        banner
                            .css('top', -1 * this.bannerHeight * this.scale)
                            .removeClass('shown');
                        $('body').animate().removeClass('smartbanner-open')

                    }
                    else {
                        banner
                            .css({ display: 'none' })
                            .removeClass('shown');
                        $('body').animate().removeClass('smartbanner-open')

                    }
                    var transitionCallback = function () {
                        $('html').removeClass('sb-animation');
                        if (callback) {
                            callback();
                        }
                    };
                    $(this.pushSelector)
                        .addClass('sb-animation')
                        .one($.support.transition.end, transitionCallback)
                        .emulateTransitionEnd(this.options.speedOut)
                        .css('margin-top', this.origHtmlMargin);
                }
                else {
                    banner.slideUp(this.options.speedOut).removeClass('shown');
                }
            }
        },

        close: function (e) {
            e.preventDefault();
            this.hide();
            this.setCookie('sb-closed', 'true', this.options.daysHidden);
            this.options.onClose(e);
        },

        install: function (e) {
            if (this.options.hideOnInstall) {
                this.hide();
            }
            this.setCookie('sb-installed', 'true', this.options.daysReminder);
            this.options.onInstall(e);
        },

        setCookie: function (name, value, exdays) {
            var exdate = new Date();
            exdate.setDate(exdate.getDate() + exdays);
            value = encodeURI(value) + ((exdays == null) ? '' : '; expires=' + exdate.toUTCString());
            document.cookie = name + '=' + value + '; path=/;';
        },

        getCookie: function (name) {
            var i, x, y, ARRcookies = document.cookie.split(';');
            for (i = 0; i < ARRcookies.length; i++) {
                x = ARRcookies[i].substr(0, ARRcookies[i].indexOf('='));
                y = ARRcookies[i].substr(ARRcookies[i].indexOf('=') + 1);
                x = x.replace(/^\s+|\s+$/g, '');
                if (x == name) {
                    return decodeURI(y);
                }
            }
            return null;
        },

        // Demo only.
        switchType: function () {
            var that = this;

            this.hide(function () {
                that.type = that.type == 'android' ? 'ios' : 'android';
                var meta = $(that.type == 'android' ? 'meta[name="google-play-app"]' : 'meta[name="apple-itunes-app"]').attr('content');
                that.appId = /app-id=([^\s,]+)/.exec(meta)[1];

                $('#smartbanner').detach();
                that.create();
                that.show();
            });
        }
    };

    $.smartbanner = function (option) {
        var $window = $(window);
        var data = $window.data('smartbanner');
        var options = typeof option == 'object' && option;
        if (!data) {
            $window.data('smartbanner', (data = new SmartBanner(options)));
        }
        if (typeof option == 'string') {
            data[option]();
        }
    };

    // override these globally if you like (they are all optional)
    $.smartbanner.defaults = {
        title: null, // What the title of the app should be in the banner (defaults to <title>)
        author: null, // What the author of the app should be in the banner (defaults to <meta name="author"> or hostname)
        price: 'FREE', // Price of the app
        appStoreLanguage: 'us', // Language code for App Store
        inAppStore: 'On the App Store', // Text of price for iOS
        inGooglePlay: 'In Google Play', // Text of price for Android
        inAmazonAppStore: 'In the Amazon Appstore',
        inWindowsStore: 'In the Windows Store', //Text of price for Windows
        GooglePlayParams: null, // Aditional parameters for the market
        icon: null, // The URL of the icon (defaults to <meta name="apple-touch-icon">)
        iconGloss: null, // Force gloss effect for iOS even for precomposed
        button: 'VIEW', // Text for the install button
        url: null, // The URL for the button. Keep null if you want the button to link to the app store.
        scale: 'auto', // Scale based on viewport size (set to 1 to disable)
        speedIn: 300, // Show animation speed of the banner
        speedOut: 400, // Close animation speed of the banner
        daysHidden: 15, // Duration to hide the banner after being closed (0 = always show banner)
        daysReminder: 90, // Duration to hide the banner after "VIEW" is clicked *separate from when the close button is clicked* (0 = always show banner)
        force: null, // Choose 'ios', 'android' or 'windows'. Don't do a browser check, just always show this banner
        hideOnInstall: true, // Hide the banner after "VIEW" is clicked.
        layer: false, // Display as overlay layer or slide down the page
        iOSUniversalApp: true, // If the iOS App is a universal app for both iPad and iPhone, display Smart Banner to iPad users, too.
        appendToSelector: 'body', //Append the banner to a specific selector
        pushSelector: 'html' // What element is going to push the site content down; this is where the banner append animation will start.
    };

    $.smartbanner.Constructor = SmartBanner;

    // ============================================================
    // Bootstrap transition
    // Copyright 2011-2014 Twitter, Inc.
    // Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)

    function transitionEnd() {
        var el = document.createElement('smartbanner');

        var transEndEventNames = {
            WebkitTransition: 'webkitTransitionEnd',
            MozTransition: 'transitionend',
            OTransition: 'oTransitionEnd otransitionend',
            transition: 'transitionend'
        };

        for (var name in transEndEventNames) {
            if (el.style[name] !== undefined) {
                return { end: transEndEventNames[name] };
            }
        }
        // Explicit for ie8.
        return false;
    }
    if ($.support.transition !== undefined) {
        // Prevent conflict with Twitter Bootstrap.
        return;
    }

    // http://blog.alexmaccaw.com/css-transitions
    $.fn.emulateTransitionEnd = function (duration) {
        var called = false, $el = this;
        $(this).one($.support.transition.end, function () {
            called = true;
        });
        var callback = function () {
            if (!called) {
                $($el).trigger($.support.transition.end);
            }
        };
        setTimeout(callback, duration);
        return this;
    };

    $(function () {
        $.support.transition = transitionEnd();
    });
    // ============================================================
});
