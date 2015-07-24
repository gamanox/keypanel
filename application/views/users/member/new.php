<div class="container main-content">
    <div class="row">
        <div class="card card-middle small">
            <div class="card-content">
                <span class="card-title grey-text"><?php echo lang('add_member_card_title'); ?></span>

                <form action="<?php echo base_url('administration/add_member'); ?>" method="post" id="frmAddMember">
                    <div class="input-field col s6">
                        <input name="member[first_name]" value="" id="first_name" type="text" class="validate">
                        <label class="active" for="first_name"><?php echo lang('first_name'); ?></label>
                    </div>
                    <div class="input-field col s6">
                        <input name="member[last_name]" value="" id="last_name" type="text" class="validate">
                        <label class="active" for="last_name"><?php echo lang('last_name'); ?></label>
                    </div>

                    <div class="input-field col s8">
                        <input name="member[email]" value="" id="email" type="email" class="validate">
                        <label class="active" for="email"><?php echo lang('email'); ?></label>
                    </div>                    
                </form>
            </div>
            <div class="card-action">
                <a href="javascript:;" onclick="javascript:$('#frmAddMember').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons left">done</i><?php echo lang('btn_save_member'); ?></a>
            </div>            
        </div>
    </div>
</div>