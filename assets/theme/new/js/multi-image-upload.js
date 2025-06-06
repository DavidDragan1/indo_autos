/*
jQuery Image upload
Images can be uploaded using:
* File requester (Double click on box)
* Drag&Drop (Drag and drop image on box)
* Pasting. (Copy an image or make a screenshot, then activate the page and paste in the image.)

Works in Mozilla, Webkit & IE.
*/

(function ($) {
    $.fn.imageUpload = function (options) {
        var settings = $.extend({
            outputHandler: function () { }, // Callback function for processing output. Parameter is image source in base64 format
            onBeforeUpload: function () { },// Callback function called before upload processing
            onAfterUpload: function () { },	// Callback function called after upload processing
            maxUpload: 3,				// Max number of image files allowed to be uploaded.
            errorMsg: 'Error: The file you just uploaded is not an image!',
            trigger: 'click', 			// possible values: "click", "dblclick" or null
            errorContainer: null,		// Container for error message
            enableCliboardCapture: true, // Enable clipboard capturing
            enableDebug: true			// enable debugging output in console
        }, options);

        var $this = $(this), dragging = false, pasting = false;

        var $uploadField = $('<input type="file" style="display:none" name="fileselect[]" multiple="multiple" accept="image/*, .gif, .png, .jpg" />');

        // Create capture area for Mozilla & IE
        var $contentEditable = $('<div contenteditable="true" style="position:absolute;overflow:hidden;top:-20px;width:0;height:0;" />');

        // Get file type from image data uri.
        var getFileExtension = function (imgSrc) { return imgSrc.replace(/data:image\/([^;]*).*/ig, ".$1"); };

        // Get mime type from data uri.
        var getFileType = function (imgSrc) { return imgSrc.replace(/data:([^;]*).*/ig, "$1"); };

        // Error display
        var errorHandler = function (error) {
            if (error && settings.errorContainer !== null) {
                settings.errorContainer.html(settings.errorMsg).fadeIn(1000, function () {
                    $(this).delay(5000).fadeOut(1000);
                });
            }
        };

        var readFile = function (file) {
            var reader = new FileReader();
            $(reader).on('load', file, function (e) {
                var returnValue = {
                    name: (e.data.name ? e.data.name : 'CB_Image_' + (+new Date()) + getFileExtension(e.target.result)),
                    type: (e.data.type ? e.data.type : getFileType(e.target.result)),
                    size: (e.data.size ? e.data.size : 'n/a'),
                    imgSrc: e.target.result
                };
                // Execute outputHandler callback function if available
                $.isFunction(settings.outputHandler) && settings.outputHandler.call(this, returnValue);
                // Execute onAfterUpload callback function if available
                $.isFunction(settings.onAfterUpload) && settings.onAfterUpload.call(this);
            });
            reader.readAsDataURL(file);
        };

        // Upload processing
        var processUpload = function (files, originalEvent) {
            var error = false, imageFound = false, count = 0;
            if (files !== null) {
                for (var i = 0; i < files.length; i++) {
                    if (files[i].type.indexOf("image") == -1) {
                        //not image
                        error = true;
                        continue;
                    }
                    if (count == settings.maxUpload) break; // Max reached
                    count++;
                    imageFound = true;

                    // Webkit clipboard data needs data converted through getAsFile()
                    var blob = (typeof originalEvent !== 'undefined' && !originalEvent.msConvertURL) ? files[i].getAsFile() : files[i];

                    readFile(blob);
                }
                if (!imageFound) {
                    // Execute onAfterUpload callback function if available
                    $.isFunction(settings.onAfterUpload) && settings.onAfterUpload.call(this);
                }
                errorHandler(error);
            }
        };

        // Alternate clipboard capturing function for Mozilla
        var mozillaCaptureFunc = function () {
            pasting = false;
            var img = $contentEditable.find('img'), error = true;
            if (img.length) {
                error = false;
                var returnValue = {
                    name: 'CB_Image_' + (+new Date()) + getFileExtension(img[0].src),
                    type: getFileType(img[0].src),
                    size: 'n/a',
                    imgSrc: img[0].src
                };
                // Execute outputHandler callback function if available
                $.isFunction(settings.outputHandler) && settings.outputHandler.call(this, returnValue);
            }
            // Remove "input" event handler and clear capture area
            $contentEditable.off('input', mozillaCaptureFunc).text('');
            errorHandler(error);
            // Execute onAfterUpload callback function if available
            $.isFunction(settings.onAfterUpload) && settings.onAfterUpload.call(this);
        };

        // Paste handler
        var pasteHandlerFunc = function (e) {

            // Remove existing Mozilla "input" event handler
            $contentEditable.off('input', mozillaCaptureFunc);

            // Execute onBeforeUpload callback function if available
            $.isFunction(settings.onBeforeUpload) && settings.onBeforeUpload.call(this);

            var clipboardData = e.originalEvent.clipboardData || window.clipboardData;
            if (clipboardData === false || clipboardData === undefined) {
                // empty
                // Execute onAfterUpload callback function if available
                $.isFunction(settings.onAfterUpload) && settings.onAfterUpload.call(this);
                pasting = false;
                return false;
            }

            var files = clipboardData.items || clipboardData.files;

            // No Items or files, so either nothing in clipboard or Mozilla browser
            if (files.length === 0) {
                // Enable "input" event handler for Mozilla, and set focus
                $contentEditable.on('input', mozillaCaptureFunc).focus();
            }
            else {
                pasting = false;
                processUpload(files, e.originalEvent);
                e.preventDefault();
            }
        };

        // Alternate triggering metod for clipboard capturing, required for IE & Mozilla
        var keydownHandlerFunc = function (e) {
            if (!pasting && (e.ctrlKey || e.metaKey) && e.which == 86) {
                pasting = true;
                $contentEditable.focus();
            }
        };

        // Alternative to css :hover, adding class "dropzonehover" to body tag.
        var mouseenterHandlerFunc = function (e) {
            e.preventDefault();
            if (!$('body').hasClass('dragging')) $('body').addClass('dropzonehover');
        };
        var mouseleaveHandlerFunc = function (e) {
            e.preventDefault();
            $('body').removeClass('dropzonehover');
        };

        // Submit handler to trigger hidden 'input type="file"' upload field
        var submitFunc = function (e) {
            e.preventDefault();
            $uploadField.trigger('click');
        };
        // File upload handler
        var uploadFunc = function (e) {
            e.preventDefault();
            processUpload(e.target.files);
        };
        // "drop" handler
        var dropHandlerFunc = function (e) {
            e.preventDefault();
            $('body').removeClass('dragging dragover');
            dragging = false;
            processUpload(e.originalEvent.dataTransfer.files);
        };
        // General handler for preventing propragation and default action
        var preventHandlerFunc = function (e) {
            e.preventDefault();
            e.stopPropagation();
        };
        // Dragover handler for preventing propragation and default action
        var preventDragoverHandlerFunc = function (e) {
            e.preventDefault();
            e.stopPropagation();
            e.originalEvent.dataTransfer.dropEffect = 'none';
            try {
                // IE won't allow setting of effectAllowed
                e.originalEvent.dataTransfer.effectAllowed = 'none';
            } catch (err) { }
        };
        // "dragover" handler
        var dragoverHandlerFunc = function (e) {
            e.preventDefault();
            e.stopPropagation();
            e.originalEvent.dataTransfer.dropEffect = 'copy';
            try {
                // IE won't allow setting of effectAllowed
                e.originalEvent.dataTransfer.effectAllowed = 'copyMove';
            } catch (err) { }
        };
        // "dragenter" handler, adding class "dragover" to body tag.
        var dragenterHandlerFunc = function (e) {
            e.preventDefault();
            $('body').addClass('dragover');
        };
        // "dragleave" handler, removing class "dragover" from body tag.
        var dragleaveHandlerFunc = function (e) {
            e.preventDefault();
            $('body').removeClass('dragover');
        };

        // Pseudo "dragstart" handler, adding class "dragging" to body tag.
        var dragstartHandlerFunc = function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (!$('body').hasClass('dragging') && !dragging) {
                $('body').addClass('dragging');
                dragging = true;
            }
        };
        // Pseudo "dragend" handler, removing class "dragging" from body tag.
        var dragendHandlerFunc = function (e) {
            e.preventDefault();
            e.stopPropagation();
            if ($('body').hasClass('dragging') && dragging) {
                $('body').removeClass('dragging');
                dragging = false;
            }
        };

        // Enable clipboard capturing
        if (settings.enableCliboardCapture) {
            $contentEditable.appendTo('body').focus();
            $(window).on({
                keydown: keydownHandlerFunc, // IE & Mozilla
                paste: pasteHandlerFunc
            });
        }

        // Enable file requester upload
        if (settings.trigger !== null) {
            $uploadField.on('change', uploadFunc).appendTo('.dropzone-trigger').blur();
            $this.on(settings.trigger, submitFunc);
        }
        // Enable drag and drop upload
        $this.on({
            dragenter: dragenterHandlerFunc,
            dragleave: dragleaveHandlerFunc,
            dragover: dragoverHandlerFunc,
            drop: dropHandlerFunc,
            mouseenter: mouseenterHandlerFunc,
            mouseleave: mouseleaveHandlerFunc
        });
        // Prevent dropping outside droparea
        // Since dragstart and dragend is not triggered when dragging local files,
        // the "html" tag is used as fake "triggers" (Using "body" tag has problems)
        $('html').on({
            dragbetterenter: dragstartHandlerFunc,
            dragbetterleave: dragendHandlerFunc,
            dragover: preventDragoverHandlerFunc,
            drag: preventHandlerFunc,
            drop: preventHandlerFunc
        });
        // chainable
        return this;
    };
}(jQuery));

