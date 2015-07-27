<div class="container main-content">
    <div class="row">
        <div class="card-panel">
            <div class="card-content">
                <?php
                    // echo '<pre>'. print_r($member, true) .'</pre>';
                ?>

                <form action="<?php echo base_url('administration/update_member'); ?>" method="post" id="frmUpdateMember">
                    <input type="hidden" name="id" value="<?php echo $member->id; ?>">
                    <input type="hidden" name="signature" value="<?php echo md5('KeyPanel#'. $member->id); ?>">
                    <div class="input-field col s6">
                        <input name="member[first_name]" value="<?php echo $member->first_name; ?>" id="first_name" type="text" class="validate">
                        <label class="active" for="first_name"><?php echo lang('first_name'); ?></label>
                    </div>
                    <div class="input-field col s6">
                        <input name="member[last_name]" value="<?php echo $member->last_name; ?>" id="last_name" type="text" class="validate">
                        <label class="active" for="last_name"><?php echo lang('last_name'); ?></label>
                    </div>

                    <div class="input-field col s8">
                        <input name="member[email]" value="<?php echo $member->email; ?>" id="email" type="email" class="validate">
                        <label class="active" for="email"><?php echo lang('email'); ?></label>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-action">
            <a href="javascript:;" onclick="javascript:$('#frmUpdateMember').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons left">done</i><?php echo lang('btn_update_member'); ?></a>
        </div>
    </div>
</div>