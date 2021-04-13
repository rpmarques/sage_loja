<div class="row">
<?php 
    $cont = 0;
    foreach($list as $product_item):?>
    <div class="col-sm-4">     
        <?php 
            //ESSE VIEW TEM O LAYOUT DA LISTAGEM DE PRODUTOS
            // SEMPRE PRA MOSTRAR OS PRODUTOS EU CHAMO ESSE CARA
            $this->loadView('product_item',$product_item) 
        ?>
    </div>
    <?php 
        if ($cont >= 2){ //AQUI PRA FECHAR A LINHA E ABRIR OUTRA
            $cont=0;
            echo '</div><div class="row">';
        }else{
            $cont++;
        }        
    ?>
<?php endforeach; ?>
</div>
<!-- AQUI É A PAGINAÇÃO -->
<div class="paginationArea">
    <?php for($q=1;$q<=$nroDePaginas;$q++): ?>
        <div class="paginationItem 
            <?php echo ($paginaAtual==$q)?'pag_active':''; ?>">
            <a href="<?php echo BASE_URL; ?>?<?php
		$pag_array = $_GET;
		$pag_array['p'] = $q;
		echo http_build_query($pag_array);
	?>"><?php echo $q; ?></a></div>
    <?php endfor ?>    
</div>

