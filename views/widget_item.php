<?php foreach($list as $widget_item):?>

    <div class="widget_item">
        <a href="<?= BASE_URL; ?>product/open/<?= $widget_item['id'];?>">
            <div class="widget_info">
                <div class="widget_productname"><?= $widget_item['name']; ?></div>
                <div class="widget_price"> 
                    <span>R$ <?= number_format($widget_item['price_from'],2,',','.'); ?></span> 
                    R$ <?= number_format($widget_item['price'],2,',','.'); ?>
                </div>
            </div>
            <div class="widget_photo">
                <img src="<?php echo BASE_URL;?>media/products/<?= $widget_item['images'][0]['url']?>" >
            </div>
            <div style="clear:both;"></div>

        </a>
    </div>

<?php endforeach;?>