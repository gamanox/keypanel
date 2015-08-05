<div class="card-panel hoverable no-padding">
    <div class="card-header">
        <div class="card-header grey lighten-5">
            <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">history</i>&nbsp;&nbsp;<?php echo lang('card-historial-title'); ?></p>
        </div>
    </div>
    <div class="card-content no-padding">
        <?php
            $history = $user_info->history->result();
            if( count($history) > 0 ) :
        ?>
        <ul class="collection nomargin">
            <?php foreach ($history as $h_visited) : ?>
            <li class="collection-item valign-wrapper"><i class="tiny material-icons valign">link</i>&nbsp;<?php echo $h_visited->profile->full_name; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php else : ?>
            no hay historial
        <?php endif; ?>
    </div>
</div>