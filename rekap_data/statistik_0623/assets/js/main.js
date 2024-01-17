$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 992) {
            $('div.navbar-collapse').addClass('collapse')
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse')
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });
    $('#sidebar-toggle').click(function(){
        var $sidebar = $('.sidebar');
        var $wrapper = $('#page-wrapper');

        if ($sidebar.hasClass('sidebar-hide') == true) {
            $sidebar.removeClass('sidebar-hide');
            $wrapper.removeClass('sidebar-hidden');
            $(this).removeClass('fa-rotate-180');
        } else{
            $sidebar.addClass('sidebar-hide');
            $wrapper.addClass('sidebar-hidden');
            $(this).addClass('fa-rotate-180');
        };
    });
});
