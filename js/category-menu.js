$(document).ready(function(){
    
    $("#catalog .left #sections .item").click(function(){
    	if ($(this).hasClass('unactiv')){
            $("#catalog .left .check_category").val($(this).attr('rel'));
    		$("#catalog .left #sections .activ").removeClass('activ').addClass('unactiv')
        	$(this).removeClass('unactiv').addClass('activ');
    		var collapsable = $(this).parent().parent().siblings().find('.collapsable').add($(this).next().find('.collapsable'));
    		collapsable.next().slideUp(500).removeClass('expand').addClass('unexpand');
			collapsable.removeClass('collapsable').addClass('resolvable');
	        
			if ($(this).hasClass('resolvable')){
				$(this).removeClass('resolvable').addClass('collapsable');
				$(this).next().slideDown(500).removeClass('unexpand').addClass('expand');
	    	}
    	}
    	else if ($(this).hasClass('activ')){
    		if ($(this).hasClass('collapsable')){
	        	$(this).removeClass('collapsable').addClass('resolvable');
				$(this).next().slideUp(500).removeClass('expand').addClass('unexpand');
	    	}
	    	else {
                $("#catalog .left .check_category").val('');
   	            $(this).removeClass('activ').addClass('unactiv');
	    	}
    	}
    });
});