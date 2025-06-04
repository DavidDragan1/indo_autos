<style type="text/css">
.input-group .input-group-addon {
    background-color: #EEE;
    min-width: 120px;
}



#gellery-setting .input-group .input-group-addon {
    background-color: #EEE;
}


.watermark-preview {
    position: relative;
    background-image: url('uploads/watermark_bg.jpg');
    background-repeat: no-repeat;
    background-position: top left;
    width: 320px;
    height: 220px;
}
.watermark-preview img {        
    position:absolute;   
}




 

    #collapsedSection {
        display: block;
        overflow: hidden;
        height: auto;
        max-height: 110px;
        transition: max-height 0.3s ease-out;
    }
    #collapsedSection[aria-hidden="true"] {
        max-height: 0px;
    }
    #collapsedSection label:first-child {
        margin-top: 0.5em;
    }
    .tandc-wrapper {
        margin: 1.5em 0;
    }


    .invalid {
        border: solid 1px rgba(255, 0, 0, 0.4);
    }
    fieldset.invalid {
        border: none;
    }
    #errorSummary li a {
        color: #333;
    }
    #errorSummary p {
        margin-top: 0;
    }
    .error-indicator {
        display: inline-block;
        position: relative;
        color: #f00;
        margin: 5px 0;
        font-size:medium;

    }
    .tandc-wrapper .error-indicator {
        display: block;
    }
    .error-indicator[aria-hidden="true"] {
        display: none;
    }

    #errorSummary {
        margin-bottom: 1em;
    }
    .error-indicator {
        display: block;
        padding: 0.5em 1em;
        background-color: #eee;
        border-radius: 3px;
        margin-top: 0.8em;
        -webkit-animation: show_indicator 0.2s cubic-bezier(0.42, 0.93, 0.87, 1.31);
        animation: show_indicator 0.2s cubic-bezier(0.42, 0.93, 0.87, 1.31);
        transform-origin: left;
    }
    .error-indicator:before {
        content: '';
        position: absolute;
        border: solid 10px transparent;
        border-bottom-color: #eee;
        top: -19px;
        left: 0.5em;
    }
    @-webkit-keyframes show_indicator {
        0% { transform: scale(0.9); opacity: 0.6; }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes show_indicator {
        0% { transform: scale(0.9); opacity: 0.6; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>