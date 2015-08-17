<!-- Modal Structure -->
<div id="modalEditCategory" class="modal">
    <div class="modal-content">
        <h4><?php echo lang('cat_edit'); ?></h4>
        <form action="javascript:;" id="frmEditCategory">
            <div class="clearfix">&nbsp;</div>
            <div class="input-field col m12 s12">
                <input class="validate" name="category[name]" id="name" type="text" value="<?php echo $category->name; ?>">
                <label class="col s12 m6 active" for="name" data-error="<?php echo lang('cat_name_required'); ?>"><?php echo lang('cat_name'); ?></label>
                <input type="hidden" name="category[id]" value="<?php echo $category->id; ?>">
            </div>
            <div class="clearfix">&nbsp;</div>
            <label><?php echo lang('cat_parent_list'); ?></label>
            <select id="categories_sel" class="browser-default" name="category[id_parent]">
                <option value="0"><?php echo lang('select'); ?></option>
                <?php foreach ($categories->result() as $row): ?>
                <option value="<?php echo $row->id; ?>" <?php echo ($row->id==$category->id_parent ? 'selected':''); ?>><?php echo $row->name; ?></span>
                <?php endforeach; ?>
            </select>

            <span id="modal-alert" class="red-text text-darken-2"></span>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" onclick="javascript:$('#frmEditCategory').submit();" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons">done</i></a>
        <a href="#!" class="modal-action modal-close  btn red waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons">close</i></a>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#frmEditCategory").on("submit", function(e){
            e.preventDefault();
            e.stopPropagation();
            save();
        });

        $('#modal-alert').hide();
    });

    function save(){
        $('#modal-alert').hide();
        if($("#name").val()===""){
            $("#name").removeClass("valid invalid");
            $("#name").addClass("invalid");
            $("#name").focus();
        }else{
            var str = $('#frmEditCategory').serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('admin/category/save'); ?>',
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