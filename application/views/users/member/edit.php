<div class="container main-content">
    <div class="row">
        <div class="card panel no-padding">
            <div class="card-header grey lighten-5">
                <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">edit</i>&nbsp;&nbsp;<?php echo lang('edit_member_card_title'); ?></p>
            </div>
            <div class="card-content">
                <?php
                    // echo '<pre>'. print_r($member, true) .'</pre>';
                ?>
                <form action="<?php echo base_url('admin/member/update'); ?>" method="post" id="frmUpdateMember">
                    <input type="hidden" name="id" value="<?php echo $member->id; ?>">
                    <input type="hidden" name="signature" value="<?php echo md5('KeyPanel#'. $member->id); ?>">
                    <h6><?php echo lang('info-general'); ?></h6>
                    <div class="input-field col s12 m6">
                        <input name="member[first_name]" value="<?php echo $member->first_name; ?>" id="first_name" type="text" class="validate">
                        <label class="active" for="first_name"><?php echo lang('first_name'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="member[last_name]" value="<?php echo $member->last_name; ?>" id="last_name" type="text" class="validate">
                        <label class="active" for="last_name"><?php echo lang('last_name'); ?></label>
                    </div>

                    <div class="input-field col s12 m8">
                        <input name="member[email]" value="<?php echo $member->email; ?>" id="email" type="email" class="validate">
                        <label class="active" for="email"><?php echo lang('email'); ?></label>
                    </div>

                    <div class="clearfix"></div>
                    <h6><?php echo lang('info-contact'); ?></h6>
                    <div class="input-field col s12 m6">
                        <input name="contact[phone_personal]" value="<?php echo $member->contact->phone_personal; ?>" id="phone_personal" type="text">
                        <label for="phone_personal"><?php echo lang('phone-personal'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="contact[phone_business]" value="<?php echo $member->contact->phone_business; ?>" id="phone_business" type="text">
                        <label for="phone_business"><?php echo lang('phone-business'); ?></label>
                    </div>

                    <div class="clearfix"></div>
                    <h6><?php echo lang('addr_info-address'); ?></h6>
                    <div class="input-field col s12 m4">
                        <input name="address[country]" id="country" type="text" value="<?php echo $member->address->country; ?>">
                        <label for="country"><?php echo lang('addr_country'); ?></label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input name="address[state]" id="state" type="text" value="<?php echo $member->address->state; ?>">
                        <label for="state"><?php echo lang('addr_state'); ?></label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input name="address[city]" id="city" type="text" value="<?php echo $member->address->city; ?>">
                        <label for="city"><?php echo lang('addr_city'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="address[neighborhood]" id="neighborhood" type="text" value="<?php echo $member->address->neighborhood; ?>">
                        <label for="neighborhood"><?php echo lang('addr_neighborhood'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="address[street]" id="street" type="text" value="<?php echo $member->address->street; ?>">
                        <label for="street"><?php echo lang('addr_street'); ?></label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input name="address[zip_code]" id="zip_code" type="text" value="<?php echo $member->address->zip_code; ?>">
                        <label for="zip_code"><?php echo lang('addr_zip_code'); ?></label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input name="address[num_ext]" id="num_ext" type="text" value="<?php echo $member->address->num_ext; ?>">
                        <label for="num_ext"><?php echo lang('addr_num_ext'); ?></label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input name="address[num_int]" id="num_int" type="text" value="<?php echo $member->address->num_int; ?>">
                        <label for="num_int"><?php echo lang('addr_num_int'); ?></label>
                    </div>

                    <div class="clearfix"></div>
                    <h6><?php echo lang('datos-acceso'); ?></h6>
                    <div class="input-field col s12 m4">
                        <input name="member[username]" value="<?php echo $member->username; ?>" disabled id="username" type="text">
                        <label class="username" for="username"><?php echo lang('username'); ?></label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input name="new_password" value="" id="password" type="password">
                        <label class="password" for="password"><?php echo lang('new-password'); ?></label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input name="password_confirmation" value="" id="password_confirmation" type="password">
                        <label class="active" for="password_confirmation"><?php echo lang('password_confirmation'); ?></label>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="card-action">
            <a href="javascript:;" onclick="javascript:$('#frmUpdateMember').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons left">done</i><?php echo lang('btn_update_member'); ?></a>
        </div>
    </div>
</div>