<h1>carrinho de compra</h1>
<?php $sub_total = 0;?>
    <table border="0" width="100%">
        <tr>
            <th width="100">Imagem</th>
            <th>Nome</th>
            <th width="130">Qtde</th>
            <th width="130">Valor Unit.</th>
            <th width="130">Total Item</th>
            <th width="20"></th>
        </tr>
        <?php foreach($itens_carrinho as $item):?>
            <tr>
                <td><img width="80" src="<?= BASE_URL;?>/media/products/<?= $item['imagem'];?>" ></td>
                
                <td><?= $item['name']?></td>
                <td><?=  $item['qtde']?></td>
                <td><?= number_format($item['price'],2,',','.')?></td>
                <td><?= number_format(intval($item['qtde']) * floatval($item['price']),2,',','.') ?></td>
                <?php $sub_total += (intval($item['qtde']) * floatval($item['price']));?>
                <td> <a href="<?= BASE_URL ?>cart/del/<?= $item['id'];?>"> <img src="<?= BASE_URL ?>assets/images/delete.png" width="28" > </a></td>
            </tr>
        <?php endforeach;?>
        <tr>
            <td colspan="4" align="right">Sub Total: </td>
            <td><strong> R$ <?= number_format($sub_total,2,',','.')?> </strong></td>
        </tr>
        <tr>
            <td colspan="4" align="right">Frete: </td>
            <td>
                <?php if (isset($shipping['price'])): ?>
                    <?php $frete = floatval(str_replace(',','.',$shipping['price']));?>                    
                    <strong> R$ <?= $shipping['price'];?>(<?= $shipping['date'];?>) dia(s) 
                <?php else: ?>
                    <?php $frete = 0;?>
                    CEP:
                    <form method="post">
                        <input type="number" name="cep" ><br>
                        <input type="submit" value="Calcular">
                    </form>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="right">Total: </td>
            <?php $total = $sub_total+$frete;?>
            <td><strong> R$ <?= number_format($total,2,',','.')?> </strong></td>
        </tr>
    </table>
<hr>

<?php if ($frete > 0): ?>
    <form action="<?= BASE_URL;?>cart/pagamento" method="post" style="float:right">
        <select name="tipo_pagamento">
            <option value="pagseguro_transparente">PagSeguro Transparente</option>
        </select>
        <button type="submit" class="botao">Finalizar Compra</button>
    </form>
<?php endif; ?>


