<div class="row">
    <div class="col-sm-5">
        <div class="foto_principal">
        <img src="<?= BASE_URL?>media/products/<?= $produto_imagens[0]['url']?>" border="0" >
        </div>
        <div class="galeria">
            <?php foreach( $produto_imagens as $img):?>
                <div class="foto_item">
                <img src="<?= BASE_URL?>media/products/<?= $img['url']?>" border="0" >
                </div>
                
            <?php endforeach;?>
            
        </div>
    
    </div>
    <div class="col-sm-7">
        <h2><?= $produto['name']; ?></h2>
        <small><?= $produto['nome_marca'];?></small>
        <!-- ESTRELAS DE AVALIAÇÃO DO PRODUTO -->
        <?php if($produto['rating'] !=0 ):?>
            <hr>
            <?php for($q=0;$q<intval($produto['rating']);$q++):?>
                    <img src="<?= BASE_URL?>assets/images/star.png" border="0" height="15">
            <?php endfor;?>

        <?php endif;?>
        <hr>
        <p><?= $produto['description']; ?></p>
        <hr>
        De: <span class="preco_antigo">R$ <?= number_format($produto['price_from'],2); ?></span>
        <br>
        Por: <span class="preco_original">R$ <?= number_format($produto['price'],2); ?></span>
        <!-- TENHO UM JAVASCRIPT QUE FAZ SEM DAR REFRESH NA PÁGINA -->
        <form method="POST" class="add_to_cart_form" action="<?= BASE_URL;?>cart/add">
            <input type="hidden" name="id_produto" value="<?= $produto['id']; ?>">
            <!-- POR JAVASCRIPT EU TROCO O CONTEÚDO DO VALUE -->
            <input type="hidden" name="qtde_produto" value="1">
            <button data-action="diminui">-</button>
            <input type="text" name="qtde" value="1" class="add_to_cart_qtde" disabled/>
            <button data-action="aumenta">+</button>
            <input class="btn_add_to_cart" type="submit" value="<?php $this->lang->get('ADD_TO_CART'); ?>">
        </form>        
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-6">
    <h3><?php $this->lang->get('SPECIFICATIONS'); ?></h3>
        <?php foreach($produto_opcao as $op_item):?>
        <strong><?= $op_item['name'];?>:</strong> <?= $op_item['value'];?><br>
        <?php endforeach;?>
    </div>
    <div class="col-sm-6">
        <h3><?php $this->lang->get('REVIEWS'); ?></h3>
        <?php foreach($produto_avaliacao as $av_item):?>
            <strong><?= $av_item['nome_user'] ?></strong> - Avaliação:
                <?php for($q=0;$q<intval($av_item['points']);$q++):?>
                        <img src="<?= BASE_URL?>assets/images/star.png" border="0" height="15">
                <?php endfor;?>
                <br>
            <?= $av_item['comment'] ?>
            <hr>
        <?php endforeach;?>
    </div>
</div>