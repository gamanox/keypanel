<?php /* CARD NOTICIAS */ ?>
<div class="col s7 m7 l7">
    <div class="card small hoverable">
        <div class="card-content">
            <p class="card-title blue-grey-text text-darken-4"><i class="tiny material-icons">forum</i>&nbsp;<?php echo lang('card-noticias-title'); ?></p>
        </div>
        <div class="card-action">
            <a href="<?php echo base_url('panel/news'); ?>" class="col s12 m12 l12 btn-large blue waves-effect waves-light" type="button"><?php echo strtoupper(lang('btn_mas_noticias')); ?></a>
        </div>
    </div>
</div>

<?php /* CARD HISTORIAL */ ?>
<div class="col s5 m5 l5">
    <div class="card small hoverable">
        <div class="card-content">
            <p class="card-title blue-grey-text text-darken-4"><i class="tiny material-icons">history</i>&nbsp;&nbsp;<?php echo lang('card-historial-title'); ?></p>
            <?php
                $history = $user_info->history->result();
                $index   = 1;

                if( count($history) > 0 ) :
            ?>
            <ul class="collection">
                <?php foreach ($history as $h_visited) : ?>
                <li class="collection-item"><i class="tiny material-icons">link</i>&nbsp;<?php echo $h_visited->profile->full_name; ?></li>
                <?php $index++; if( $index == 4) break; ?>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
        <div class="card-action">
            <a href="<?php echo base_url('panel/history'); ?>" class="col s12 m12 l12 btn-large blue waves-effect waves-light"><?php echo strtoupper(lang('btn_ver_mas')); ?></a>
        </div>
    </div>
</div>

<?php /* CARD ACTUALIZACIONES */ ?>
<div class="col s7 m7 l7">
    <div class="card small hoverable">
        <div class="card-content">
            <p class="card-title blue-grey-text text-darken-4"><i class="tiny material-icons">forum</i>&nbsp;<?php echo lang('card-actualizaciones-title'); ?></p>
        </div>
        <div class="card-action">
            <a href="<?php echo base_url('panel/updates'); ?>" class="col s12 m12 l12 btn-large blue waves-effect waves-light"><?php echo strtoupper(lang('btn_ver_mas')); ?></a>
        </div>
    </div>
</div>

<?php /* CARD TENDENCIAS */ ?>
<div class="col s5 m5 l5">
    <div class="card small hoverable">
        <div class="card-content">
            <p class="card-title blue-grey-text text-darken-4"><i class="tiny material-icons">local_offer</i>&nbsp;<?php echo lang('card-tendencias-title'); ?></p>
        </div>
    </div>
</div>