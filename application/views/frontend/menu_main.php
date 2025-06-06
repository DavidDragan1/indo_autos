<?php
$page_active =$this->uri->segment(1);
?>

<ul class="mainmenu">
    <li <?php if(isset($page_title) && $page_title=='home') echo 'class="active"'; ?>><a href="<?php echo base_url(); ?>">Home</a></li>
    <li <?php if((isset($page_active) && $page_active=='search') || isset($page_active) && $page_active=='search-review') echo 'class="active"'; ?>><span>New & used car
            <img class="normal" src="assets/theme/new/images/icons/angle-down.png" alt="image">
            <img class="hover" src="assets/theme/new/images/icons/arrow-hover.png" alt="image">
        </span>
        <ul>
            <li><a href="search?condition=New&type_id=1">New Cars</a></li>
            <li><a href="search?condition=Foreign+used&type_id=1">Foreign Used</a></li>
            <li><a href="search?condition=Nigerian+used&type_id=1">Nigerian Used Cars</a></li>
            <li><a href="search?type_id=5">Import Car</a></li>
            <li><a href="search?type_id=2">Van</a></li>
            <li><a <?php if((isset($page_active) && $page_active=='search-review')) echo 'class="active"';?>  href="search-review">Car Review</a></li>
        </ul>
    </li>
    <li <?php if(isset($page_active) && in_array($page_active,['motorbike','buy-motorbike'])) echo 'class="active"'; ?>><a href="buy-motorbike">Buy motorbikes</a></li>
    <li <?php if(isset($page_active) && in_array($page_active,['admin/posts/create'])) echo 'class="active"'; ?>><a href="admin/posts/create">List my products</a></li>
    <li <?php if(isset($page_active) && in_array($page_active,['parts','spare-parts'])) echo 'class="active"'; ?>><a href="parts">Buy spare parts</a></li>
    <li <?php if(isset($page_active) && in_array($page_active,['automech','automech-search'])) echo 'class="active"'; ?>><a href="automech">Hire a mechanics</a></li>
    <li <?php if(isset($page_active) && in_array($page_active,['towing','towing-search'])) echo 'class="active"'; ?>><a href="towing">Mobile services</a></li>
    <li <?php if((isset($page_active) && $page_active=='motor-association') || (isset($page_active) && $page_active=='driver-hire') || (isset($page_active) && $page_active=='ask-an-expert') || (isset($page_active) && $page_active=='mechanic') || (isset($page_active) && $page_active=='diagnostic')) echo 'class="active"'; ?>><span>Other services
            <img class="normal" src="assets/theme/new/images/icons/angle-down.png" alt="image">
            <img class="hover" src="assets/theme/new/images/icons/arrow-hover.png" alt="image">
        </span>
        <ul>
            <li><a <?php if((isset($page_active) && $page_active=='motor-association')) echo 'class="active"';?> href="motor-association">Motor Association</a></li>
            <li><a <?php if((isset($page_active) && $page_active=='driver-hire')) echo 'class="active"';?> href="driver-hire">Driver Hire Managed Service</a></li>
            <li><a <?php if((isset($page_active) && $page_active=='ask-an-expert')) echo 'class="active"';?> href="ask-an-expert">Ask an Expert</a></li>
            <li><a <?php if((isset($page_active) && $page_active=='mechanic')) echo 'class="active"';?> href="mechanic">Online Mechanic</a></li>
            <li><a <?php if((isset($page_active) && $page_active=='diagnostic')) echo 'class="active"';?> href="diagnostic">Online Diagnostic</a></li>
            <li><a <?php if((isset($page_active) && $page_active=='car-valuation')) echo 'class="active"';?> href="car-valuation">Car Valuation</a></li>
            <li><a <?php if((isset($page_active) && $page_active=='insurance-claim')) echo 'class="active"';?> href="insurance-claim">Insurance Claims</a></li>
            <li><a <?php if((isset($page_active) && $page_active=='track-your-application')) echo 'class="active"';?> href="track-your-application">Track Your Application</a></li>
        </ul>
    </li>
