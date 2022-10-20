//Url general de todo el proyecto
var url= 'http://proyecto-laravel.com.devel';

window.addEventListener("load", function(){
   //Añadimos el puntero
   $('.btn-like').css('cursor', 'pointer');
   $('.btn-dislike').css('cursor', 'pointer');

    //Usando JQuery: Boton de Like
    function like(){
    $('.btn-like').unbind('click').click(function(){
        $(this).addClass('btn-dislike').removeClass('btn-like');
        $(this).attr('src', url+'/img/hearts-red.png');

        //Petición Ajax
    $.ajax({
        url: url+'/like/'+$(this).data('id'),
        type: 'GET',
        success: function(response){
            if(response.like){
                console.log('Has dado like a la publicación');
            }else{
                console.log('Error al dar like');
            }
        }

    });
        dislike();
    });
  }
    like();
     
     //Usando JQuery: Boton de Dislike

     function dislike(){
     $('.btn-dislike').unbind('click').click(function(){
        $(this).addClass('btn-like').removeClass('btn-dislike');
        $(this).attr('src', url+'/img/hearts-white.png');

        $.ajax({
            url: url+'/dislike/'+$(this).data('id'),
            type: 'GET',
            success: function(response){
                if(response.like){
                    console.log('Has dado dislike a la publicación');
                }else{
                    console.log('Error al dar like');
                }
            }
    
        });


        like();
    });
  }
dislike();

//BUSCADOR
$('#buscador').submit(function(e){
    // e.preventDefault();
    $(this).attr('action',url+'/gente/'+$('#buscador #search').val());
    
});


});