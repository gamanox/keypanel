<div class="container main-content">
    <div class="row">
        <?php if(isset($organization->addresses))$organization->address= $organization->addresses->first_row();?>
        <form action="#" method="post" id="frmEditOrganization">
            <div class="col m8 s12">
                <div class="card panel no-padding">
                    <div class="card-header grey lighten-5">
                        <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">device_hub</i>&nbsp;&nbsp;<?php echo lang('org_add'); ?></p>
                    </div>
                    <div class="card-content">


                        <h6><?php echo lang('org_info-general'); ?></h6>
                        <div class="input-field col s12 m6">
                            <input class="validate" name="organization[first_name]" value="<?php echo $organization->name; ?>" id="first_name" type="text">
                            <label class="col s12 m6" for="first_name" data-error="<?php echo lang('org_first_name_required'); ?>"><?php echo lang('org_first_name'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input class="validate" name="organization[email]" value="<?php echo $organization->email; ?>" id="email" type="email">
                            <label class="col s12 m6" for="email" data-error="<?php echo lang('org_email_required'); ?>"><?php echo lang('org_email'); ?></label>
                        </div>
                        <div class="input-field col s12 m12">
                            <textarea name="contact[description]" value="<?php echo $organization->contact->description; ?>" id="description" class="materialize-textarea validate"></textarea>
                            <label for="description"><?php echo lang('org_description'); ?></label>
                        </div>

                        <div class="clearfix"></div>
                        <h6><?php echo lang('org_info-contact'); ?></h6>
                        <div class="input-field col s12 m6">
                            <input name="contact[phone_business]" value="<?php echo $organization->contact->phone_business; ?>" id="phone_business" type="text">
                            <label for="phone_business"><?php echo lang('org_phone-business'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="contact[facebook]" value="<?php echo $organization->contact->facebook; ?>" id="facebook" type="text">
                            <label for="facebook"><?php echo lang('org_facebook'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="contact[twitter]" value="<?php echo $organization->contact->twitter; ?>" id="twitter" type="text">
                            <label for="twitter"><?php echo lang('org_twitter'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="contact[linkedin]" value="<?php echo $organization->contact->linkedin; ?>" id="linkedin" type="text">
                            <label for="linkedin"><?php echo lang('org_linkedin'); ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="contact[gplus]" value="<?php echo $organization->contact->gplus; ?>" id="gplus" type="text">
                            <label for="gplus"><?php echo lang('org_gplus'); ?></label>
                        </div>

                        <div class="clearfix"></div>
                        <h6><?php echo lang('org_info-address'); ?></h6>
                        <div class="input-field col s12 m4">
                            <input name="address[country]" value="<?php echo $organization->address->country; ?>" id="country" type="text">
                            <label for="country"><?php echo lang('org_country'); ?></label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input name="address[state]" value="<?php echo $organization->address->state; ?>" id="state" type="text">
                            <label for="state"><?php echo lang('org_state'); ?></label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input name="address[city]" value="<?php echo $organization->address->city; ?>" id="city" type="text">
                            <label for="city"><?php echo lang('org_city'); ?></label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input name="address[neighborhood]" value="<?php echo $organization->address->neighborhood; ?>" id="neighborhood" type="text">
                            <label for="neighborhood"><?php echo lang('org_neighborhood'); ?></label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input name="address[street]" value="<?php echo $organization->address->street; ?>" id="street" type="text">
                            <label for="street"><?php echo lang('org_street'); ?></label>
                        </div>
                        <div class="input-field col s12 m2">
                            <input name="address[zip_code]" value="<?php echo $organization->address->zip_code; ?>" id="zip_code" type="text">
                            <label for="zip_code"><?php echo lang('org_zip_code'); ?></label>
                        </div>
                        <div class="input-field col s12 m2">
                            <input name="address[num_ext]" value="<?php echo $organization->address->num_ext; ?>" id="num_ext" type="text">
                            <label for="num_ext"><?php echo lang('org_num_ext'); ?></label>
                        </div>
                        <div class="input-field col s12 m2">
                            <input name="address[num_int]" value="<?php echo $organization->address->num_int; ?>" id="num_int" type="text">
                            <label for="num_int"><?php echo lang('org_num_int'); ?></label>
                        </div>


                        <div class="clearfix"></div>
                        <a href="javascript:;" onclick="javascript:$('#frmEditOrganization').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons">done</i><?php echo lang('org_btn_save_organization'); ?></a>

                    </div>
                </div>
            </div>
            <div class="col m4 s12">
                <div class="card panel partial">
                    <div class="card-header grey lighten-5">
                        <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">folder</i>&nbsp;&nbsp;<?php echo lang('org_categories'); ?></p>
                    </div>
                    <div class="card-content">
                        <div id="organigrama-categories">
                            <?php foreach ($organization->categories->result() as $category): ?>
                                <span class="blue white-text category trend">
                                        <?php echo $category->name; ?>
                                    <a class="white-text" href="#" onclick="javascript:$(this).parent().remove();">
                                        <i class="tiny material-icons">cancel</i>
                                    </a>
                                </span>
                                <input type="hidden" name="categories[]" value="<?php echo $category->id; ?>">
                            <?php endforeach; ?>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <label><?php echo lang('org_select_categories'); ?></label>
                        <select id="categories_sel" class="browser-default">
                            <option value="" disabled selected><?php echo lang('select'); ?></option>
                            <?php foreach ($categories->result() as $categoria): ?>
                                <option value="<?php echo $categoria->id; ?>"><?php echo $categoria->name; ?></span>
                            <?php endforeach; ?>
                        </select>
                        <div class="clearfix">&nbsp;</div>
                        <button class="btn btn-small blue waves-effect waves-light right" type="button" onclick="javascript:category_add()">
                            <i class="tiny material-icons">done</i>
                        </button>

                        <div class="clearfix">&nbsp;</div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#frmEditOrganization").on("submit", function(e){
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

    function save(){
        if($("#first_name").val()===""){
            $("#first_name").removeClass("valid invalid");
            $("#first_name").addClass("invalid");
            $("#first_name").focus();
        }else if($("#email").val()===""){
            $("#email").removeClass("valid invalid");
            $("#email").addClass("invalid");
            $("#first_name").focus();
        }else{
            var str = $('#frmEditOrganization').serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('admin/organigrama/save'); ?>',
                data: str,
                dataType: 'jsonp',
                beforeSend:function(){},
                complete:function(){},
                success:function(response) {
                    if( response.status )
                        location.href = '<?php echo base_url('admin/organigrama'); ?>';
                }
            });
        }
    }

    function category_add(){
        var val= $("#categories_sel").val();
        var text= $("#categories_sel option:selected").text();
        var exists=false;

        $.each($("#organigrama-categories input"), function(index,child){
            if($(child).val()==val){
                exists=true;
            }
        });

        if($.isNumeric(val) && val > 0 && !exists){
            $("#organigrama-categories").append('<span class="blue white-text category trend">'+text
                    +'<a class="white-text" href="#" onclick="javascript:$(this).parent().remove();">'
                    +'<i class="tiny material-icons">cancel</i></a></span>'
                    +'<input type="hidden" name="categories[]" value="'+val+'">');
        }
    }
</script>