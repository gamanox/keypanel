<div class="container main-content">
    <div class="row">
        <div class="card panel no-padding">
            <div class="card-header grey lighten-5">
                <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">history</i>&nbsp;&nbsp;<?php echo lang('add_organization_card_title'); ?></p>
            </div>
            <div class="card-content">

                <?php if( isset($errors) and count($errors) > 0 ) : ?>
                <ul class="collection">
                    <?php foreach ($errors as $error): ?>
                    <li class="collection-item red lighten-1 valign-wrapper"><i class="material-icons valign">error_outline</i>&nbsp;<?php echo $error; ?></li>
                    <?php endforeach ?>
                </ul>
                <?php endif; ?>

                <form action="<?php echo base_url('administration/add_organization'); ?>" method="post" id="frmAddOrganization">
                    <h6><?php echo lang('info-general'); ?></h6>
                    <div class="input-field col s12 m6">
                        <input name="organization[first_name]" value="<?php echo set_value('organization[first_name]'); ?>" id="first_name" type="text">
                        <label class="active" for="first_name"><?php echo lang('first_name'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="organization[email]" value="<?php echo set_value('organization[email]'); ?>" id="email" type="email">
                        <label class="active" for="email"><?php echo lang('email'); ?></label>
                    </div>
                    <div class="input-field col s12 m12">
                        <textarea name="contact[description]" value="<?php echo set_value('cantact[description]'); ?>" id="description" class="materialize-textarea"></textarea>
                        <label class="active" for="description"><?php echo lang('description'); ?></label>
                    </div>

                    <div class="clearfix"></div>
                    <h6><?php echo lang('info-contact'); ?></h6>
                    <div class="input-field col s12 m6">
                        <input name="contact[phone_businesss]" value="" id="phone_business" type="text">
                        <label for="phone_business"><?php echo lang('phone-business'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="contact[facebook]" value="" id="facebook" type="text">
                        <label for="facebook"><?php echo lang('facebook'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="contact[twitter]" value="" id="twitter" type="text">
                        <label for="twitter"><?php echo lang('twitter'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="contact[linkedin]" value="" id="linkedin" type="text">
                        <label for="linkedin"><?php echo lang('linkedin'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="contact[gplus]" value="" id="gplus" type="text">
                        <label for="gplus"><?php echo lang('gplus'); ?></label>
                    </div>


                    <div class="clearfix"></div>
                </form>

                <div class="clearfix"></div>

                <a href="javascript:;" onclick="javascript:$('#frmAddOrganization').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons left">done</i><?php echo lang('btn_save_organization'); ?></a>
            </div>
        </div>
    </div>
</div>