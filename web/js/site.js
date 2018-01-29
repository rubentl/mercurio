$(document).ready(function() {
    $('body').css({'backgrounColor':'#eee'});
    $('h1').addClass('animated fadeInDown lento');
    $('h2').addClass('animated rollIn lento');
    $('.panel').addClass('animated zoomIn lento');
    $('.glyphicon.glyphicon-user').addClass('animated pulse infinite');
    $('.panel').addClass('sombra');
    ['div.thumbnail','input','textarea','button[type=submit]', 'select'].forEach(function(item){
        $(item).addClass('sombra');
    });
});
