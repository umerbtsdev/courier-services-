// Select the main list and add the class "hasSubmenu" in each LI that contains an UL
$('.coa_list ul').each(function() {
    $this = $(this);
    $this.find("li").has("ul").addClass("hasSubmenu");
});
// Find the last li in each level
$('.coa_list li:last-child').each(function() {
    $this = $(this);
    // Check if LI has children
    if ($this.children('ul').length === 0) {
        // Add border-left in every UL where the last LI has not children
        $this.closest('ul').css("border-left", "none");
    } else {
        // Add border in child LI, except in the last one
        $this.closest('ul').children("li").not(":last").css("border-left", "none");
        // Add the class "addBorderBefore" to create the pseudo-element :defore in the last li
        $this.closest('ul').children("li").not(":last").children("a").addClass("addBorderBefore");
        // Add margin in the first level of the list
        // $this.closest('ul').css({ "border-left": "1px solid gray" });
        $this.closest('ul').css({ "margin-top": "10px", "height": "fit-content" });
        // Add margin in other levels of the list
        $this.closest('ul').find("li").children("ul").css("margin-top", "0px");
    };
});
// Add bold in li and levels above
$('.coa_list ul li').each(function() {
    $this = $(this);
    $this.mouseenter(function() {
        $(this).children("a").css({ "font-weight": "bold", "color": "#336b9b" });
    });

    $this.mouseleave(function() {
        $(this).children("a").css({ "font-weight": "normal", "color": "#428bca" });
    });
});



// Add button to expand and condense - Using FontAwesome
$('.coa_list ul li.hasSubmenu').each(function() {
    $this = $(this);
    $this.prepend("<a href='#'><i class='fa fa-chevron-circle-right dropdownNotActive'></i><i style='display:none;' class='fa fa-chevron-circle-down dropdownActive'></i></a>");
    $this.children("a").not(":last").removeClass().addClass("toogle");
});
// Actions to expand and consense
$('.coa_list ul li.hasSubmenu a.toogle').click(function() {
    $this = $(this);
    $this.closest("li").children("ul").toggle("slow");
    $this.children("i").toggle();

    return false;
});

$('.coa_list ul li ul li:last-child').each(function() {
    $this = $(this);
    // $this.css({ "margin-bottom": "7px", "margin-top": "-9px", "margin-left": "12px" });
    $this.css({ "margin-bottom": "7px", "margin-top": "-9px"});
});
$('.coa_list ul li:not(first-child)').each(function() {
    $this = $(this);
    $this.css({ "margin-top": "1px" });
});
$('.coa_list ul li ul li:not(first-child)').each(function() {
    $this = $(this);
    $this.css({ "margin-top": "-6px" });
});
$('.coa_list ul li ul li ul').each(function() {
    $this = $(this);
    $this.css({ "margin-top": "-6px" });
});
$('.coa_list ul li ul').each(function() {
    $this = $(this);
    $this.css({ "margin-top": "-6px" });
});