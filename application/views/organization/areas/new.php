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
                    <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><i class="tiny material-icons valign">folder</i>&nbsp;&nbsp;<?php echo lang('area_add'); ?></p>
                </div>
                <div class="card-content">
                    <form action="javascript:;" id="frmAddArea">
                        <div class="input-field col s12 m6">
                            <input class="validate" name="area[first_name]" id="name" type="text">
                            <label class="col s12 m12 no-padding" for="name" data-error="<?php echo lang('area_name_required'); ?>"><?php echo lang('area_name'); ?></label>
                            <input type="hidden" name="area[id_parent]" value="<?php echo $entity->id; ?>"/>
                        </div>

                    </form>
                    <div class="clearfix">&nbsp;</div>
                    <a href="#!" onclick="javascript:$('#frmAddArea').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons">done</i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#frmAddArea").on("submit", function(e){
            e.preventDefault();
            e.stopPropagation();
            create();
        });

        $('#alertBox').hide();
    });

    function create(){
        $('#alertBox').hide();
        if($("#name").val()===""){
            $("#name").removeClass("valid invalid");
            $("#name").addClass("invalid");
            $("#name").focus();
        }else{
            var str = $('#frmAddArea').serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('admin/organigrama/area_create'); ?>',
                data: str,
                dataType: 'jsonp',
                beforeSend:function(){},
                complete:function(){},
                success:function(response) {
                    if( response.status ){
                        location.href= '<?php echo base_url('admin/organigrama/explore/'.$entity->id);?>';
                    }else{
                        $('#alertBox #msg').html(response.msg);
                        $('#alertBox').show();
                    }
                }
            });
        }
    }
</script>