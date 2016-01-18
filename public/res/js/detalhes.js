$('html, body').animate({
    scrollTop: $('.view-imovel').offset().top - 20 + 'px'
}, 1000);

if (GMaps.mapLatitude != undefined && GMaps.mapLatitude != '') {
    GMaps.init('mapa-imovel', GMaps.mapLatitude, GMaps.mapLongitude, 15);
    GMaps.add_circle(GMaps.mapLatitude, GMaps.mapLongitude);
}

