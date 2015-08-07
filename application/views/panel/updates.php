<div id="updates" class="card small partial">
	<div class="card-content no-padding">
		<p class="card-title blue-grey-text text-darken-4 valign-wrapper"><i class="tiny material-icons valign">forum</i>&nbsp;&nbsp;<?php echo lang('card-actualizaciones-title'); ?><a href="<?php echo base_url('panel'); ?>" class="waves-effect waves-blue btn-flat close"><i class="tiny material-icons valign">close</i></a></p>

        <?php if( isset($updates) and $updates->num_rows() > 0 ) : ?>
        <ul class="collection nomargin">
            <?php foreach ($updates->result() as $update): ?>
            <li class="collection-item valign-wrapper">
                <span class="update light <?php echo ($update->action == 'UPDATED' ? 'orange' : 'green') ?> white-text"><?php echo lang($update->action); ?></span>&nbsp;
                <a href="javascript:;" class="light black-text"><?php echo $update->full_name; ?> - <?php echo lang($update->type); ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else : ?>
        Sin actualizaciones que mostrar
        <?php endif; ?>
	</div>
	<div class="card-action">
		<a href="#" class="col s12 m12 l12 btn-large blue waves-effect waves-light"><?php echo strtoupper(lang('btn_ver_mas')); ?></a>
	</div>
</div>
