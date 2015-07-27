<?php $this->load->view('includes/common-functions'); ?>
<div class="container main-content">
    <div class="row">
        <div class="s12 m12 l12">
            <div class="card-panel">
                <h5 class="grey-text"><?php echo lang('members_card_title'); ?></h5>
                <?php
                    // echo '<pre>'. print_r($members->result(), true) .'</pre>';
                ?>
                <?php if( isset($members) and count($members) > 0 ) : ?>
                <table class="responsive-table striped">
                    <thead>
                        <tr>
                            <th data-field="name"><?php echo lang('column-info'); ?></th>
                            <th data-field="actions" style="width:10%"><?php echo lang('column_actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members->result() as $key => $member): ?>
                        <tr>
                            <td>
                                <span><?php echo $member->full_name .' - <a class="indigo-text" href="mailto:'. $member->email .'">'. $member->email .'</a>'; ?></span><br>
                                <span class="grey-text lighten-1 tiny-text"><?php echo sprintf(lang('label-member-since'), lang(MEMBER)); ?>: <?php echo date_to_humans($member->create_at); ?></span>
                            </td>
                            <td>
                                <a class="blue-text darken-1" href="<?php echo base_url('administration/edit_member/'. $member->id); ?>"><i class="tiny material-icons">edit</i></a>
                                <a class="blue-text darken-1" href="<?php echo base_url('administration/delete_member/'. $member->id); ?>"><i class="tiny material-icons">delete</i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else : ?>

                <?php endif; ?>
            </div>
            <div class="card-action">
                <a href="<?php echo base_url('administration/add_member'); ?>" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons left">add</i><?php echo lang('btn_add_member'); ?></a>
            </div>
        </div>
    </div>
</div>