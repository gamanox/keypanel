<?php /* CARD NOTICIAS */ ?>
<div class="col s12 m7 l7">
    <div class="card small partial hoverable">
        <div class="card-header grey lighten-5">
            <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">forum</i>&nbsp;<?php echo lang('card-noticias-title'); ?></p>
        </div>
        <div class="card-content nopadding">
            <?php if( isset($news) and $news->num_rows() > 0 ) : ?>
            <ul class="collection">
                <?php
                    $limit = 2;
                    $index = 0;

                    foreach ($news->result() as $new): ?>
                <li class="collection-item valign-wrapper">
                    <?php //echo var_dump($new); ?>
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
            <a href="<?php echo base_url('panel/news'); ?>" class="col s12 m12 l12 btn-large blue waves-effect waves-light" type="button"><?php echo strtoupper(lang('btn_mas_noticias')); ?></a>
        </div>
    </div>
</div>

<?php /* CARD HISTORIAL */ ?>
<div class="col s12 m5 l5">
    <div class="card small partial hoverable">
        <div class="card-header grey lighten-5">
            <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">history</i>&nbsp;&nbsp;<?php echo lang('card-historial-title'); ?></p>
        </div>
        <div class="card-content no-padding">
            <?php
                $history = ( isset($user_info->history) ? $user_info->history->result() : array());
                $index   = 1;

                if( count($history) > 0 ) :
            ?>
            <ul class="collection nomargin">
                <?php foreach ($history as $h_visited) : ?>
                <li class="collection-item valign-wrapper"><i class="tiny material-icons valign">link</i>&nbsp;<?php echo $h_visited->profile->full_name; ?></li>
                <?php $index++; if( $index == 4) break; ?>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
        <div class="card-action no-padding">
            <a href="<?php echo base_url('panel/history'); ?>" class="col s12 m12 l12 btn-large blue waves-effect waves-light"><?php echo strtoupper(lang('btn_ver_mas')); ?></a>
        </div>
    </div>
</div>

<?php
    // echo var_dump($updates);
    // echo '<pre>'. print_r($updates->result(), true) .'</pre>';
?>
<?php /* CARD ACTUALIZACIONES */ ?>
<div class="col s12 m7 l7">
    <div class="card small partial hoverable">
        <div class="card-header grey lighten-5">
            <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">notifications</i>&nbsp;<?php echo lang('card-actualizaciones-title'); ?></p>
        </div>
        <div class="card-content no-padding">
            <ul class="collection nomargin">
                <?php foreach ($updates->result() as $update): ?>
                <li class="collection-item valign-wrapper">
                    <span class="update light <?php echo ($update->action == 'UPDATED' ? 'orange' : 'green') ?> white-text"><?php echo lang($update->action); ?></span>&nbsp;
                    <a href="javascript:;" class="light black-text"><?php echo $update->full_name; ?> - <?php echo lang($update->type); ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="card-action no-padding">
            <a href="<?php echo base_url('panel/updates'); ?>" class="col s12 m12 l12 btn-large blue waves-effect waves-light"><?php echo strtoupper(lang('btn_ver_mas')); ?></a>
        </div>
    </div>
</div>

<?php /* CARD TENDENCIAS */ ?>
<div class="col s12 m5 l5">
    <div class="card small partial hoverable">
        <div class="card-header">
            <p class="card-title blue-grey-text text-darken-4 valign-wrapper"><i class="tiny material-icons valign">local_offer</i>&nbsp;<?php echo lang('card-tendencias-title'); ?></p>
        </div>
        <div class="card-content">
            <?php foreach ($trends->result() as $term): ?>
            <span class="blue white-text trend"><?php echo $term->name; ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</div>