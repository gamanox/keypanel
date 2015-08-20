<div class="container main-content">
    <div class="row">
        <div class="card panel no-padding">
            <div class="card-header grey lighten-5">
                <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">edit</i>&nbsp;&nbsp;<?php echo lang('member_edit'); ?></p>
            </div>
            <div class="card-content">
                <div class="col s12 m12">
                    <div id="alertBox" class="card-panel red">
                        <span id="profile_msg" class="white-text"></span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <form action="#" method="post" id="frmEditMember">
                    <input type="hidden" name="id" value="<?php echo $member->id; ?>">
                    <input type="hidden" name="signature" value="<?php echo md5('KeyPanel#'. $member->id); ?>">
                    <h6><?php echo lang('info-general'); ?></h6>
                    <div class="input-field col s12 m6">
                        <input class="validate" name="member[first_name]" value="<?php echo $member->first_name; ?>" id="first_name" type="text">
                        <label class="col s12 m6 no-padding" for="first_name" data-error="<?php echo lang('first_name_required'); ?>"><?php echo lang('first_name'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="member[last_name]" value="<?php echo $member->last_name; ?>" id="last_name" type="text">
                        <label for="last_name"><?php echo lang('last_name'); ?></label>
                    </div>

                    <div class="input-field col s12 m12">
                        <input class="validate" name="member[email]" value="<?php echo $member->email; ?>" id="email" type="email">
                        <label class="col s12 m12 no-padding" for="email" data-error="<?php echo lang('email_required'); ?>"><?php echo lang('email'); ?></label>
                    </div>

                    <div class="clearfix">&nbsp;</div>
                    <h6><?php echo lang('info-contact'); ?></h6>
                    <div class="input-field col s12 m6">
                        <input name="contact[phone_personal]" value="<?php echo $member->contact->phone_personal; ?>" id="phone_personal" type="text">
                        <label for="phone_personal"><?php echo lang('phone-personal'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="contact[phone_business]" value="<?php echo $member->contact->phone_business; ?>" id="phone_business" type="text">
                        <label for="phone_business"><?php echo lang('phone-business'); ?></label>
                    </div>

                    <div class="clearfix">&nbsp;</div>
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

                    <div class="clearfix">&nbsp;</div>
                    <h6><?php echo lang('datos-acceso'); ?></h6>
                    <div class="input-field col s12 m6">
                        <input value="<?php echo $member->username; ?>" disabled id="username" type="text">
                        <label class="username" for="username"><?php echo lang('username'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="current_password" value="" id="current_password" type="password">
                        <label id="for_current_password" class="validate col s12 m12 no-padding" for="current_password" data-error="<?php echo lang('current-password-empty'); ?>"><?php echo lang('current-password'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="new_password" value="" id="new_password" type="password">
                        <label class="validate col s12 m12 no-padding" for="new_password" data-error="<?php echo lang('password-confirmation-not-match'); ?>"><?php echo lang('new-password'); ?></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input name="password_confirmation" value="" id="password_confirmation" type="password">
                        <label for="password_confirmation"><?php echo lang('password_confirmation'); ?></label>
                    </div>

                    <input type="hidden" name="address[id]" value="<?php echo $member->address->id; ?>">
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="card-action">
            <a href="javascript:;" onclick="javascript:$('#frmEditMember').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons left">done</i><?php echo lang('btn_update_member'); ?></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#frmEditMember").on("submit", function(e){
            e.preventDefault();
            e.stopPropagation();
            save();
        });

        $("#first_name").focusout(function(){
            if($(this).val()==""){
                $(this).removeClass("valid invalid active");
                $(this).addClass("invalid active");
                $(this).focus();

            }
        });

        $("#password_confirmation").focusout(function(){
            if($("#password_confirmation").val() != $("#new_password").val()){
                $("#new_password").removeClass("valid invalid active");
                $("#new_password").addClass("invalid active");
                $("#new_password").focus();
            }else{
                $("#new_password").removeClass("valid invalid active");
                $("#new_password").addClass("valid");
            }
        });

        $("#new_password").focusout(function(){
            if($("#password_confirmation").val() == $("#new_password").val()){
                $("#new_password").removeClass("valid invalid active");
                $("#new_password").addClass("valid");
            }
        });

        $("#current_password").focusout(function(){
            $("#current_password").removeClass("valid invalid active");
            $("#current_password").addClass("valid");
        });

        $("#alertBox").hide();
    });

    function save(){
        if($("#first_name").val()===""){
            $("#first_name").removeClass("valid invalid active");
            $("#first_name").addClass("invalid active");
            $("#first_name").focus();
        }else if($("#email").val()===""){
            $("#email").removeClass("valid invalid active");
            $("#email").addClass("invalid active");
            $("#email").focus();
        }else if( ($("#new_password").val()!="" || $("#password_confirmation").val()!="") && $("#password_confirmation").val() != $("#new_password").val()){
            $("#new_password").removeClass("valid invalid active");
            $("#new_password").addClass("invalid active");
            $("#new_password").focus();
        }else{
            var str = $('#frmEditMember').serialize();
            $("#first_name, #email, #new_password, #current_password").removeClass("invalid");
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('admin/member/save'); ?>',
                data: str,
                dataType: 'jsonp',
                beforeSend:function(){},
                complete:function(){},
                success:function(response) {
                    if( response.status ){
                        location.href = '<?php echo base_url('admin/member'); ?>';
                    }else{
                        $("#current_password").removeClass("valid invalid active");
                        $("#current_password").addClass("invalid active");
                        $("#current_password").focus();
                    }
                }
            });
        }
    }
</script>