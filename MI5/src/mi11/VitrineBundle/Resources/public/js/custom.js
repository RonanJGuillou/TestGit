(function(){

    $("#cart").on("click", function() {
        $(".shopping-cart").fadeToggle( "fast");
    });

})();

window.setTimeout(function() {
    $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 4000);