
$(document).ready(function() {
	var city_name;
    
    /**
     * Профиль - таблица автообъявлений
     */
     
    $("#profile table.announcements td").live('mouseover', function(){
        $(this).parents('table').find('td[rel='+$(this).attr('rel')+']').addClass('act');
    });
    $("#profile table.announcements td").live('mouseout', function(){
        $(this).parents('table').find('td[rel='+$(this).attr('rel')+']').removeClass('act');
    });
    
    /**
     * Профиль - таблица запчастей
     */
//    $("#profile table.announcements td").hover(
//        function(){
//            $(this).parents('table').find('td[rel='+$(this).attr('rel')+']').addClass('act');
//        },
//        function(){
//            $(this).parents('table').find('td[rel='+$(this).attr('rel')+']').removeClass('act');
//        }
//    );

	$(".scrollable").scrollable({
	   interval: 2000,
       looaap: true,
       speed: 600,
	}).navigator(".navi");
	
	/*
	 * при клике на блок запросов (.search) меняем стили этого блока
	 * и делаем display=block нужного подблока(#search_det или #search_service или #search_komp), а
	 * другой блок (#search_det или #search_service или #search_komp) прячем display=none
	 */
	$(".search:first").css({"background-color":"#2987c5"});
	$(".search:first").children(".search_text").children(".text_search_title").css({"color":"#fff"});
	$(".search:first").children(".search_text").children(".text_search").css({"color":"#fff"});
	$(".search").click(
		function(){
			$(".text_search_title").css({"color":"#2987c5"});
			$(".text_search").css({"color":"#2987c5"});
			$(".search").css({"background-color":"#fff"});
			$(this).children(".search_text").children(".text_search_title").css({"color":"#fff"});
			$(this).children(".search_text").children(".text_search").css({"color":"#fff"});
			$(this).css({"background-color":"#2987c5"});
			$(".order").css("display","none");
			var hoverEl = $(this).children("img").attr("alt");
			$("#"+hoverEl).css("display", "block");
		}
	);
	
	/*
	 * при наведении на блок (.ads) меняем стили
	 */
	 $(".ads").hover(
        function(){
            $(this).addClass('hover');
	 		$(this).children("a").css("color","#d7c04b");
			$(this).children(".date").css("color","#fff");
			$(this).children(".text").css("color","#fff");
	 	},
		function() {
            $(this).removeClass('hover');
			$(this).children("a").css("color","#2987c5");
			$(this).children(".date").css("color","#828282");
			$(this).children(".text").css("color","#313131");
		}
	 );
     
     $(".news a, .text_title_news_ads_actions a").hover(
        function(){
            //$(this).addClass('hover');
	 		$(this).css("color","#d7c04b");
			//$(this).children(".date").css("color","#fff");
			//$(this).children(".text").css("color","#fff");
	 	},
		function() {
            //$(this).removeClass('hover');
			$(this).css("color","#2987c5");
			//$(this).children(".date").css("color","#828282");
			//$(this).children(".text").css("color","#313131");
		}
	 );
     
     /**
      * при наборе текста поиска показываем кнопку очиски истории
      */
     $("#AnnSearchForm_string").keyup(function(){
        if($(this).val()=='')
            $("#search .clear-search").css('display', 'none');
        else
            $("#search .clear-search").css('display', 'block');
     });
     
     $("#AnnSearchForm_string").change(function(){
        if($(this).val()=='')
            $("#search .clear-search").css('display', 'none');
        else
            $("#search .clear-search").css('display', 'block');
     });
     
     /**
      * при при клике на кнопку очистки истории очищаем строку поиска
      */
     $("#search .clear-search").click(function(){
        $("#AnnSearchForm_string").val('');
        $(this).css('display', 'none');
     });

	/*
	 * страница продукта
	 */
	 //меняем стили при наведении миниатюр
	 $(".left_img>a").hover(function(){
	 	$(this).css({
	 		"border":"1px solid #0f91db"
	 	});
	 },
	 function(){
	 	$(this).css({
	 		"border":"1px solid #fff"
	 	});
	 }
	 );
//	 $(".left_img>a:first").removeAttr("rel");
	 //меняем большое изображение при клике на миниатюры и ссылку на болшое изображение
	 $(".left_img>a").click(function(){
        $("#big_img > div").fadeOut(500, function(){
            $(this).remove();
        });
		var href=$(this).attr("href");
        jQuery.ajax({
            type: 'GET',
            url: '/site/getimage/',
            data: {source: href},
            success: function(data){
                //console.log($("#big_img > div"));
                //$("#big_img .loader").remove();
                $("#big_img").prepend(data);
                $("#big_img div.image").fadeIn(500);
                $("#big_img>a").attr("href", href);
                //console.log($("#big_img > div"));
            }
        });
//		$(".left_img>a").attr("rel","rr");
//		$(this).removeAttr("rel");
//	 	
//		
        return false;
	 });
	 //при наведении на область большого изображения выводим ссылку на fancybox
	 //также добавляем атрибут class=fancybox для ссылок миниатюр
	 $("#big_img").hover(function(){
        
		 $("#big_img>a").css("visibility","visible");
		 $(".left_img>a").addClass("fancybox");
	 }, function() {
		 $("#big_img>a").css("visibility","hidden");
		 $(".left_img>a").removeClass("fancybox");
	 });
	 
    
	// Обработка поведения для выпадающего списка выбора город
    setSelectedText();
    
	$('#idSelect').change(function(){
		setSelectedText();
        $.ajax({
            url: '/site/initCity',
            type: 'POST',
            data: {
                city_id: this.options[this.selectedIndex].value,
            },
            success: function(city){
                window.location.reload();
            }
        });
	});
    
    $(".fancybox").fancybox({
		openEffect	: 'none',
		closeEffect	: 'none'
    });
    
    $(".ajaxfancybox").fancybox({
        type: 'ajax',
    });
    
    $(".iframefancybox").fancybox({
        type: 'iframe',
    });
    
    $("input[type='checkbox']").live('click', function(){
        if (this.checked)
            $(this).parent().parent().removeClass('checkboxOff').addClass('checkboxOn');
        else
            $(this).parent().parent().removeClass('checkboxOn').addClass('checkboxOff');
    });
});

function setSelectedText() {
    $('#idSelect')
		.parent()
		.find('.center')
		.html($('#idSelect :selected').html());
        
    $('#city_form .selected_city').text('Выбранный город: ' + $('#idSelect :selected').html());
}
