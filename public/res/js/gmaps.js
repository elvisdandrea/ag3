function GMaps(){}

GMaps.prototype = {
    init : function(elementId, lat, lng, zoom) {
        if ($(window).width() > 400) {
            lat = lat - 0.0028895;
            lng = lng - 0.0003895;
        } else {
            lat = lat - 0.0014895;
            lng = lng - 0.0001095;
        }
        var latlng = new google.maps.LatLng(lat, lng);
        var myOptions = {
            zoom: zoom,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        GMaps.map = new google.maps.Map(document.getElementById(elementId), myOptions);
    },

    add_point : function(lat, lng, contentString, contentTitle)
    {

        var latlng = new google.maps.LatLng(lat, lng);
        var marker = new google.maps.Marker({
            position: latlng,
            map: GMaps.map,
            title:contentTitle
        });

        if(contentString){
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(GMaps.map,marker);
            });
        }


    },

    add_point_beta : function(a)
    {
        if(a.tipo != undefined){
            switch(a.tipo){
                case 'move_drop':
                    var marker = new google.maps.Marker({
                        map: GMaps.map,
                        position: GMaps.map.getCenter()
                    });

                    marker.setDraggable(true);
                    google.maps.event.addListener(marker, 'dragend', function() {
                        var l = marker.getPosition();
                        var tipo = (a.save_tipo != undefined ? a.save_tipo : 'text')

                        if(a.save_id.attr('id') != undefined){
                            switch(tipo){
                                default:
                                    a.save_id.val(l.lat() + ',' + l.lng());
                                    break;
                            }
                        }
                    });
                    break;
            }
        }

    },

    add_circle : function(lat, lng){
        var latlng = new google.maps.LatLng(lat, lng);
        var circle = new google.maps.Circle({
            map: GMaps.map,
            radius: 800, // 800 metros
            center: latlng
        });
    }
}

var GMaps = new GMaps();
