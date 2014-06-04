$('.button_add_announce').live('mouseenter', function() {
    $(this).removeClass('normal').addClass('mouseenter');
});
$('.button_add_announce').live('mouseleave', function() {
    $(this).removeClass('mouseenter').addClass('normal');
});