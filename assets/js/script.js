$(function(){
    // https://jqueryui.com/slider/#range
    // COMPONENTE PRA FAZER O SLYDER DE VALORES
    //variavel maxslider criado no template, la ela vai receber esse valor dinamicamente
    //variavel minslider criado no template, la ela vai receber esse valor dinamicamente
    
    if (typeof maxslider != 'undefined'){
      $( "#slider-range" ).slider({
        range: true,
        min: 0, //VALOR MÍNIMO
        max: maxslider, //VALOR MÁXIMO
        values: [$('#slider0').val(), $('#slider1').val()], //VALORES INICIAS
        
        //MONTA O SLIDER
        slide: function( event, ui ) {
          $( "#amount" ).val( "R$" + ui.values[ 0 ] + " - R$" + ui.values[ 1 ] );
        },
        
        change: function(event, ui){
          $('#slider' + ui.handleIndex).val(ui.value);                    
          $('.filterarea form').submit();
        }
      });
    };
    

      //exibe os dados
      $( "#amount" ).val( "R$" + $( "#slider-range" ).slider( "values", 0 ) +
        " - R$" + $( "#slider-range" ).slider( "values", 1 ) );

        //submete o formulario que esta no $('.filterarea')
      $('.filterarea').find('input').on('change', function(){
        $('.filterarea form').submit();
      });

      //BOTÃO DE ADICIONAR QTDE APENAS NA PÁGINA DO PRODUTO,
      // ONDE TEM UM BOTÃO COM A CLASSE 'add_to_cart_form button'
      $('.add_to_cart_form button').on('click', function(e){
        //QNDO CLICO NO BOTÃO QUE ESTA DENTRO DA CLASSE .add_to_cart_form
        // ELE NÃO FAZ O SUBMIT
        e.preventDefault(); 
        //PEGO O VALOR DO CAMPO .add_to_cart_qtde
        var qtde = parseInt($('.add_to_cart_qtde').val());
        //PEGO O VALOR DA PROPRIEADE data-action
        var acao = ($(this).attr('data-action')); 

        if (acao == 'diminui' ){
          if(qtde-1 >=1 ){ //não deixo ficar com zero
            qtde = qtde - 1;
          }
        }
        else if (acao == 'aumenta' ){
          qtde = qtde + 1;
        }

        //DEVOLVO PRO FORM COM O NOVO VALOR
        $('.add_to_cart_qtde').val(qtde)
        $('input[name=qtde_produto]').val(qtde)
      });

      //GALERIA      
      $('.foto_item').on('click', function(){
        // PEGO O ATRIBUTO src do elemento que esta dentro de .find('img')
        var url = $(this).find('img').attr('src');
        //PASSO O URL
        $('.foto_principal').find('img').attr('src',url);

      });

      //

    }
);