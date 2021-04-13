<aside>
    <h1><?php $this->lang->get('FILTER'); ?></h1>
    <div class="filterarea">
        
        <form method="GET">

            <input type="hidden" name="s" value="<?= (isset($viewData['textoBusca']))?$viewData['textoBusca']:''; ?>">
            <input type="hidden" name="category" value="<?= (isset($viewData['category']))?$viewData['category']:''; ?>">


            <!-- FILTRO DE MARCAS -->
            <div class="filterbox">
                <div class="filtertitle"> <?php $this->lang->get('BRANDS'); ?> </div>
                <div class="filtercontent">
                    <?php foreach($viewData['filters']['brands'] as $marca_item): ?>
                        <div class="filteritem marcas">
                            <input type="checkbox" 
                            <?= (isset($viewData['filters_selected']['brand']) && in_array($marca_item['id'],$viewData['filters_selected']['brand']))?'checked="checked"':'';?>
                            name="filter[brand][]" value="<?= $marca_item['id'];?>" id="filter_brand<?= $marca_item['id'] ?>"/> 
                            <label for="filter_brand<?= $marca_item['id'] ?>"><?= $marca_item['name']; ?>  </label> 
                            <span style="float:right;">(<?= $marca_item['count']; ?>)</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- FAIXA DE PREÇOS -->
            <div class="filterbox">
                <div class="filtertitle"> <?php $this->lang->get('PRICE'); ?> </div>
                <div class="filtercontent">
                        <input type="hidden" id="slider0" name="filter[slider0]" value="<?= $viewData['filters']['slider0']?>">
                        <input type="hidden" id="slider1" name="filter[slider1]" value="<?= $viewData['filters']['slider1']?>">
                        <input type="text" id="amount" readonly >				
                    <div id="slider-range"></div>
                </div>
            </div>
            <!-- FILTRO DE ESTRELAS -->
            <div class="filterbox">
                <div class="filtertitle"> <?php $this->lang->get('RATING'); ?> </div>
                <div class="filtercontent">
                    <div class="filteritem">
                        <input type="checkbox" 
                        <?= (isset($viewData['filters_selected']['filter_star']) && in_array('0',$viewData['filters_selected']['filter_star']))?'checked="checked"':'';?>
                        name="filter[filter_star][]" value="0" id="filter_star0"> 
                        <label for="filter_star0">
                            ( <?php $this->lang->get('NO_STAR'); ?>)
                        </label> 
                        <span style="float:right;">(<?= $viewData['filters']['stars']['0']; ?>)</span>
                    </div>
                    <div class="filteritem">
                        <input type="checkbox" 
                        <?= (isset($viewData['filters_selected']['filter_star']) && in_array('1',$viewData['filters_selected']['filter_star']))?'checked="checked"':'';?>
                        name="filter[filter_star][]" value="1" id="filter_star1"> 
                        <label for="filter_star1">
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px"  >
                        </label> 
                        <span style="float:right;">(<?= $viewData['filters']['stars']['1']; ?>)</span>
                    </div>
                    <div class="filteritem">
                        <input type="checkbox"
                        <?= (isset($viewData['filters_selected']['filter_star']) && in_array('2',$viewData['filters_selected']['filter_star']))?'checked="checked"':'';?>
                            name="filter[filter_star][]" value="2" id="filter_star2"> 
                        <label for="filter_star2">
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >
                        </label> 
                        <span style="float:right;">(<?= $viewData['filters']['stars']['2']; ?>)</span>
                    </div>
                    <div class="filteritem">
                        <input type="checkbox"
                        <?= (isset($viewData['filters_selected']['filter_star']) && in_array('3',$viewData['filters_selected']['filter_star']))?'checked="checked"':'';?>
                            name="filter[filter_star][]" value="3" id="filter_star3"> 
                        <label for="filter_star3">
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >	
                        </label> 
                        <span style="float:right;">(<?= $viewData['filters']['stars']['3']; ?>)</span>
                    </div>
                    <div class="filteritem">
                        <input type="checkbox"
                        <?= (isset($viewData['filters_selected']['filter_star']) && in_array('4',$viewData['filters_selected']['filter_star']))?'checked="checked"':'';?>
                            name="filter[filter_star][]" value="4" id="filter_star4"> 
                        <label for="filter_star4">
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px"  >
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >
                        </label> 
                        <span style="float:right;">(<?= $viewData['filters']['stars']['4']; ?>)</span>
                    </div>
                    <div class="filteritem">
                        <input type="checkbox"
                        <?= (isset($viewData['filters_selected']['filter_star']) && in_array('5',$viewData['filters_selected']['filter_star']))?'checked="checked"':'';?>
                            name="filter[filter_star][]" value="5" id="filter_star5"> 
                        <label for="filter_star5">
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px"  >
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >
                            <img src="<?= BASE_URL ?>assets/images/star.png" height="13px" >
                        </label> 
                        <span style="float:right;">(<?= $viewData['filters']['stars']['5']; ?>)</span>
                    </div>
                </div>
            </div>
            <!-- FILTRO PROMOÇÃO -->
            <div class="filterbox">
                <div class="filtertitle"> <?php $this->lang->get('SALE'); ?> </div>
                <div class="filtercontent">
                    <div class="filteritem">
                        <input type="checkbox" 
                        <?= (isset($viewData['filters_selected']['sale']) && $viewData['filters_selected']['sale'])=="1"?'checked="checked"':'';?>
                        name="filter[sale]" value="1" id="filter_sale"> 
                        <label for="filter_sale">Na Promoção</label> 
                        <span style="float:right;">(<?= $viewData['filters']['sale']; ?>)</span>
                    </div>
                </div>
            </div>
            <!-- FILTRO OPÇÕES -->
            <div class="filterbox">
                <div class="filtertitle"> <?php $this->lang->get('OPTIONS'); ?> </div>
                <div class="filtercontent">
                    <?php  foreach($viewData['filters']['options'] as $option):?>
                    <strong> <?= $option['name']?></strong><br>
                        <?php foreach($option['options'] as $item_option):?>
                            <div class="filteritem">
                                <input type="checkbox" 
                                <?= (isset($viewData['filters_selected']['options']) && in_array($item_option['value'],$viewData['filters_selected']['options']))?'checked="checked"':'';?>
                                name="filter[options][]" value="<?= $item_option['value'];?>" id="filter_options<?= $item_option['id'] ?>"> 
                                <label for="filter_options<?= $item_option['id'] ?>"><?= $item_option['value']; ?>  </label> 
                            <span style="float:right;">(<?= $item_option['count']; ?>)</span>
                        </div>
                        <?php endforeach;?>
                    <br>
                    <?php  endforeach;?>
                </div>
            </div>

        </form>
    </div> <!-- FILTERAREA -->

    <div class="widget">
        <h1><?php $this->lang->get('FEATUREDPRODUCTS'); ?></h1>
        <div class="widget_body">
            <?php $this->loadView('widget_item',array('list' => $viewData['widget_destaque1'])) ?>
        </div>
    </div>
</aside>