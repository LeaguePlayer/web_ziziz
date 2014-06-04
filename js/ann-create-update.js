jQuery(document).ready(function() {
    if ('<?=$model->isNewRecord?>')
        jQuery('.cats').change();
    else
        checkClassifiers();
});

function checkClassifiers() {
    $.ajax({
    	type: "Post",
    	url: '<?=$this->createUrl("announcements/getIncludedClassifiers");?>&announcement_id=<?=$model->ann_id;?>&type=update',
    	data: ({ajax : 1}),
    	success: function(res) {
    		//alert(res);
    		$('.classifiers').html(res);
    	}
    });         
};

jQuery('.cats').change(function() {
    var cat_id = jQuery(this).val();
    //console.log(cat_id);
    $.ajax({
    	type: "Post",
    	url: '<?=$this->createUrl("announcements/getClassif")?>&category_id='+cat_id,
    	data: ({ajax : 1}),
    	success: function(res) {
    		//alert(res);
    		$('.classifiers').html(res);
    	}
    });
});

$('.classifiers').delegate('.include_classif_checkbox', 'click', function() {
	var classif_id = ($(this).val());    	
	if ($(this).attr('checked') == 'checked')
		var param = '1';
	else
		var param = '0';
	$.ajax({
    	type: "Post",
    	url: '<?=$this->createUrl("announcements/getClassifValues")?>&classif_id='+classif_id,
    	data: 'ajax=1&showList='+param,
    	success: function(res) {
    		//alert(res);
    		var selector = '#classif_value_list'+classif_id;
    		$(selector).html(res);
    	}
    });
});