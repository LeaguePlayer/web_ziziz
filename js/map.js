var Map;
var STOMarkers;
var ShopMarkers;

var markCollections = {};

ymaps.ready(function(){
    Map = new ymaps.Map('map', {
        //center: [cur_loc.latitude, cur_loc.longitude],
        center: [0, 0],
        zoom: 10,
        behaviors: ["scrollZoom", "drag", "ruler"]
    });
    
    Map.controls.add(
        new ymaps.control.ZoomControl()
    );
    
    // Поиск текущего города
    var myGeocoder = ymaps.geocode(
        $('#cur_city').val(), {
        }
    );
    myGeocoder.then(function (res) {
        var point = res.geoObjects.get(0);
        Map.panTo(point.geometry.getCoordinates());
    });


    // Макет создается с помощью фабрики макетов с помощью текстового шаблона.
    var BalloonContentLayout = ymaps.templateLayoutFactory.createClass(
        '<div style="margin: 10px;">' +
            '<h3>$[properties.name]</h3>' +
            '<p><strong>Адрес:</strong> $[properties.address]</p>' +
        '</div>'
    );    
    
    
    $("#map_menu ul li.map_item a").each(function(index, item) {
        var $item = $(item);
        var mark = new ymaps.GeoObjectCollection({}, {
            iconImageHref: $item.attr('icon'),
            iconImageSize: [15, 25],
            iconImageOffset: [-8, -30],
            balloonContentLayout: BalloonContentLayout,
        });
        markCollections[$item.attr('rel')] = mark;
    });
    
    
    $.ajax({
        url: '/company/getCompanies',
        type: 'GET',
        data: {type: null},
        success: function(data){
            if (data != false)
            {
                var companies = JSON.parse(data);
                $(companies).each(function() {
                    
                    markCollections['all'].add(new ymaps.Placemark(
                        [this.coords[1], this.coords[0]], {
                            hintContent: this.name,
                            name: this.name,
                            address: this.address,
                            description: this.description
                        }
                    ));
                    
                    if (this.type in markCollections) {
                        markCollections[this.type].add(new ymaps.Placemark(
                            [this.coords[1], this.coords[0]], {
                                hintContent: this.name,
                                name: this.name,
                                address: this.address,
                                description: this.description
                            }
                        ));
                    }
                    
                });
                
                Map.geoObjects.add(markCollections['all']);
                Map.setBounds(markCollections['all'].getBounds(), {
                    duration: 1000,
                });
            }
        }
    });
});




function markEvent(e) {
    mark = e.get('target');
    Map.panTo(
        [mark.geometry.getCoordinates()],
        {
            delay: 0,
            duration: 1000,
            callback: function() {
                Map.setZoom(17, {
                    duration: 1000,
                    callback: function() {}
                });
            }
        }
    );
}




function visibleCollection(type) {
    for (var key in markCollections) {
        Map.geoObjects.remove(markCollections[key]);
    }
    Map.geoObjects.add( markCollections[type] );
    Map.setBounds( markCollections[type].getBounds(), {
        duration: 1000,
    });
}


$(document).ready(function(){
    $('#map_menu a').click(function() {
        visibleCollection($(this).attr('rel'));
    });
});

//    function getBounds(collection) {
//        var first_run, max_lat, max_long, min_lat, min_long;
//        min_lat = min_long = max_lat = max_long = 0;
//        first_run = true;
//        collection.each(function(i) {
//            var _lat, _long, _ref;
//            _ref = i.geometry.getCoordinates(), _lat = _ref[0], _long = _ref[1];
//            if (first_run) {
//                first_run = false;
//                min_lat = max_lat = _lat;
//                min_long = max_long = _long;
//            } else {
//                min_lat = Math.min(min_lat, _lat);
//                max_lat = Math.max(max_lat, _lat);
//                min_long = Math.min(min_long, _long);
//                max_long = Math.max(max_long, _long);
//            }
//        });
//        if (min_lat == max_lat) {
//            min_lat -= .0005;
//            max_lat += .0005;
//        }
//        if (min_long == max_long) {
//            min_long -= .0005;
//            max_long += .0005;
//        }
//        return [[min_lat - .0005, min_long - .0005],[max_lat + .0005, max_long + .0005]];
//    };