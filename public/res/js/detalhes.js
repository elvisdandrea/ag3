$('html, body').animate({
    scrollTop: $('.view-imovel').offset().top - 20 + 'px'
}, 1000);

if (GMaps.mapLatitude != undefined && GMaps.mapLatitude != '') {
    GMaps.init('mapa-imovel', GMaps.mapLatitude, GMaps.mapLongitude, 15);
    GMaps.add_circle(GMaps.mapLatitude, GMaps.mapLongitude);
}

$(document).on('submit', '#contato-imovel', function(e){

    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        data: $(this).serializeArray(),
        success: function(r) {
            $('#contato-imovel').find('.contato-resposta').html(r).show();
            $('#contato-imovel').find('.contato-resposta').trigger('click');
            $('#contato-imovel')[0].reset();
            setTimeout( function() {
                $.fancybox.close();
            },3000);
            return false;
        }
    });
    return false;
});

$(document).on('click', '#add-fav', function(e){
    e.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        type: 'get',
        success: function(r) {
            $('#fav-content').fancybox().trigger('click');
            return false;
        }
    });
    return false;
});

