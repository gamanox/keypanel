<div id="history" class="card small partial">
    <div class="card-content">
        <p class="card-title blue-grey-text text-darken-4"><i class="tiny material-icons">history</i>&nbsp;&nbsp;<?php echo lang('card-historial-title'); ?><a href="<?php echo base_url('panel'); ?>" class="waves-effect waves-blue btn-flat close"><i class="tiny material-icons">close</i></a></p>
        <?php
            $history = $user_info->history->result();
            if( count($history) > 0 ) :
        ?>
        <ul class="collection">
            <?php foreach ($history as $h_visited) : ?>
            <li class="collection-item"><i class="tiny material-icons">link</i>&nbsp;<?php echo $h_visited->profile->full_name; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php else : ?>
            no hay historial
        <?php endif; ?> 
    </div>
    <div class="card-action">
        <a href="#" class="col s12 m12 l12 btn-large blue waves-effect waves-light"><?php echo strtoupper(lang('btn_ver_mas')); ?></a>
    </div>
</div>
