<div class="container main-content">
    <div class="row">
        <div class="col s12 m12">
            <div id="alertBox" class="card-panel red">
                <span id="msg" class="white-text"></span>
            </div>
        </div>
        <div class="col m12 s12">
            <div class="card panel no-padding">
                <div class="card-header grey lighten-5">
                    <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">folder</i>&nbsp;&nbsp;<?php echo lang('area_edit'); ?></p>
                </div>
                <div class="card-content">
                    <form action="javascript:;" id="frmEditArea">
                        <div class="input-field col s12 m6">
                            <input class="validate" name="area[first_name]" id="name" type="text" value="<?php echo $area->name; ?>">
                            <label class="col s12 m12 no-padding" for="name" data-error="<?php echo lang('area_name_required'); ?>"><?php echo lang('area_name'); ?></label>
                        </div>

                        <label><?php echo lang('area_parent_list'); ?></label>
                        <select id="parents_sel" class="browser-default col s12 m6" name="area[id_parent]">
                            <option value="0" disabled><?php echo lang('select'); ?></option>
                            <?php foreach ($parents->result() as $row): ?>
                            <option value="<?php echo $row->id; ?>" <?php echo ($row->id==$area->id_parent ? 'selected':''); ?>><?php echo $row->first_name; ?></span>
                            <?php endforeach; ?>
                        </select>

                        <input type="hidden" name="area[id]" value="<?php echo $area->id; ?>">
                    </form>
                    <div class="clearfix">&nbsp;</div>
                    <a href="#!" onclick="javascript:$('#frmEditArea').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons">done</i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#frmEditArea").on("submit", function(e){
            e.preventDefault();
            e.stopPropagation();
            save();
        });

        $('#alertBox').hide();
    });

    function save(){
        $('#alertBox').hide();
        if($("#name").val()===""){
            $("#name").removeClass("valid invalid");
            $("#name").addClass("invalid");
            $("#name").focus();
        }else{
            var str = $('#frmEditArea').serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('admin/organigrama/area_save'); ?>',
                data: str,
                dataType: 'jsonp',
                beforeSend:function(){},
                complete:function(){},
                success:function(response) {
                    if( response.status ){
                        location.href= '<?php echo base_url('admin/organigrama/explore');?>/'+response.parent;
                    }else{
                        $('#alertBox #msg').html(response.msg);
                        $('#alertBox').show();
                    }
                }
            });
        }
    }
</script>