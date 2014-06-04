$(document).ready(function() {
    $(document).click(function(event) {
    	$("#profile .the_menu").hide();
    });
    
    new AjaxUpload('#avatar', {
        //crossDomain: true,
        // какому скрипту передавать файлы на загрузку? только на свой домен
        action: '/users/updateAvatar/',
        // имя файла
        name: 'Avatar',
        //multiple: false,
        // дополнительные данные для передачи
        data: {
            user_id : $('#Users_user_id').val(),
        },
        // авто submit
        autoSubmit: true,
        // формат в котором данные будет ответ от сервера .
        // HTML (text) и XML определяются автоматически .
        // Удобно при использовании  JSON , в таком случае устанавливаем параметр как "json" .
        // Также установите тип ответа (Content-Type) в text/html, иначе это не будет работать в IE6
        responseType: false,
        // отправка файла сразу после выбора
        // удобно использовать если  autoSubmit отключен
        onChange: function(file, extension){},
        // что произойдет при  начале отправки  файла
        onSubmit: function(file, extension) {
            $('#profile .left .hor_loader').show();
        },
        // что выполнить при завершении отправки  файла
        onComplete: function(file, response) {
            $('#profile .left .hor_loader').hide();
            if (response=='error')
            alert(response);
                //alert('Ошибка загрузки файла');
            else
                $('#avatar_image').replaceWith(response);
        }
    });
});
	$("#profile input:checkbox").live('click', function() {
        var thisClass = $(this).attr('class');
        
        if ($(this).attr('rel')=='all'){
            if (this.checked)
                $('#profile input[class=' + thisClass +']:checkbox:not([rel=all])')
                    .attr('checked', this.checked)
                    .parent().parent().removeClass('checkboxOff').addClass('checkboxOn');
            else
                $('#profile input[class=' + thisClass +']:checkbox:not([rel=all])')
                    .attr('checked', this.checked)
                    .parent().parent().removeClass('checkboxOn').addClass('checkboxOff');
        }
        
        var checkedCount = $('#profile input[class=' + thisClass +']:checkbox:checked:not([rel=all])').length;
        
        if (checkedCount > 0)
            $('#profile input:submit[class*=' + thisClass + ']').removeAttr('disabled').removeClass('disabled');
        else
            $('#profile input:submit[class*=' + thisClass + ']').attr('disabled', 'disabled').addClass('disabled');
	});
    
    $("#profile input[name*=extend]").live('click', function() {
    	$(this).next('ul.the_menu').show();
        return false;
    }); 

    
    $("ul.the_menu a").live('click', function() {
        var inp = $(this).parents('ul').prev('input');
        if (inp.hasClass('auto'))
            var thisClass = 'auto';
        else
            var thisClass = 'ann';
        
        $("ul.the_menu").hide();
        
        $(this).parents('.button').find('.hor_loader').show();
        console.log($(this).parents('.button').find('.hor_loader'));
        
        $.ajax({
            url: 'view?id='+$('#Users_user_id').val(),
            type: 'POST',
            data: {
                Users: {
                    extend: thisClass,
                    checked: serializeChecked(thisClass),
                    interval_code: $(this).attr('rel'),
                }
            },
            success: function(data) {
                $('#annlist').html(data);
            }
        });
        return false;
    });


function serializeChecked(thisClass) {
    var arr = {};
    var checkboxes = $('#profile input[class=' + thisClass +']:checkbox:checked:not([rel=all])');
    $.each(checkboxes, function() {
        arr[$(this).attr('rel')] = 1;
    });
    return arr;
};