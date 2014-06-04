
$(".drop_list.expand").live('click', function(){
	$(this).removeClass('expand').addClass('unexpand');
	$(this).find('.select_options').hide();
});

$(".drop_list.unexpand").live('click', function(){
	$(document).find(".drop_list.expand").removeClass('expand').addClass('unexpand').find('.select_options').hide();
	$(this).removeClass('unexpand').addClass('expand');
	$(this).find('.select_options').show();
});
	
$(".drop_list .select_option").live('click', function(){
	$(this).parents('.drop_list').removeClass('expand').addClass('unexpand');
	$(this).siblings().removeClass('selected');
	$(this).addClass('selected');
    var select = $(this).parent().parent().find('select');
	select.val($(this).attr('value'));
    updateSelectText(select);
});

function updateSelectText(select) {
    $(select).prev().text($(select).find('option:selected').text());
}

//$(".drop_list select").live('change', function(){
//    $(this).prev().text($(this).find('option:selected').text());
//});

var selenter = false;
$('.drop_list').live('mouseenter', function() {
    selenter = true;
});
$('.drop_list').live('mouseleave', function() {
    selenter = false;
});
$(document).click(function() {
    if (!selenter) {
        $('.select_options').hide();
        $('.drop_list.expand').removeClass('expand').addClass('unexpand');
    }
});