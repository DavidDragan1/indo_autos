<style type="text/css">

    img.in_side {
        width: 175px;
    }
    td.post_details h4, 
    td.post_details p {
        margin:0;		
    }

    td.post_details {
        padding-bottom: 20px;
    }
    ul.dropdown-menu {
        min-width:115px;
    }
    ul.dropdown-menu li {
        cursor:pointer;
    }

    .input-group {
        margin-bottom: 10px;
    }    
    .input-group .input-group-addon { background-color: #EEE; }
    .input-group-addon sup {    
        font-size: 13pt;
        top: -0.2em;
    }

    .input-group-addon {
        min-width:180px; 
        text-align:left;
    }

    .progress {
        height: 20px;
        margin-bottom: 20px;
        overflow: hidden;
        background-color: #f3f3f3;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.5);
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.5) !important;
    }
    .margin-top { margin-top: 80px;}

    ul.thumbPhotos {
        padding: 15px 0px;
    }
    ul.thumbPhotos li {
        float: left;
        width: 150px;
        height: 170px;
        position: relative;
        overflow: hidden;
        border: 1px solid #555;
        padding: 5px;
        margin: 2px;
    }
    ul.thumbPhotos li b.deletePhoto {
        left: 0;
        bottom: 0;
        background: rgba(220, 26, 51, 0.75);
    }
    ul.thumbPhotos li span.markActive {
        top: 0;
        right: 0;
    }

    ul.thumbPhotos li b.deletePhoto {
        left: 5px;
        bottom: 5px;
        background: rgba(220, 26, 51, 0.75);
        position: absolute;
    }
    th.hit-count, 
    td.hit-count {
        padding-right: 15px !important;
        text-align: right;
        font-weight: bold;
    }

    /****** Ribbon *****/
    .ribbon {
        position: absolute;
        left: 0;
        top: 0;
        z-index: 1;
        overflow: hidden;
        width: 110px;
        height: 110px;
        text-align: right;
    }

    .ribbon span{
        background: rgba(0, 0, 0, 0) linear-gradient(#9bc90d 0%, #79a70a 100%) repeat scroll 0 0;
        box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
        color: #fff;
        display: block;
        font-size: 10pt;
        font-weight: normal;
        left: -24px;
        line-height: 15px;
        padding: 5px 0;
        position: absolute;
        text-align: center;    
        top: 19px;
        transform: rotate(-45deg);
        width: 110px;
    }

    .free {
        background: linear-gradient(#B6BAC9 0%, #808080 100%) !important;
    }

    .ribbon span::before {
        content: "";
        position: absolute; 
        left: 0px; 
        top: 100%;
        z-index: -1;
        border-left: 3px solid #79A70A;
        border-right: 3px solid transparent;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #79A70A;
    }

    .ribbon span::after {
        content: "";
        position: absolute; right: 0px; top: 100%;
        z-index: -1;
        border-left: 3px solid transparent;
        border-right: 3px solid #79A70A;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #79A70A;
    }
    
    .label-big {
        font-size: 9pt;
    }
    
    /* This is the default Tooltipster theme (feel free to modify or duplicate and create multiple themes!): */
 .tooltipster-default {
    border-radius: 3px;
    border: 1px solid #000;
    background: #4c4c4c;
    color: #fff;
}
/* Use this next selector to style things like font-size and line-height: */
 .tooltipster-default .tooltipster-content {
    font-family: Arial, sans-serif;
    font-size: 11px;
    line-height: 16px;
    padding: 3px 5px;
    overflow: hidden;
}
/* This next selector defines the color of the border on the outside of the arrow. This will automatically match the color and size of the border set on the main tooltip styles. Set display: none; if you would like a border around the tooltip but no border around the arrow */
 .tooltipster-default .tooltipster-arrow .tooltipster-arrow-border {
    /* border-color: ... !important; */
}
/* If you're using the icon option, use this next selector to style them */
 .tooltipster-icon {
    cursor: help;
    margin-left: 4px;
}
/* This is the base styling required to make all Tooltipsters work */
 .tooltipster-base {
    padding: 0;
    font-size: 0;
    line-height: 0;
    position: absolute;
    z-index: 9999999;
    pointer-events: none;
    width: auto;
    overflow: visible;
}
.tooltipster-base .tooltipster-content {
    overflow: hidden; width: 105%;
}
/* These next classes handle the styles for the little arrow attached to the tooltip. By default, the arrow will inherit the same colors and border as what is set on the main tooltip itself. */
 .tooltipster-arrow {
    display: block;
    text-align: center;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: -1;
}
.tooltipster-arrow span, .tooltipster-arrow-border {
    display: block;
    width: 0;
    height: 0;
    position: absolute;
}
.tooltipster-arrow-top span, .tooltipster-arrow-top-right span, .tooltipster-arrow-top-left span {
    border-left: 8px solid transparent !important;
    border-right: 8px solid transparent !important;
    border-top: 8px solid;
    bottom: -8px;
}
.tooltipster-arrow-top .tooltipster-arrow-border, .tooltipster-arrow-top-right .tooltipster-arrow-border, .tooltipster-arrow-top-left .tooltipster-arrow-border {
    border-left: 9px solid transparent !important;
    border-right: 9px solid transparent !important;
    border-top: 9px solid;
    bottom: -8px;
}
.tooltipster-arrow-bottom span, .tooltipster-arrow-bottom-right span, .tooltipster-arrow-bottom-left span {
    border-left: 8px solid transparent !important;
    border-right: 8px solid transparent !important;
    border-bottom: 8px solid;
    top: -8px;
}
.tooltipster-arrow-bottom .tooltipster-arrow-border, .tooltipster-arrow-bottom-right .tooltipster-arrow-border, .tooltipster-arrow-bottom-left .tooltipster-arrow-border {
    border-left: 9px solid transparent !important;
    border-right: 9px solid transparent !important;
    border-bottom: 9px solid;
    top: -8px;
}
.tooltipster-arrow-top span, .tooltipster-arrow-top .tooltipster-arrow-border, .tooltipster-arrow-bottom span, .tooltipster-arrow-bottom .tooltipster-arrow-border {
    left: 0;
    right: 0;
    margin: 0 auto;
}
.tooltipster-arrow-top-left span, .tooltipster-arrow-bottom-left span {
    left: 6px;
}
.tooltipster-arrow-top-left .tooltipster-arrow-border, .tooltipster-arrow-bottom-left .tooltipster-arrow-border {
    left: 5px;
}
.tooltipster-arrow-top-right span, .tooltipster-arrow-bottom-right span {
    right: 6px;
}
.tooltipster-arrow-top-right .tooltipster-arrow-border, .tooltipster-arrow-bottom-right .tooltipster-arrow-border {
    right: 5px;
}
.tooltipster-arrow-left span, .tooltipster-arrow-left .tooltipster-arrow-border {
    border-top: 8px solid transparent !important;
    border-bottom: 8px solid transparent !important;
    border-left: 8px solid;
    top: 50%;
    margin-top: -7px;
    right: -8px;
}
.tooltipster-arrow-left .tooltipster-arrow-border {
    border-top: 9px solid transparent !important;
    border-bottom: 9px solid transparent !important;
    border-left: 9px solid;
    margin-top: -8px;
}
.tooltipster-arrow-right span, .tooltipster-arrow-right .tooltipster-arrow-border {
    border-top: 8px solid transparent !important;
    border-bottom: 8px solid transparent !important;
    border-right: 8px solid;
    top: 50%;
    margin-top: -7px;
    left: -8px;
}
.tooltipster-arrow-right .tooltipster-arrow-border {
    border-top: 9px solid transparent !important;
    border-bottom: 9px solid transparent !important;
    border-right: 9px solid;
    margin-top: -8px;
}
/* Some CSS magic for the awesome animations - feel free to make your own custom animations and reference it in your Tooltipster settings! */
 .tooltipster-fade {
    opacity: 0;
    -webkit-transition-property: opacity;
    -moz-transition-property: opacity;
    -o-transition-property: opacity;
    -ms-transition-property: opacity;
    transition-property: opacity;
}
.tooltipster-fade-show {
    opacity: 1;
}
.tooltipster-grow {
    -webkit-transform: scale(0, 0);
    -moz-transform: scale(0, 0);
    -o-transform: scale(0, 0);
    -ms-transform: scale(0, 0);
    transform: scale(0, 0);
    -webkit-transition-property: -webkit-transform;
    -moz-transition-property: -moz-transform;
    -o-transition-property: -o-transform;
    -ms-transition-property: -ms-transform;
    transition-property: transform;
    -webkit-backface-visibility: hidden;
}
.tooltipster-grow-show {
    -webkit-transform: scale(1, 1);
    -moz-transform: scale(1, 1);
    -o-transform: scale(1, 1);
    -ms-transform: scale(1, 1);
    transform: scale(1, 1);
    -webkit-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
    -webkit-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    -moz-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    -ms-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    -o-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
}
.tooltipster-swing {
    opacity: 0;
    -webkit-transform: rotateZ(4deg);
    -moz-transform: rotateZ(4deg);
    -o-transform: rotateZ(4deg);
    -ms-transform: rotateZ(4deg);
    transform: rotateZ(4deg);
    -webkit-transition-property: -webkit-transform, opacity;
    -moz-transition-property: -moz-transform;
    -o-transition-property: -o-transform;
    -ms-transition-property: -ms-transform;
    transition-property: transform;
}
.tooltipster-swing-show {
    opacity: 1;
    -webkit-transform: rotateZ(0deg);
    -moz-transform: rotateZ(0deg);
    -o-transform: rotateZ(0deg);
    -ms-transform: rotateZ(0deg);
    transform: rotateZ(0deg);
    -webkit-transition-timing-function: cubic-bezier(0.230, 0.635, 0.495, 1);
    -webkit-transition-timing-function: cubic-bezier(0.230, 0.635, 0.495, 2.4);
    -moz-transition-timing-function: cubic-bezier(0.230, 0.635, 0.495, 2.4);
    -ms-transition-timing-function: cubic-bezier(0.230, 0.635, 0.495, 2.4);
    -o-transition-timing-function: cubic-bezier(0.230, 0.635, 0.495, 2.4);
    transition-timing-function: cubic-bezier(0.230, 0.635, 0.495, 2.4);
}
.tooltipster-fall {
    top: 0;
    -webkit-transition-property: top;
    -moz-transition-property: top;
    -o-transition-property: top;
    -ms-transition-property: top;
    transition-property: top;
    -webkit-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
    -webkit-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    -moz-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    -ms-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    -o-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
}
.tooltipster-fall-show {
}
.tooltipster-fall.tooltipster-dying {
    -webkit-transition-property: all;
    -moz-transition-property: all;
    -o-transition-property: all;
    -ms-transition-property: all;
    transition-property: all;
    top: 0px !important;
    opacity: 0;
}
.tooltipster-slide {
    left: -40px;
    -webkit-transition-property: left;
    -moz-transition-property: left;
    -o-transition-property: left;
    -ms-transition-property: left;
    transition-property: left;
    -webkit-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
    -webkit-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    -moz-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    -ms-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    -o-transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
    transition-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1.15);
}
.tooltipster-slide.tooltipster-slide-show {
}
.tooltipster-slide.tooltipster-dying {
    -webkit-transition-property: all;
    -moz-transition-property: all;
    -o-transition-property: all;
    -ms-transition-property: all;
    transition-property: all;
    left: 0px !important;
    opacity: 0;
}
/* CSS transition for when contenting is changing in a tooltip that is still open */
 .tooltipster-content-changing {
    -webkit-transform: scale(1.1, 1.1);
    -moz-transform: scale(1.1, 1.1);
    -o-transform: scale(1.1, 1.1);
    -ms-transform: scale(1.1, 1.1);
    transform: scale(1.1, 1.1);
}



/* .towing_type_of_service , .towing_brand { display: none;} */

</style>