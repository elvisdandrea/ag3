$('html, body').animate({
    scrollTop: $('.view-imovel').offset().top - 20 + 'px'
}, 1000);

if (GMaps.mapLatitude != undefined && GMaps.mapLatitude != '') {
    GMaps.init('mapa-imovel', GMaps.mapLatitude, GMaps.mapLongitude, 16);
    GMaps.add_point(GMaps.mapLatitude, GMaps.mapLongitude);
}

