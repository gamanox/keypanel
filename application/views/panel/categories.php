<div class="container main-content">
    <div class="row">
        <h4><?php echo $categoria->name; ?></h4>
        <?php //echo var_dump($sub_categorias); ?>
        <?php
            if( isset($sub_categorias) and
            (
                (is_object($sub_categorias) and $sub_categorias->num_rows() > 0) or
                (is_array($sub_categorias) and count($sub_categorias) > 0)
            )) : ?>
        <?php foreach ($sub_categorias as $categoria): ?>
        <?php if( count($categoria->children) > 0 ) : // Tiene subcategorias, hay que pintarlas con el recuadro grande ?>
            <a href="<?php echo base_url('organigrama/'. $categoria->slug .'.html'); ?>"><?php echo $categoria->name; ?></a><br>
        <?php else : // ya no tiene subcategorias, redirigimos a navegacion de organigramas ?>

        <?php // Verificamos que tenga niveles y perfiles dentro para activar el link ?>
        <?php if( $categoria->total_organizations > 0 ) : // Tiene organigramas debajo ?>
        <?php if( $categoria->total_profiles > 0 ) : ?>
        <div class="col s12 m2">
            <a href="">
                <div class="card-panel blue tree" style="position: relative;">
                    <h5 class="the-title"><?php echo $categoria->name; ?></h5>
                    <div class="info right">
                        <?php if( $categoria->total_organizations > 1 ) : ?>
                        <span class="niveles"><?php echo $categoria->total_organizations; ?></span>&nbsp;<span><?php echo lang('lbl_niveles'); ?></span><br>
                        <?php endif; ?>
                        <span class="perfiles"><?php echo $categoria->total_profiles; ?></span>&nbsp;<span><?php echo lang('lbl_profiles'); ?></span>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>
        <?php else : // Sin organigramas ?>
        <div class="col s12 m2">
            <div class="card-panel grey lighten-2 tree" style="position: relative;">
                <h5 class="the-title"><?php echo $categoria->name; ?></h5>
            </div>
        </div>
        <?php endif; ?>

        <?php endif; ?>

        <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>