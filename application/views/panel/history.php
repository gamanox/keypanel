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