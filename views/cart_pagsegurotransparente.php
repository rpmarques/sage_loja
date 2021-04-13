<h1> CHECKOUT TRANSPARENTE PAGSEGURO</h1>

<h3>Dados:</h3>
<strong>NOME:</strong>
<input type="text" name="nome" value="Ricardo Pereira Marques"><br><br>

<strong>CPF:</strong>
<input type="text" name="cpf" value="80998739049" ><br><br>

<strong>TELEFONE:</strong>
<input type="text" name="telefone" value="55997290002" ><br><br>

<strong>EMAIL:</strong>
<input type="email" name="email" value="c79968513705754159978@sandbox.pagseguro.com.br"><br><br>

<strong>SENHA:</strong>
<input type="password" name="senha" VALUE="FH3XkUxnLy559Hv7"><br><br>

<hr>
<h3>Endereço</h3>
<strong>CEP:</strong>
<input type="text" name="cep" value="97573560"><br><br>

<strong>RUA:</strong>
<input type="text" name="rua"value="Rua Manduca Rodrigues" ><br><br>

<strong>NÚMERO:</strong>
<input type="text" name="numero" value="432"><br><br>

<strong>COMPLEMENTO:</strong>
<input type="text" name="complemento" value="1" > <br><br>

<strong>BAIRRO:</strong>
<input type="text" name="bairro" value="Centro"><br><br>

<strong>CIDADE:</strong>
<input type="text" name="cidade" value="Santana do Livramento"><br><br>

<strong>ESTADO:</strong>
<input type="text" name="estado" value="RS"><br><br>

<hr>
<h3>PAGAMENTO</h3>

<strong>NRO CARTAO:</strong>
<input type="text" name="nro_cartao" value=""><br><br>

<strong>TITULAR DO CARTÃO:</strong>
<input type="text" name="titular_cartao" value="Ricardo Pereira Marques "><br><br>

<strong>CPF CARTAO:</strong>
<input type="text" name="cpf_cartao" value="80998739049"><br><br>

<strong>CÓDIGO DE SEGURANÇA CARTAO:</strong>
<input type="text" name="nro_cvv" value="123"><br><br>

<strong>BANDIERA DO CARTÃO CARTAO:</strong>
<input type="text" name="bandeira_cartao" value=""><br><br>

<strong>VALIDADE MÊS CARTÃO:</strong>
<select name="cartao_mes" >
    <?php for($q=1;$q<13;$q++):?>
        <option><?= ($q<10)?'0'.$q:$q; ?></option>
    <?php endfor;?>
</select>

<strong>EXPIRACAO ANO CARTÃO:</strong>
<select name="cartao_ano" >
<?php $ano = intval(date('Y')); ?>
<?php for($q=$ano;$q<=($ano+20);$q++): ?>
        <option><?= $q ?></option>
    <?php endfor;?>
</select>
<hr>
<strong>PARCELAMENTO:</strong>
<select name="parcelas" ></select>
<input type="hidden" name="total" value="<?php echo str_replace(',','',$total) ; ?>" />
<hr>
<br>
<button class="botao comprar"> Comprar</button>

<!-- CARREGO O PAGSEGURO -->
<script type="text/javascript" src=
"https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script src="<?= BASE_URL;?>assets/js/pagsegurotransparente.js"></script>
<!-- SETO A SESSÃO PRA PODER INICIAR -->
<script type="text/javascript">
PagSeguroDirectPayment.setSessionId('<?= $sessionCode;?>');
</script>