<div class="container main-content">
    <div class="row">

        <ul class="collection">
            <?php foreach ($sub_categorias->result() as $subc): ?>
            <li class="collection-item"><a href="<?php echo base_url('organigrama/'. $subc->slug .'.html'); ?>"><?php echo $subc->name; ?></a></li>
            <?php endforeach; ?>
        </ul>

    </div>
</div>