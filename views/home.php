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
        <div class="paginationItem <?= ($paginaAtual==$q)?'pag_active':''?>"> 
            <a href="<?= BASE_URL ;?>?p=<?= $q; ?>" > <?= $q ?></a> 
        </div>
    <?php endfor ?>    
</div>

