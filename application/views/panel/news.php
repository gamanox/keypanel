<div id="news" class="card small partial">
	<div class="card-content no-padding">
		<p class="card-title blue-grey-text text-darken-4 valign-wrapper"><i class="tiny material-icons valign">forum</i>&nbsp;&nbsp;<?php echo lang('card-noticias-title'); ?><a href="<?php echo base_url('panel'); ?>" class="waves-effect waves-blue btn-flat close"><i class="tiny material-icons valign">close</i></a></p>
        <?php if( isset($news) and $news->num_rows() > 0 ) : ?>
        <ul class="collection">
            <?php
                $limit = 6;
                $index = 0;

                foreach ($news->result() as $new): ?>
            <li class="collection-item valign-wrapper">
                <p class="light">
                    <small><strong><?php echo $new->create_at; ?></strong></small><br>
                    <?php echo substr($new->content, 0, 70) .'...<br><a href="javascript:;">'. lang('read_more') .'</a>'; ?>
                </p>
            </li>
            <?php
                $index++;
                if( $index >= $limit ) break;
                endforeach;
            ?>
        </ul>
        <?php else : ?>
        Sin noticias que mostrar
        <?php endif; ?>
	</div>
	<div class="card-action">
		<a href="#" class="col s12 m12 l12 btn-large blue waves-effect waves-light"><?php echo strtoupper(lang('btn_ver_mas')); ?></a>
	</div>
</div>
