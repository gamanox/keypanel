<div class="container main-content">
    <div class="row">
        <?php if(isset($profile->addresses))$profile->address= $profile->addresses->first_row();?>
        <form action="#" method="post" id="frmEditProfile">
            <div class="col s12 m12">
                <div id="alertBox" class="card-panel red" style="display: none;">
                    <span id="profile_msg" class="white-text"></span>
                </div>
            </div>

            <div class="col m3 s12">
                <div class="card panel partial">
                    <div class="card-header grey lighten-5">
                        <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">account_box</i>&nbsp;&nbsp;<?php echo lang('org_logo'); ?></p>
                    </div>
                    <div class="card-content">
                        <?php if (isset($profile->avatar)): ?>
                            <div class="dropzone dz-clickable center-align columns" id="my-dropzone" style="min-height: 120px;">
                                <div class="dz-message" style="display: none;">
                                    <span><?php echo lang('profile_upload_image'); ?></span>
                                </div>
                                <div class="dz-preview dz-processing dz-image-preview dz-success">
                                    <div class="dz-details">
                                        <img src="<?php echo base_url('assets/images/profiles/'.$profile->avatar); ?>" />
                                    </div>
                                    <button type="button" class="btn btn-sm btn-block btn-danger" onclick="javascript:remove_image('<?php echo $profile->avatar;?>');">Quitar</button>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="dropzone dz-clickable center-align columns" id="my-dropzone" style="min-height: 120px;">
                                <div class="dz-message">
                                    <span><?php echo lang('org_upload_logo'); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <div class="col m6 s12">
                <div class="card panel no-padding">
                    <div class="card-header grey lighten-5">
                        <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">device_hub</i>&nbsp;&nbsp;<?php echo lang('profile_edit'); ?></p>
                    </div>
                    <div class="card-content">


                        <h6><?php echo lang('org_info-general'); ?></h6>
                        <div class="input-field col s12 m6">
                            <input class="validate" name="profile[first_name]" value="<?php echo $profile->first_name; ?>" id="first_name" type="text">
                            <label class="col s12 m6 no-padding" for="first_name" data-error="<?php echo lang('org_first_name_required'); ?>"><?php echo lang('org_first_name'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="profile[last_name]" id="last_name" type="text" value="<?php echo $profile->last_name; ?>">
                            <label class="col s12 m6 no-padding" for="last_name"><?php echo lang('org_last_name'); ?></label>
                        </div>
                        <div class="input-field col s12 m12">
                            <input class="validate" name="profile[email]" value="<?php echo $profile->email; ?>" id="email" type="email">
                            <label class="col s12 m12 no-padding" for="email" data-error="<?php echo lang('org_email_required'); ?>"><?php echo lang('org_email'); ?></label>
                        </div>
                        <div class="input-field col s12 m12">
                            <textarea name="contact[bio]" id="bio" class="materialize-textarea validate"><?php echo $profile->contact->bio; ?></textarea>
                            <label for="bio"><?php echo lang('org_bio'); ?></label>
                        </div>

                        <div class="clearfix"></div>
                        <h6><?php echo lang('org_info-contact'); ?></h6>
                        <div class="input-field col s12 m6">
                            <input name="contact[phone_business]" value="<?php echo $profile->contact->phone_business; ?>" id="phone_business" type="text">
                            <label for="phone_business"><?php echo lang('org_phone-business'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="contact[facebook]" value="<?php echo $profile->contact->facebook; ?>" id="facebook" type="text">
                            <label for="facebook"><?php echo lang('org_facebook'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="contact[twitter]" value="<?php echo $profile->contact->twitter; ?>" id="twitter" type="text">
                            <label for="twitter"><?php echo lang('org_twitter'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="contact[linkedin]" value="<?php echo $profile->contact->linkedin; ?>" id="linkedin" type="text">
                            <label for="linkedin"><?php echo lang('org_linkedin'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="contact[gplus]" value="<?php echo $profile->contact->gplus; ?>" id="gplus" type="text">
                            <label for="gplus"><?php echo lang('org_gplus'); ?></label>
                        </div>

                        <div class="clearfix"></div>
                        <h6><?php echo lang('org_info-address'); ?></h6>
                        <div class="input-field col s12 m4">
                            <input name="address[country]" value="<?php echo $profile->address->country; ?>" id="country" type="text">
                            <label for="country"><?php echo lang('org_country'); ?></label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input name="address[state]" value="<?php echo $profile->address->state; ?>" id="state" type="text">
                            <label for="state"><?php echo lang('org_state'); ?></label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input name="address[city]" value="<?php echo $profile->address->city; ?>" id="city" type="text">
                            <label for="city"><?php echo lang('org_city'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="address[neighborhood]" value="<?php echo $profile->address->neighborhood; ?>" id="neighborhood" type="text">
                            <label for="neighborhood"><?php echo lang('org_neighborhood'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="address[street]" value="<?php echo $profile->address->street; ?>" id="street" type="text">
                            <label for="street"><?php echo lang('org_street'); ?></label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input name="address[zip_code]" value="<?php echo $profile->address->zip_code; ?>" id="zip_code" type="text">
                            <label for="zip_code"><?php echo lang('org_zip_code'); ?></label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input name="address[num_ext]" value="<?php echo $profile->address->num_ext; ?>" id="num_ext" type="text">
                            <label for="num_ext"><?php echo lang('org_num_ext'); ?></label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input name="address[num_int]" value="<?php echo $profile->address->num_int; ?>" id="num_int" type="text">
                            <label for="num_int"><?php echo lang('org_num_int'); ?></label>
                        </div>


                        <div class="clearfix"></div>
                        <a href="javascript:;" onclick="javascript:$('#frmEditProfile').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons">done_all</i><?php echo lang('org_btn_save_profile'); ?></a>

                    </div>
                </div>
            </div>

            <div class="col m3 s12">
                <div class="card panel partial">
                    <div class="card-header grey lighten-5">
                        <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">folder</i>&nbsp;&nbsp;<?php echo lang('org_related_tags'); ?></p>
                    </div>
                    <div class="card-content">
                        <div id="organigrama-tags">
                            <?php foreach ($profile->tags->result() as $tag): ?>
                                <span class="blue white-text tag trend">
                                    <?php echo $tag->name; ?>
                                    <a class="white-text" href="#" onclick="javascript:$(this).parent().remove();">
                                        <i class="tiny material-icons">cancel</i>
                                    </a>
                                    <input type="hidden" name="tags[]" value="<?php echo $tag->id; ?>">
                                </span>

                            <?php endforeach; ?>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <label><?php echo lang('org_select_tags'); ?></label>
                        <select id="tags_sel" class="browser-default">
                            <option value="" disabled selected><?php echo lang('select'); ?></option>
                            <?php foreach ($tags->result() as $tag): ?>
                                <option value="<?php echo $tag->id; ?>"><?php echo $tag->name; ?></span>
                            <?php endforeach; ?>
                        </select>
                        <div class="clearfix">&nbsp;</div>
                        <button class="btn btn-small blue waves-effect waves-light right" type="button" onclick="javascript:tag_add()">
                            <i class="tiny material-icons">add</i>
                        </button>

                        <div class="clearfix">&nbsp;</div>
                    </div>
                </div>
            </div>

            <div id="profile">

            </div>
            <input type="hidden" name="profile[id]" value="<?php echo $profile->id; ?>">
            <input type="hidden" name="address[id]" value="<?php echo $profile->address->id; ?>">
            <input type="hidden" name="contact[id]" value="<?php echo $profile->contact->id; ?>">
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/dropZone/lib/dropzone.js');?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#frmEditProfile").on("submit", function(e){
            e.preventDefault();
            e.stopPropagation();
            save();
        });

        $("#first_name").focusout(function(){
            if($(this).val()===""){
                $(this).removeClass("valid invalid");
                $(this).addClass("invalid");
                $(this).focus();
            }
        });

         $('select').material_select();
    });

    $(function(){
        var dz = new Dropzone("#my-dropzone", {
            url: "<?php echo base_url('admin/organigrama/upload_profile'); ?>",
            uploadMultiple: false,
            maxFiles: 1,
            maxFilesize: 1,
            acceptedFiles: "image/jpg,image/jpeg",
            init: function() {
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
                });

                this.on("success", function(file, response) {
                    response= JSON.parse(response);

                    if(!response.status){
                        $("#alertBox #profile_msg").html(response.msg);
                        $("#alertBox").show();
                    }else{
                        $("#profile").append(
                            '<input id="avatar-'+response.file_name+'" type="hidden" name="profile[avatar]" value="'+response.file_name+'">'
                        );

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

                            remove_image(response.file_name);

                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    }
                });
            }
       });
    });

    Dropzone.autoDiscover = false;
    function save(){
        if($("#first_name").val()===""){
            $("#first_name").removeClass("valid invalid");
            $("#first_name").addClass("invalid");
            $("#first_name").focus();
        }else if($("#email").val()===""){
            $("#email").removeClass("valid invalid");
            $("#email").addClass("invalid");
            $("#email").focus();
        }else{
            var str = $('#frmEditProfile').serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('admin/organigrama/profile_save'); ?>',
                data: str,
                dataType: 'jsonp',
                beforeSend:function(){},
                complete:function(){},
                success:function(response) {
                    if( response.status )
                        location.href = '<?php echo base_url('admin/organigrama/explore/'.$profile->id_parent); ?>';
                }
            });
        }
    }

    function tag_add(){
        var val= $("#tags_sel").val();
        var text= $("#tags_sel option:selected").text();
        var exists=false;

        $.each($("#organigrama-tags input"), function(index,child){
            if($(child).val()==val){
                exists=true;
            }
        });

        if($.isNumeric(val) && val > 0 && !exists){
            $("#organigrama-tags").append('<span class="blue white-text tag trend">'+text
                    +'<a class="white-text" href="#!" onclick="javascript:$(this).parent().remove();">'
                    +'<i class="tiny material-icons">cancel</i></a>'
                    +'<input type="hidden" name="tags[]" value="'+val+'"></span>');
        }
    }

    function remove_image(img){
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('admin/organigrama/remove_profile'); ?>',
            data: {
                file: img,
                id_entity: <?php echo $profile->id;?>
            },
            dataType: 'jsonp',
            success: function(response){
                if(response.status){
                    $("#profile-"+img).remove();
                    location.reload();
                }
            }
        });
    }
</script>