<?php  foreach($subs as $sub): ?>
    <li>
        <a href="<?= BASE_URL.'categories/enter/'.$sub['id']?>">
            <?php
            //PRA DIFERENCIAR O QUE É SUB
            // DENTRO DO FOR EU ALTERO O HTML
             for($q=0;$q<$nivel;$q++) echo '-- ';
             echo $sub['name'];             
             ?>
        </a>
    </li>
    <?php
    if (count($sub['subs']) > 0 ){
        $this->loadView('menu_subcategory',array(
            'subs' => $sub['subs'],
            'nivel' => $nivel + 1
        ));
    } 
    ?>
<?php  endforeach; ?>