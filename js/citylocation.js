ymaps.ready(function(){
    var current_location = ymaps.geolocation;
    if (current_location != undefined) {
        $.ajax({
            url: '/site/initCity',
            type: 'POST',
            data: {
                city_name: current_location.city,
                response: true,
            },
            success: function(city) {
                if (city) window.location.reload();
            }
        });
    }
});