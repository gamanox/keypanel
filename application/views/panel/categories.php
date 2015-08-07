<div class="container main-content">
    <div class="row">

        <ul class="collection">
            <?php foreach ($sub_categorias->result() as $subc): ?>
            <li class="collection-item"><a href="<?php echo base_url('organigrama/'. $subc->slug .'.html'); ?>"><?php echo $subc->name; ?></a></li>
            <?php endforeach; ?>
        </ul>

    </div>
</div>

<?php if( $this->session->type == SUPERADMIN ) : ?>
<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large red"><i class="large material-icons">add</i></a>
    <ul>
        <li><a class="btn-floating green tooltipped" data-position="left" data-delay="50" data-tooltip="<?php echo lang('btn_add_category'); ?>"><i class="material-icons">control_point_duplicate</i></a></li>
        <li><a class="btn-floating blue tooltipped" data-position="left" data-delay="50" data-tooltip="<?php echo lang('btn_add_organization'); ?>"><i class="material-icons">device_hub</i></a></li>
    </ul>
</div>
<?php endif; ?>