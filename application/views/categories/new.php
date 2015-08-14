<!-- Modal Structure -->
<div id="modalAddCategory" class="modal">
    <div class="modal-content">
        <h4><?php echo lang('cat_add'); ?></h4>
        <form action="javascript:;" id="frmAddCategory">
            <div class="input-field">
                <input class="validate" name="category[name]" id="name" type="text">
                <label class="col s12 m6" for="name" data-error="<?php echo lang('cat_name_required'); ?>"><?php echo lang('cat_name'); ?></label>
                <input type="hidden" name="category[id_parent]" value="<?php echo (isset($category->id) ? $category->id:0); ?>"/>
            </div>

            <span id="modal-alert" class="red-text text-darken-2"></span>


        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" onclick="javascript:$('#frmAddCategory').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons">done</i></a>
        <a href="#!" class="modal-action modal-close  btn red waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons">close</i></a>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#frmAddCategory").on("submit", function(e){
            e.preventDefault();
            e.stopPropagation();
            create();
        });

        $('#modal-alert').hide();
    });

    function create(){
        $('#modal-alert').hide();
        if($("#name").val()===""){
            $("#name").removeClass("valid invalid");
            $("#name").addClass("invalid");
            $("#name").focus();
        }else{
            var str = $('#frmAddCategory').serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('admin/category/create'); ?>',
                data: str,
                dataType: 'jsonp',
                beforeSend:function(){},
                complete:function(){},
                success:function(response) {
                    if( response.status ){
                        location.reload();
                    }else{
                        $('#modal-alert').html(response.msg);
                        $('#modal-alert').show();
                    }
                }
            });
        }
    }
</script>