</ul>
<script>
    let responsiveMenu ="<ul class=\"accordion accordionResponsiveMenu\" id=\"mainMenuAccordion\">\n" +
        "    <li <?php if (isset($page_title) && $page_title == 'home') echo 'class=\"active\"'; ?>><a href=\"<?php echo base_url(); ?>\">Home</a></li>\n" +
        "    <li <?php if ((isset($page_active) && $page_active == 'search') || isset($page_active) && $page_active == 'blog') echo 'class=\"active\"'; ?>>\n" +
        "        <span data-toggle=\"collapse\" data-target=\"#menu1\" aria-expanded=\"false\"\n" +
        "            aria-controls=\"menu1\">New & used car</span>\n" +
        "        <ul id=\"menu1\" class=\"collapse\" data-parent=\"#mainMenuAccordion\">\n" +
        "            <li><a href=\"search?condition=New&type_id=1\">New Cars</a></li>\n" +
        "            <li><a href=\"search?condition=Foreign+used&type_id=1\">Foreign Used</a></li>\n" +
        "            <li><a href=\"search?condition=Nigerian+used&type_id=1\">Nigerian Used Cars</a></li>\n" +
        "            <li><a href=\"search?type_id=5\">Import Car</a></li>\n" +
        "            <li><a href=\"search?type_id=2\">Van</a></li>\n" +
        "            <li><a <?php if ((isset($page_active) && $page_active == 'blog')) echo 'class=\"active\"';?>  href=\"blog\">Car Review</a></li>\n" +
        "        </ul>\n" +
        "    </li>\n" +
        "    <li <?php if (isset($page_active) && in_array($page_active, ['motorbike', 'buy-motorbike'])) echo 'class=\"active\"'; ?>><a href=\"buy-motorbike\">Buy motorbikes</a></li>\n" +
        "    <li <?php if (isset($page_active) && in_array($page_active, ['admin/posts/create'])) echo 'class=\"active\"'; ?>><a href=\"admin/posts/create\">List my products</a></li>\n" +
        "    <li <?php if (isset($page_active) && in_array($page_active, ['parts', 'spare-parts'])) echo 'class=\"active\"'; ?>><a href=\"parts\">Buy spare parts</a></li>\n" +
        "    <li <?php if (isset($page_active) && in_array($page_active, ['automech', 'automech-search'])) echo 'class=\"active\"'; ?>><a href=\"automech\">Hire a mechanics</a></li>\n" +
        "    <li <?php if (isset($page_active) && in_array($page_active, ['towing', 'towing-search'])) echo 'class=\"active\"'; ?>><a href=\"towing\">Mobile services</a></li>\n" +
        "\n" +
        "\n" +
        "    <li <?php if ((isset($page_active) && $page_active == 'motor-association') || (isset($page_active) && $page_active == 'driver-hire') || (isset($page_active) && $page_active == 'ask-an-expert') || (isset($page_active) && $page_active == 'mechanic') || (isset($page_active) && $page_active == 'diagnostic')) echo 'class=\"active\"'; ?>>\n" +
        "        <span data-toggle=\"collapse\" data-target=\"#menu2\" aria-expanded=\"false\"\n" +
        "            aria-controls=\"menu2\">Other services</span>\n" +
        "        <ul id=\"menu2\" class=\"collapse\" data-parent=\"#mainMenuAccordion\">\n" +
        "            <li><a <?php if ((isset($page_active) && $page_active == 'motor-association')) echo 'class=\"active\"';?> href=\"motor-association\">Motor Association</a></li>\n" +
        "            <li><a <?php if ((isset($page_active) && $page_active == 'driver-hire')) echo 'class=\"active\"';?> href=\"driver-hire\">Driver Hire Managed Service</a></li>\n" +
        "            <li><a <?php if ((isset($page_active) && $page_active == 'ask-an-expert')) echo 'class=\"active\"';?> href=\"ask-an-expert\">Ask an Expert</a></li>\n" +
        "            <li><a <?php if ((isset($page_active) && $page_active == 'mechanic')) echo 'class=\"active\"';?> href=\"mechanic\">Online Mechanic</a></li>\n" +
        "            <li><a <?php if ((isset($page_active) && $page_active == 'diagnostic')) echo 'class=\"active\"';?> href=\"diagnostic\">Online Diagnostic</a></li>\n" +
        "            <li><a <?php if ((isset($page_active) && $page_active == 'diagnostic')) echo 'class=\"active\"';?> href=\"car-valuation\">Car Valuation</a></li>\n" +
        "            <li><a <?php if ((isset($page_active) && $page_active == 'insurance-claim')) echo 'class=\"active\"';?> href=\"insurance-claim\">Insurance Claims</a></li>\n" +
        "            <li><a <?php if ((isset($page_active) && $page_active == 'track-your-application')) echo 'class=\"active\"';?> href=\"track-your-application\">Track Your Application</a></li>\n" +
        "        </ul>\n" +
        "    </li>\n" +
        "\n" +
        "</ul>\n"
    if($('body').innerWidth() < 1200){
        $('#responsiveMenuWrap').html(responsiveMenu)
    }
</script>