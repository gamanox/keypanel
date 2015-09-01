<div id="account" class="card small partial">
    <div class="card-content no-padding">
        <p class="card-title blue-grey-text text-darken-4"><i class="tiny material-icons">settings</i>&nbsp;&nbsp;<?php echo lang('card-configuracion-title'); ?><a href="<?php echo base_url('panel'); ?>" class="waves-effect waves-blue btn-flat close"><i class="tiny material-icons">close</i></a></p>
        <div class="p-t-10 p-l-20 p-r-20">
            <?php if (isset($user_info->avatar) and $user_info->avatar != '') :?>

                <div class="col s12 m4 dropzone dz-clickable center-align columns" id="my-dropzone" style="min-height: 120px;">
                    <div class="dz-message" style="display: none;">
                        <span><?php echo lang('upload_img'); ?></span>
                    </div>
                    <div class="dz-preview dz-processing dz-image-preview dz-success">
                        <div class="dz-details">
                            <img src="<?php echo base_url('assets/images/profiles/'.$user_info->avatar); ?>" />
                        </div>
                        <button type="button" class="btn btn-sm btn-block btn-danger" onclick="javascript:change_image('<?php echo $user_info->avatar;?>');"><?php echo lang('editar_img'); ?></button>
                    </div>
                </div>
            <?php else: ?>
                <div class="col s12 m4 dropzone dz-clickable center-align columns" id="my-dropzone" style="min-height: 120px;">
                    <div class="dz-message">
                        <span><?php echo lang('upload_img'); ?></span>
                    </div>
                </div>

            <?php endif; ?>

            <div class="clearfix">&nbsp;</div>
            <form action="#" method="post" id="frmEditAccount">
                <input type="hidden" name="signature" value="<?php echo md5('KeyPanel#'. $user_info->id); ?>">
                <h6><?php echo lang('info-general'); ?></h6>

                <div class="input-field col s12 m6">
                    <input class="validate" name="member[first_name]" value="<?php echo $user_info->first_name; ?>" id="first_name" type="text">
                    <label class="col s12 m6 no-padding" for="first_name" data-error="<?php echo lang('first_name_required'); ?>"><?php echo lang('first_name'); ?></label>
                </div>
                <div class="input-field col s12 m6">
                    <input name="member[last_name]" value="<?php echo $user_info->last_name; ?>" id="last_name" type="text">
                    <label for="last_name"><?php echo lang('last_name'); ?></label>
                </div>

                <div class="input-field col s12 m12">
                    <textarea name="contact[bio]" id="bio" class="materialize-textarea validate"><?php echo $user_info->contact->bio; ?></textarea>
                    <label for="bio"><?php echo lang('contact_bio'); ?></label>
                </div>

                <div class="clearfix">&nbsp;</div>
                <h6><?php echo lang('info-contact'); ?></h6>
                <div class="input-field col s12 m6">
                    <input name="contact[facebook]" value="<?php echo $user_info->contact->facebook; ?>" id="facebook" type="text">
                    <label for="facebook"><?php echo lang('contact_facebook'); ?></label>
                </div>

                <div class="input-field col s12 m6">
                    <input class="validate" name="member[email]" value="<?php echo $user_info->email; ?>" id="email" type="email">
                    <label class="col s12 m12 no-padding" for="email" data-error="<?php echo lang('email_required'); ?>"><?php echo lang('email'); ?></label>
                </div>

                <div class="input-field col s12 m6">
                    <input name="contact[phone_personal]" value="<?php echo $user_info->contact->phone_personal; ?>" id="phone_personal" type="text">
                    <label for="phone_personal"><?php echo lang('phone-personal'); ?></label>
                </div>

                <div class="input-field col s12 m6">
                    <input name="contact[phone_business]" value="<?php echo $user_info->contact->phone_business; ?>" id="phone_business" type="text">
                    <label for="phone_business"><?php echo lang('phone-business'); ?></label>
                </div>

                <div class="clearfix">&nbsp;</div>
                <h6><?php echo lang('addr_info-address'); ?></h6>
                <div class="input-field col s12 m4">
                    <input name="address[country]" id="country" type="text" value="<?php echo $user_info->address->country; ?>">
                    <label for="country"><?php echo lang('addr_country'); ?></label>
                </div>
                <div class="input-field col s12 m4">
                    <input name="address[state]" id="state" type="text" value="<?php echo $user_info->address->state; ?>">
                    <label for="state"><?php echo lang('addr_state'); ?></label>
                </div>
                <div class="input-field col s12 m4">
                    <input name="address[city]" id="city" type="text" value="<?php echo $user_info->address->city; ?>">
                    <label for="city"><?php echo lang('addr_city'); ?></label>
                </div>
                <div class="input-field col s12 m6">
                    <input name="address[neighborhood]" id="neighborhood" type="text" value="<?php echo $user_info->address->neighborhood; ?>">
                    <label for="neighborhood"><?php echo lang('addr_neighborhood'); ?></label>
                </div>
                <div class="input-field col s12 m6">
                    <input name="address[street]" id="street" type="text" value="<?php echo $user_info->address->street; ?>">
                    <label for="street"><?php echo lang('addr_street'); ?></label>
                </div>
                <div class="input-field col s12 m4">
                    <input name="address[zip_code]" id="zip_code" type="text" value="<?php echo $user_info->address->zip_code; ?>">
                    <label for="zip_code"><?php echo lang('addr_zip_code'); ?></label>
                </div>
                <div class="input-field col s12 m4">
                    <input name="address[num_ext]" id="num_ext" type="text" value="<?php echo $user_info->address->num_ext; ?>">
                    <label for="num_ext"><?php echo lang('addr_num_ext'); ?></label>
                </div>
                <div class="input-field col s12 m4">
                    <input name="address[num_int]" id="num_int" type="text" value="<?php echo $user_info->address->num_int; ?>">
                    <label for="num_int"><?php echo lang('addr_num_int'); ?></label>
                </div>

                <div class="clearfix">&nbsp;</div>
                <h6><?php echo lang('datos-acceso'); ?></h6>
                <div class="input-field col s12 m6">
                    <input value="<?php echo $user_info->username; ?>" disabled id="username" type="text">
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

            </form>
            <div class="clearfix">&nbsp;</div>
        </div>
    </div>
    <div class="card-action">
        <a href="javascript:;" onclick="javascript:$('#frmEditAccount').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons left">done</i><?php echo lang('btn_update_member'); ?></a>
    </div>

