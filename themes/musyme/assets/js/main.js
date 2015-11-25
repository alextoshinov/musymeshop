$(document).ready(function() {
    
    $('.images-block').magnificPopup({
        delegate: 'a', 
        type: 'image',
        gallery: {
          enabled: true
        }
    });
    //
    $("#owl-product").owlCarousel({
        autoPlay: false, //Set AutoPlay to 3 seconds
        items : 4,
        stopOnHover : true,
        navigation : true, // Show next and prev buttons
        pagination : true,
        navigationText : ['<div class="images-arrow-left"><i class="fa fa-arrow-circle-left fa-sm"></i></div>','<div class="images-arrow-right"><i class="fa fa-arrow-circle-right fa-sm"></i></div>']
    });
    //
    $(".next").click(function(){
      $("#owl-product").trigger('owl.next');
    });
    //
    $(".prev").click(function(){
      $("#owl-product").trigger('owl.prev');
    });
    //
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });

    $('.small-images-container').carousel({interval: false, wrap: false});
});// End of document reardy

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

