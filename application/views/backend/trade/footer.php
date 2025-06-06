</div>
</div>

<?php
$CI =& get_instance();
$CI->session->unset_userdata('status');

?>

<script type="text/javascript" src="assets/new-theme/js/materialize.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/intlTelInput.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.validate.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.magnific-popup.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.scrollbar.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/slick.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/splide.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/highcharts.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/dataTables.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/datatable.responsive.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/scripts.js?t=<?php echo time(); ?>"></script>
<script>
    $(document).on('click', '.quicklink', function () {
        $(this).toggleClass('active')
        $('.quickmenu-wrapper').toggleClass('active')
        $('.moremenu-area').removeClass('active');
        $('.search-area').removeClass('active');
        $('.menu-trigger').removeClass('active');
    })
    $('.moremenu').on('click', function () {
        $('.moremenu-area').toggleClass('active');
        $('.search-area').removeClass('active');
        $('.search-btn').removeClass('active');
    })
</script>
<script>
    var last_date_time = '';
    function chat_message_format(chat_date) {

        if (moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY') == moment().format('MMM Do YY')){
            if (last_date_time !== moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY')){
                last_date_time = moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY');
                return 'Today';
            }
        } else {
            if (last_date_time !== moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY')) {
                last_date_time = moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY');
                if (moment().subtract(1, 'days').format('MMM Do YY') === moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY')) {
                    return 'Yesterday'
                } else if (moment().subtract(2, 'days').format('MMM Do YY') === moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY')) {
                    return moment(chat_date.timestamp).format('dddd')
                } else if (moment().subtract(3, 'days').format('MMM Do YY') === moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY')) {
                    return moment(chat_date.timestamp).format('dddd')
                } else if (moment().subtract(4, 'days').format('MMM Do YY') === moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY')) {
                    return moment(chat_date.timestamp).format('dddd')
                } else if (moment().subtract(5, 'days').format('MMM Do YY') === moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY')) {
                    return moment(chat_date.timestamp).format('dddd')
                } else if (moment().subtract(6, 'days').format('MMM Do YY') === moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY')) {
                    return moment(chat_date.timestamp).format('dddd')
                } else {
                    return moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY')
                }
            }
        }
    }
