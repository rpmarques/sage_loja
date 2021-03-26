$(function(){
    // https://jqueryui.com/slider/#range
    // COMPONENTE PRA FAZER O SLYDER DE VALORES
    //variavel maxslider criado no template, la ela vai receber esse valor dinamicamente
    //variavel minslider criado no template, la ela vai receber esse valor dinamicamente
    $( "#slider-range" ).slider({
        range: true,
        min: 0, //VALOR MÍNIMO
        max: maxslider, //VALOR MÁXIMO
        values: [$('#slider0').val(),$('#slider1').val()], //VALORES INICIAS
        //MONTA O SLIDER
        slide: function( event, ui ) {
          $( "#amount" ).val( "R$" + ui.values[ 0 ] + " - R$" + ui.values[ 1 ] );
        },
        change: function(event, ui){
          $('#slider' + ui.handleIndex).val(ui.value);                    
          $('.filterarea form').submit();
        }
      });
      //exibe os dados
      $( "#amount" ).val( "R$" + $( "#slider-range" ).slider( "values", 0 ) +
        " - R$" + $( "#slider-range" ).slider( "values", 1 ) );

        //submete o formulario que esta no $('.filterarea')
      $('.filterarea').find('input').on('change', function(){
        $('.filterarea form').submit();
      });

    }
);