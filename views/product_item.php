<div class="produtc_item"> 
    <a href="<?= BASE_URL; ?>product/open/<?= $id; ?>">

    <div class="product_tags">
        <?php if ($sale == '1'):?>
            <div class="product_tag product_tag_red"><?= $this->lang->get('SALE'); ?></div>
        <?php endif;
        if ($bestseller == '1'): ?>            
            <div class="product_tag product_tag_green"><?= $this->lang->get('BESTSELLER'); ?></div>
         <?php endif;
         if ($new_product== '1'):?>   
            <div class="product_tag product_tag_blue"><?= $this->lang->get('NEW'); ?></div>
            <?php endif; ?>
    </div>
        <div class="product_image">
            <img src="<?php echo BASE_URL;?>media/products/<?= $images[0]['url']?>"  width="100%">
        </div>
        <div class="product_name"> <?= $name ?></div>
        <div class="product_brand"> <?= $nome_marca ?></div>
        <div class="product_price_from"> 
            <?php if ($price_from!='0'){
                echo 'R$ '.number_format($price_from,2,',','.');
            }?></div>
        <div class="product_price"> <?=  'R$ '.number_format($price,2,',','.');?></div>
        <div style="clear:both"></div>        
    </a>
</div>