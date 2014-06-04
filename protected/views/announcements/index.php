<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/category-menu.js', CClientScript::POS_HEAD); ?>

<?php $this->pageTitle = "Продажа запчастей на ZIZIZ, доска объявлений в городе ".Citys::model()->findByPk($city_id)->city_name; ?>

<div class="breadcrumb">
    <?php $this->breadcrumbs=array(
    	'Объявления',
    ); ?>
</div>

<h1>Продажа запчастей в городе <?=Citys::model()->findByPk($city_id)->city_name?></h1>

<div id="catalog">
    <?php $this->renderPartial('_catalog', array(
        'form'=>$form,
        'dataProvider' => $dataProvider,
        'categories' => $categories,
        'cur_category' => $cur_category,
        'session_cleared' => $session_cleared,
        'check_classif' => $check_classif,
        'city_id'=>$city_id,
        'brend'=>$brend,
        'brendmodel'=>$brendmodel
    )) ?>
</div>

<script>
    
    $('#catalog').delegate(".left a", 'click', function(){
        return false;
//        $.ajax({
//        	type: 'GET',
//			url: '<?=$this->createUrl('announcements/index')?>',
//			data: {cat_id:$(this).attr('rel')},
//			success: function(data){
//				$('#listview-container').html(data);
//			}
//		});
    });
    
    $('#catalog').delegate('.button_clear_search', 'click', function(){
    	$('#announc_list').html("<div class='loader'></div>");
        $.get(
            '<?=$this->createUrl('announcements/index')?>',
            {clear_session: true},
            function(data){
			    $('#listview-container').html(data);

                $("#AutoSearch_brend_combobox").val('');
                $('#AutoSearch_brend option:selected').removeAttr('selected');
                $('#models_search').html('');

                $('#sections .item[rel=all]').click();
			    $("#AnnSearchForm_string").val('');
			    $(".clear-search").css('display', 'none');
			    $("#catalog .left .price_ot").val('');
				$("#catalog .left .price_do").val('');
            }
        );
        return false;
    });
    
   	$('#catalog').delegate('#classifier_bar select', 'change', function(){
        $.get(
			'<?=$this->createUrl('announcements/index')?>',
			{check_classif:$(this).attr('rel'), check_classif_value: $(this).val()},
			function(data){
				$('#catalog').html(data);
			}
		);
    });
	
	$(".drop_list .select_option").live('click', function()
    {
        $('#announc_list').html("<div class='loader'></div>");
        var sel = $(this).parent().parent().find('select');
        if($(this).parents('.bar-item').attr('id')=='models_search')
        {
            $.ajax({
                url: '<?=$this->createUrl('announcements/index')?>',
                type: 'POST',
                data: {
                    brendmodel_id: sel.val(),
                },
                success: function(data){
                    $('#listview-container').html(data);
                },
            });
        }
        else
        {
            $.ajax({
                url: '<?=$this->createUrl('announcements/index')?>',
                type: 'GET',
                data: {
                    check_classif: sel.attr('rel'),
                    check_classif_value: sel.val(),
                },
                success: function(data){
                    $('#listview-container').html(data);
                },
            });
        }
	});
    
    $("#sections .item").click(function(){
        if ($(this).hasClass('unactiv')){
            $('#announc_list').html("<div class='loader'></div>");
    		var c_id = $(this).attr('rel');
        	$.ajax({
        		url: '<?=$this->createUrl('announcements/index')?>',
        		type: 'GET',
        		data: {
        			cat_id: c_id,
    			},
        		success: function(data){
        			$('#listview-container').html(data);
        		},
        	});
        }
	});

    $("#AutoSearch_brend_combobox").keyup(function(){
        if ($(this).val() == '')
        {
            $('#AutoSearch_brend option:selected').removeAttr('selected');
            $('#models_search').html('');
            jQuery.ajax({
                type: 'POST',
                url: '/announcements/index/',
                data: {
                    brend_id: $('#AutoSearch_brend').val(),
                },
                success: function(data){
                    $('#listview-container').html(data);
                }
            });
        }
    });
    
</script>