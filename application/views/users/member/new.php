<div class="container main-content">
    <div class="row">
        <div class="card panel no-padding">
            <div class="card-header grey lighten-5">
                <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">history</i>&nbsp;&nbsp;<?php echo lang('add_member_card_title'); ?></p>
            </div>
            <div class="card-content">

                <?php if( isset($errors) and count($errors) > 0 ) : ?>
                <ul class="collection">
                    <?php foreach ($errors as $error): ?>
                    <li class="collection-item red lighten-1 valign-wrapper"><i class="material-icons valign">error_outline</i>&nbsp;<?php echo $error; ?></li>
                    <?php endforeach ?>
                </ul>
                <?php endif; ?>

                <form action="<?php echo base_url('administration/add_member'); ?>" method="post" id="frmAddMember">
                    <h6><?php echo lang('info-general'); ?></h6>
                    <div class="input-field col s12 m6">
                        <input name="member[first_name]" value="<?php echo set_value('member[first_name]'); ?>" id="first_name" type="text">
                        <label class="active" for="first_name"><?php echo lang('first_name'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="member[last_name]" value="<?php echo set_value('member[last_name]'); ?>" id="last_name" type="text">
                        <label class="active" for="last_name"><?php echo lang('last_name'); ?></label>
                    </div>
                    <div class="input-field col s12 m8">
                        <input name="member[email]" value="<?php echo set_value('member[email]'); ?>" id="email" type="email">
                        <label class="active" for="email"><?php echo lang('email'); ?></label>
                    </div>

                    <div class="clearfix"></div>
                    <h6><?php echo lang('info-contact'); ?></h6>
                    <div class="input-field col s12 m6">
                        <input name="contact[phone_personal]" value="" id="phone_personal" type="text">
                        <label for="phone_personal"><?php echo lang('phone-personal'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="contact[phone_businesss]" value="" id="phone_business" type="text">
                        <label for="phone_business"><?php echo lang('phone-business'); ?></label>
                    </div>


                    <div class="clearfix"></div>
                    <h6><?php echo lang('datos-acceso'); ?></h6>
                    <div class="input-field col s12 m4">
                        <input name="member[username]" value="<?php echo set_value('member[username]'); ?>" id="username" type="text">
                        <label class="username" for="username"><?php echo lang('username'); ?></label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input name="member[password]" value="" id="password" type="password">
                        <label class="password" for="password"><?php echo lang('password'); ?></label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input name="password_confirmation" value="" id="password_confirmation" type="password">
                        <label class="active" for="password_confirmation"><?php echo lang('password_confirmation'); ?></label>
                    </div>
                </form>

                <div class="clearfix"></div>

                <a href="javascript:;" onclick="javascript:$('#frmAddMember').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons left">done</i><?php echo lang('btn_save_member'); ?></a>
            </div>
        </div>
    </div>
</div>