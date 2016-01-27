$('html, body').scrollTop($('.title-section').offset().top - 5);

$(document).on('submit', '#contato-imovel', function(e){
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        data: $(this).serializeArray(),
        success: function(r) {
            var contatobox = $('#contato-resposta').show();
            contatobox.find('#message').html(r);
            $('#contato-resposta').trigger('click');
            $('#contato-imovel')[0].reset();
            setTimeout( function() {
                $.fancybox.close();
            },3000);
            return false;
        }
    });
    return false;
});

$('#contato-resposta').fancybox();