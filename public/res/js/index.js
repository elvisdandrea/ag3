$(document).on('change', '#destinacao', function(e) {
    var value = $(this).val();
    $.ajax({
        url: "index/tipo-venda",
        dataType: 'JSON',
        data: {type: value},
        success:function(json){
            $('#preco-inicial').html(json.from);
            $('#preco-final').html(json.to);
        }
    });
});