</script>
<script>
    (function (window, document, undefined) {

        var factory = function ($, DataTable) {
            "use strict";

            $('.search-toggle').click(function () {
                if ($('.hiddensearch').css('display') == 'none')
                    $('.hiddensearch').slideDown();
                else
                    $('.hiddensearch').slideUp();
            });

            /* Set the defaults for DataTables initialisation */
            $.extend(true, DataTable.defaults, {
                dom: "<'hiddensearch'f'>" +
                    "tr" +
                    "<'table-footer'lip'>",
                renderer: 'material'
            });

            /* Default class modification */
            $.extend(DataTable.ext.classes, {
                sWrapper: "dataTables_wrapper",
                sFilterInput: "form-control input-sm",
                sLengthSelect: "form-control input-sm"
            });

            /* Bootstrap paging button renderer */
            DataTable.ext.renderer.pageButton.material = function (settings, host, idx, buttons, page, pages) {
                var api = new DataTable.Api(settings);
                var classes = settings.oClasses;
                var lang = settings.oLanguage.oPaginate;
                var btnDisplay, btnClass, counter = 0;

                var attach = function (container, buttons) {
                    var i, ien, node, button;
                    var clickHandler = function (e) {
                        e.preventDefault();
                        if (!$(e.currentTarget).hasClass('disabled')) {
                            api.page(e.data.action).draw(false);
                        }
                    };

                    for (i = 0, ien = buttons.length; i < ien; i++) {
                        button = buttons[i];

                        if ($.isArray(button)) {
                            attach(container, button);
                        } else {
                            btnDisplay = '';
                            btnClass = '';

                            switch (button) {

                                case 'first':
                                    btnDisplay = lang.sFirst;
                                    btnClass = button + (page > 0 ?
                                        '' : ' disabled');
                                    break;

                                case 'previous':
                                    btnDisplay = '<i class="material-icons">chevron_left</i>';
                                    btnClass = button + (page > 0 ?
                                        '' : ' disabled');
                                    break;

                                case 'next':
                                    btnDisplay = '<i class="material-icons">chevron_right</i>';
                                    btnClass = button + (page < pages - 1 ?
                                        '' : ' disabled');
                                    break;

                                case 'last':
                                    btnDisplay = lang.sLast;
                                    btnClass = button + (page < pages - 1 ?
                                        '' : ' disabled');
                                    break;

                            }

                            if (btnDisplay) {
                                node = $('<li>', {
                                    'class': classes.sPageButton + ' ' + btnClass,
                                    'id': idx === 0 && typeof button === 'string' ?
                                        settings.sTableId + '_' + button : null
                                })
                                    .append($('<a>', {
                                            'href': '#',
                                            'aria-controls': settings.sTableId,
                                            'data-dt-idx': counter,
                                            'tabindex': settings.iTabIndex
                                        })
                                            .html(btnDisplay)
                                    )
                                    .appendTo(container);

                                settings.oApi._fnBindAction(
                                    node, {
                                        action: button
                                    }, clickHandler
                                );

                                counter++;
                            }
                        }
                    }
                };

                // IE9 throws an 'unknown error' if document.activeElement is used
                // inside an iframe or frame.
                var activeEl;

                try {
                    // Because this approach is destroying and recreating the paging
                    // elements, focus is lost on the select button which is bad for
                    // accessibility. So we want to restore focus once the draw has
                    // completed
                    activeEl = $(document.activeElement).data('dt-idx');
                } catch (e) { }

                attach(
                    $(host).empty().html('<ul class="material-pagination"/>').children('ul'),
                    buttons
                );

                if (activeEl) {
                    $(host).find('[data-dt-idx=' + activeEl + ']').focus();
                }
            };

            /*
             * TableTools Bootstrap compatibility
             * Required TableTools 2.1+
             */
            if (DataTable.TableTools) {
                // Set the classes that TableTools uses to something suitable for Bootstrap
                $.extend(true, DataTable.TableTools.classes, {
                    "container": "DTTT btn-group",
                    "buttons": {
                        "normal": "btn btn-default",
                        "disabled": "disabled"
                    },
                    "collection": {
                        "container": "DTTT_dropdown dropdown-menu",
                        "buttons": {
                            "normal": "",
                            "disabled": "disabled"
                        }
                    },
                    "print": {
                        "info": "DTTT_print_info"
                    },
                    "select": {
                        "row": "active"
                    }
                });

                // Have the collection use a material compatible drop down
                $.extend(true, DataTable.TableTools.DEFAULTS.oTags, {
                    "collection": {
                        "container": "ul",
                        "button": "li",
                        "liner": "a"
                    }
                });
            }

        }; // /factory

        // Define as an AMD module if possible
        if (typeof define === 'function' && define.amd) {
            define(['jquery', 'datatables'], factory);
        } else if (typeof exports === 'object') {
            // Node/CommonJS
            factory(require('jquery'), require('datatables'));
        } else if (jQuery) {
            // Otherwise simply initialise as normal, stopping multiple evaluation
            factory(jQuery, jQuery.fn.dataTable);
        }

    })(window, document);



    function tosetrMessage(type, message) {
        $('.tostfyMessage').css({ "bottom" : "auto", "top": "5", "visibility": "visible", "opacity": 1 });
        $('.tostfyMessage').find('.messageValue').text(message);
        if (type === 'success') {
            $('.tostfyMessage').css('background', 'rgb(76, 175, 80)')
        } else if (type === 'warning') {
            $('.tostfyMessage').css('background', 'rgb(255, 152, 0)')
        } else if (type === 'error') {
            $('.tostfyMessage').css('background', 'rgb(244, 67, 54)')
        }
        setTimeout(function () {
            $('.tostfyMessage').css({ "bottom" : "auto", "top": "0", "visibility": "hidden", "opacity": 0 })
        }, 5000);
        $('.tostfyClose').on('click', function () {
            $('.tostfyMessage').css({ "bottom" : "auto", "top": "0", "visibility": "hidden", "opacity": 0 })
        })
    }

    $(document).ready(function () {
        setTimeout(function () {
            $('.tostfyMessage').css({"bottom" : "auto", "top": "0", "visibility": "hidden", "opacity": 0 })
        }, 5000);

        $('.tostfyClose').on('click', function () {
            $('.tostfyMessage').css({ "bottom" : "auto", "top": "0", "visibility": "hidden", "opacity": 0 })
        })
    })
    $(document).on('click','#chat_list li',function(){
        $('html,body').animate({
            scrollTop: $(".chat_box-wrap").offset().top + 200},
            'slow');
    })
</script>
</body>

</html>