jQuery(document).ready(function ($) {

    // Shared callback handler for processing output
    var outputHandlerFunc = function (imgObj) {

        var sizeInKB = function (bytes) { return (typeof bytes == 'number') ? (bytes / 1024).toFixed(2) + 'Kb' : bytes; };

        var getThumbnail = function (original, maxWidth, maxHeight, upscale) {
            var canvas = document.createElement("canvas"), width, height;
            if (original.width < maxWidth && original.height < maxHeight && upscale == undefined) {
                width = original.width;
                height = original.height;
            }
            else {
                width = maxWidth;
                height = parseInt(original.height * (maxWidth / original.width));
                if (height > maxHeight) {
                    height = maxHeight;
                    width = parseInt(original.width * (maxHeight / original.height));
                }
            }
            canvas.width = width;
            canvas.height = height;
            canvas.getContext("2d").drawImage(original, 0, 0, width, height);
            $(canvas).attr('title', 'Original size: ' + original.width + 'x' + original.height);
            return canvas;
        }



        $(new Image()).on('load', function (e) {
            var $wrapper = $('<li class="new-item"><span class="preview"></span><span class="type">' + imgObj.type + '<br>' + (e.target.width + '&times;' + e.target.height) + '<br>' + sizeInKB(imgObj.size) + '</span><span class="name">' + imgObj.name + '</span><span class="options"><span class="imagedelete" title="Remove image"></span></span></li>').appendTo('#output ul');
            $('.imagedelete', $wrapper).on('click', function (e) {
                $wrapper.toggleClass('new-item').addClass('removed-item');
                $wrapper.one('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function (e) {
                    $wrapper.remove();
                });
            });

            var thumb = getThumbnail(e.target, 50, 50);
            var $link = $('<img>').attr({
                src: imgObj.imgSrc
            }).append(thumb).appendTo($('.preview', $wrapper));


        }).attr('src', imgObj.imgSrc);

    }

    var fileReaderAvailable = (typeof FileReader !== "undefined");
    var clipBoardAvailable = (window.clipboardData !== false);
    var pasteAvailable = Boolean(clipBoardAvailable & fileReaderAvailable & !eval('/*@cc_on !@*/false'));

    if (fileReaderAvailable) {

        // Enable drop area upload
        $('#dropzone').imageUpload({
            errorContainer: $('span', '#errormessages'),
            trigger: 'dblclick',
            enableCliboardCapture: pasteAvailable,
            onBeforeUpload: function () { $('body').css('background-color', '#fff'); console.log('start', Date.now()); },
            onAfterUpload: function () { $('body').css('background-color', '#fff'); console.log('end', Date.now()); },
            outputHandler: outputHandlerFunc
        })
    }
    else {
        $('body').addClass('nofilereader');
    }

    if (!pasteAvailable) {
        $('body').addClass('nopaste');
    }

});
