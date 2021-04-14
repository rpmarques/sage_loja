$(function(){

    //PEGAR O TOKEN DO CARTÃO
    $('.comprar').on('click', function(){
        var id = PagSeguroDirectPayment.getSenderHash();
        //DADOS DO CLIENTE
        var nome=$('input[name=nome]').val();
        var cpf=$('input[name=cpf]').val();
        var email=$('input[name=email]').val();
        var senha=$('input[name=senha]').val();
        var telefone = $('input[name=telefone]').val();
        //LOCALIDADE
        var cep=$('input[name=cep]').val();
        var rua=$('input[name=rua]').val();
        var numero=$('input[name=numero]').val();
        var complemento=$('input[name=complemento]').val();
        var bairro=$('input[name=bairro]').val();
        var cidade=$('input[name=cidade]').val();
        var estado=$('input[name=estado]').val();
        //DADOS DO CARTÃO
        var nro_cartao=$('input[name=nro_cartao]').val();
        var cpf_cartao=$('input[name=cpf_cartao]').val();
        var titular_cartao=$('input[name=titular_cartao]').val();
        var nro_cvv = $('input[name=nro_cvv]').val();
        var validade_mes =$('select[name=cartao_mes]').val();
        var validade_ano =$('select[name=cartao_ano]').val();
        var parc =$('select[name=parcelas]').val();

        if (nro_cartao!='' && nro_cvv!='' && validade_mes!='' && validade_ano!=''){
            PagSeguroDirectPayment.createCardToken({
                cardNumber:nro_cartao,
                brand: window.bandeira,
                cvv:nro_cvv,
                expirationMonth:validade_mes,
                expirationYear:validade_ano,

                success:function(r){
                    window.cardToken = r.card.token;
                    //AQUI FAÇO O PAGAMENTO VIA AJAX
                    $.ajax({
                        url:BASE_URL+'pagsegurotransparente/checkout',
                        type:'POST',
                        data: {
                            id:id,
                            name:nome,
                            cpf:cpf,
                            email:email,
                            senha:senha,
                            cep:cep,
                            rua:rua,
                            numero:numero,
                            complemento:complemento,
                            bairro:bairro,
                            cidade:cidade,
                            estado:estado,
                            nro_cartao:nro_cartao,
                            cpf_cartao:cpf_cartao,
                            titular_cartao:titular_cartao,
                            nro_cvv:nro_cvv,
                            validade_mes:validade_mes,
                            validade_ano:validade_ano,
                            cartaoToken:window.cardToken,
                            parc:parc,
                            telefone:telefone
                        },
                        dataType:'json',
                        success:function(json){
                            if(json.error=true){
                                alert(json.msg);
                            }else{
                                window.location.href = BASE_URL + 'pagsegurotransparente\obrigado';
                            }
                         },
                        error:function(r){ 
                            alert("temos erro[AJAX]");
                            console.log(r);
                        },
                    });
                },
                error:function(r){
                    alert("temos erro [createCardToken]");
                    console.log(r);
                },
                complete:function(r){},
            });
        }
    });


    /* PARA PEGAR A BANDEIRA DO CARTÃO DIRETO DO PAGSEGURO */
    $('input[name=nro_cartao]').on('keyup', function(e){
        if($(this).val().length == 6){
            PagSeguroDirectPayment.getBrand({
                cardBin: $(this).val(),
                success:function(r){ 
                    // WINDOW. DEIXA A VARIABEL GLOBAL    
                    window.bandeira = r.brand.name;
                    var cvvLimite = r.brand.cvvSize;
                    //PASSO O VALOR DA VARIAVEL PRO CAMPO LA NO HTML
                    $('input[name=nro_cvv]').attr('maxlength', cvvLimite);
                    $('input[name=bandeira_cartao]').attr('value', bandeira);
                    /*PEGAR PARCELAMENTO*/

                    PagSeguroDirectPayment.getInstallments({                                                
                        amount:$('input[name=total]').val(), //TOTAL DA COMPRA
                        brand:window.bandeira, //BANDEIRA DO CARTÃO
                        //maxInstallmentNoInterest:3, //NRO DE PARCELAMENTOS SEM JUROS
                        success:function(r){
                            if (r.error == false){
                                var parc = r.installments[window.bandeira];
                                var html='';
                                //optionValue='';
                                // MONTO OS OPTINOS AQUI E DEPOIS DEVOLVO O PRO HTML
                                for(var i in parc){
                                     var optionValue = parc[i].quantity +';'+parc[i].installmentAmount+';';
                                     if (parc[i].interestFree == true){
                                         optionValue += 'true';
                                     }else{
                                         optionValue += 'false';
                                     }
                                    html+='<option value="' + optionValue + '">'+ parc[i].quantity +' vezes de R$ ' + parc[i].installmentAmount + '</option>';
                                }
                                //DEVOLVO PRO HTML
                                $('select[name=parcelas]').html(html);
                            }
                        },
                        error:function(r){
                            console.log(r);
                        },
                        complete:function(r){},
                    }); //FIM PagSeguroDirectPayment.getInstallments({
                },
                error:function(r){
                    alert('bin inválido');
                },
                copmlete:function(r){}
            }); //FIM PagSeguroDirectPayment.getBrand({

        }
    });
});