<div class="container main-content">
    <div class="row">
        <div class="card card-middle small">
            <div class="card-content">
                <span class="card-title grey-text"><?php echo lang('add_member_card_title'); ?></span>

                <form action="post">
                    <div class="input-field col s6">
                        <input name="member[first_name]" value="" id="first_name" type="text" class="validate">
                        <label class="active" for="first_name">First Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input name="member[last_name]" value="" id="first_name" type="text" class="validate">
                        <label class="active" for="first_name">Last Name</label>
                    </div>
                </form>
            </div>
            <div class="card-action">
                <a href="<?php echo base_url('administration/add_member'); ?>" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons left">done</i><?php echo lang('btn_save_member'); ?></a>
            </div>            
        </div>
    </div>
</div>