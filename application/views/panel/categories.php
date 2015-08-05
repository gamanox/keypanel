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
        <li><a class="btn-floating green"><i class="material-icons">control_point_duplicate</i></i></a></li>
    </ul>
</div>
<?php endif; ?>