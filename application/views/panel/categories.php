<div class="container main-content">
    <div class="row">
        <h4><?php echo $categoria->name; ?></h4>
        <?php echo var_dump($organizations->result()); ?>
        <?php //echo var_dump($sub_categorias); ?>
        <ul class="collection">
            <?php
                if( isset($sub_categorias) and
                (
                    (is_object($sub_categorias) and $sub_categorias->num_rows() > 0) or
                    (is_array($sub_categorias) and count($sub_categorias) > 0)
                )) : ?>
            <?php foreach ($sub_categorias as $categoria): ?>
            <li class="collection-item">
                <a href="<?php echo base_url('organigrama/'. $categoria->slug .'.html'); ?>"><?php echo $categoria->name; ?></a>
                Categorias: <?php echo count($categoria->children); ?>
                Niveles: <?php echo $categoria->total_organizations; ?>
                Perfiles: <?php echo $categoria->total_profiles; ?>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>

    </div>
</div>