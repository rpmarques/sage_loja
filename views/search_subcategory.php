<?php  foreach($subs as $sub): ?>
    <option value="<?=$sub['id']; ?>" <?= ( isset($category) && $category==$sub['id'])?'selected="selected"':'';?>>
        <?php
        //PRA DIFERENCIAR O QUE É SUB
        // DENTRO DO FOR EU ALTERO O HTML
        for($q=0;$q<$nivel;$q++) echo '-- ';
            echo $sub['name'];             
        ?>    
    </option>    
    <?php
    if (count($sub['subs']) > 0 ){
        $this->loadView('search_subcategory',array(
            'subs' => $sub['subs'],
            'nivel' => $nivel + 1,
            'category' => $category
        ));
    } 
    ?>
<?php  endforeach; ?>