</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/dropZone/lib/dropzone.js');?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#frmEditAccount").on("submit", function(e) {
            e.preventDefault();
            e.stopPropagation();
            save();
        });

        $("#first_name").focusout(function() {
            if ($(this).val() == "") {
                $(this).removeClass("valid invalid active");
                $(this).addClass("invalid active");
                $(this).focus();

            }
        });

        $("#password_confirmation").focusout(function() {
            if ($("#password_confirmation").val() != $("#new_password").val()) {
                $("#new_password").removeClass("valid invalid active");
                $("#new_password").addClass("invalid active");
                $("#new_password").focus();
            } else {
                $("#new_password").removeClass("valid invalid active");
                $("#new_password").addClass("valid");
            }
        });

        $("#new_password").focusout(function() {
            if ($("#password_confirmation").val() == $("#new_password").val()) {
                $("#new_password").removeClass("valid invalid active");
                $("#new_password").addClass("valid");
            }
        });

        $("#current_password").focusout(function() {
            $("#current_password").removeClass("valid invalid active");
            $("#current_password").addClass("valid");
        });

        $("#alertBox").hide();
    });

    function save() {
        if ($("#first_name").val() === "") {
            $("#first_name").removeClass("valid invalid active");
            $("#first_name").addClass("invalid active");
            $("#first_name").focus();
        } else if ($("#email").val() === "") {
            $("#email").removeClass("valid invalid active");
            $("#email").addClass("invalid active");
            $("#email").focus();
        } else if (($("#new_password").val() != "" || $("#password_confirmation").val() != "") && $("#password_confirmation").val() != $("#new_password").val()) {
            $("#new_password").removeClass("valid invalid active");
            $("#new_password").addClass("invalid active");
            $("#new_password").focus();
        } else {
            var str = $('#frmEditAccount').serialize();
            $("#first_name, #email, #new_password, #current_password").removeClass("invalid");
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('account/save'); ?>',
                data: str,
                dataType: 'jsonp',
                beforeSend: function() {
                },
                complete: function() {
                },
                success: function(response) {
                    if (response.status) {
                        location.href = '<?php echo base_url(); ?>';
                    } else {
                        $("#current_password").removeClass("valid invalid active");
                        $("#current_password").addClass("invalid active");
                        $("#current_password").focus();
                    }
                }
            });
        }
    }

    $(function(){
        var dz = new Dropzone("#my-dropzone", {
            url: "<?php echo base_url('account/upload_profile'); ?>",
            uploadMultiple: false,
            maxFiles: 1,
            maxFilesize: 1,
            acceptedFiles: ".jpg,.jpeg, .png",
            init: function() {
                this.hiddenFileInput.removeAttribute('multiple');

                this.on("processing", function() {
                    this.removeAllFiles();
                });

                this.on("addedfile", function(file) {
                    $("#alertBox").hide();
                });

                this.on("error", function(file, response) {
                    $("#alertBox #profile_msg").html(response);
                        $("#alertBox").show();

                    // Create the remove button
                        var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block btn-danger'>Quitar</button>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            $("#alertBox").hide();
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();

                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);

                    if (this.files[1]!=null){
                        this.removeFile(this.files[0]);
                    }
                    this.removeAllFiles();
                });

                this.on("sending", function(file, xhr, formData) {
                    // Will send the filesize along with the file as POST data.
                    formData.append("id_entity", '<?php echo $user_info->id;?>');
                });



                this.on("success", function(file, response) {
                    response= JSON.parse(response);

                    if(!response.status){
                        $("#alertBox #profile_msg").html(response.msg);
                        $("#alertBox").show();
                    }else{
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block btn-danger'><?php echo lang('editar_img'); ?></button>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            $("#alertBox").hide();
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();

                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.

                            change_image(response.file_name);

                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    }
                });
            }
       });
    });

    Dropzone.autoDiscover = false;

    function change_image(img){
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('account/remove_profile'); ?>',
            data: {
                file: img,
                id_entity: <?php echo $user_info->id;?>
            },
            dataType: 'jsonp',
            success: function(response){
                if(response.status){
                    location.reload();
                }
            }
        });
    }

</script>