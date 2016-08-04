
/*
* Verifica se é mobile
* return: true || false
* */

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};


/*
 * Verifica largura da tela
 * return: width
 * */

function screenWidth() {
    var width = window.outerWidth;

    return width;
}


if(isMobile.any() || screenWidth() <= 768) {

    /*
     * Abre o menu
     * */
    (function openMenu(){
        var btnOpenCategories = document.querySelector('.open-menu');

        btnOpenCategories.addEventListener('click', function(){
            this.classList.toggle('open');
            document.querySelector('.menu').classList.toggle('open');
        })
    }());
}


/*
 * Slider da Home
 * */
$('.slider-home').flexslider({
    animation: "slide",
    directionNav: false
});


/*
 * Galeria de imagens
 * */
$('#thumbs').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 155,
    itemMargin: 20,
    asNavFor: '#img-grande'
});

$('#img-grande').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#thumbs",
    directionNav: false,
    start: function () {
        setTimeout(function(){
            var height = $('#img-grande').find('.lightbox-galeria > img').first().height();
            $('#img-grande').height(height + 'px');
        }, 200);
    },
    after: function() {
        var height = $('.flex-active-slide').find('.lightbox-galeria > img').height();
        $('#img-grande').animate({
            height: height + 'px'
        });
    }
});


/*
 * Fancybox
 * */
$(".lightbox-galeria").fancybox({
    border: 25
});

$(".lightbox").fancybox({
    border: 25,
    width: 450
});

$(document).ready(function() {
    $('.fone-input').mask('(00) 0000-0000');
});
