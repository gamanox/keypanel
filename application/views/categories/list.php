<div class="container main-content">
    <div class="row">
        <h4><?php echo $title; ?></h4>
        <table class="datatable hover mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp is-upgraded">
            <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric"><?php echo lang('cat_name'); ?></th>
                    <th><?php echo lang('cat_create_at'); ?></th>
                    <th><?php echo lang('column-actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nodes->result() as $node): ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url('admin/category/explore/'. $node->id); ?>"><?php echo $node->name; ?></a>
                    </td>
                    <td><?php echo date_to_humans($node->create_at, 'd/m/Y'); ?></td>
                    <td>
                        <a class="blue-text darken-1" href="#!" onclick="javascript:edit(<?php echo $node->id; ?>, this);"><i class="tiny material-icons">edit</i></a>
                        <a class="blue-text darken-1" href="#!" onclick="javascript:trash(<?php echo $node->id; ?>, this);"><i class="tiny material-icons">delete</i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a id="btn-action" class="btn-floating btn-large red tooltipped" data-position="left" data-delay="50" data-tooltip="<?php echo lang('cat_add'); ?>"><i class="large material-icons">add</i></a>
</div>

<div id="modal_content"></div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#btn-action").click(function(){
            add(<?php echo (isset($parent->id) ? $parent->id : 0);?>);
        });
    });

    function add(id) {
	$.ajax({
	    type: 'POST',
	    url: '<?php echo base_url('admin/category/add'); ?>',
	    data: {id_category:id},
	    dataType: 'jsonp',
	    success:function(response) {
		$("#modal_content").html(response);
		$('#modalAddCategory').openModal();
	    }
	});

    }

    function edit(id, obj) {
        obj          = $(obj);
        var old_obj  = obj.html();
	$.ajax({
	    type: 'POST',
	    url: '<?php echo base_url('admin/category/edit'); ?>',
	    data: {id_category:id},
	    dataType: 'jsonp',
            beforeSend:function(){
                obj.html('<i class="mdl-spinner mdl-js-spinner is-active"></i>');
            },
            complete:function(){
                obj.html(old_obj);
            },
	    success:function(response) {
		$("#modal_content").html(response);
		$('#modalEditCategory').openModal();
	    }
	});

    }

    function trash(id, obj) {
        if (confirm("<?php echo lang('desea_realizar_esta_accion');?>")){
            obj          = $(obj);
            var old_obj  = obj.html();
            var categories = [];

            if(id != undefined){
                categories.push(id);
            }

            $.each($('.datatable tbody input[type=checkbox]'), function() {
                if ($(this).attr("checked")) {
                    categories.push(
                        $(this).val()
                    );
                }
            });

            if (categories.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('admin/category/delete'); ?>',
                    data: {
                        categories: categories
                    },
                    dataType: 'jsonp',
                    beforeSend:function(){
                        obj.html('<i class="mdl-spinner mdl-js-spinner is-active"></i>');
                    },
                    complete:function(){
                        obj.html(old_obj);
                    },
                    success:function(response) {
                        if(response.status){
                            alert(response.msg);
                            location.reload();
                        } else {
                            alert(response.msg);
                        }
                    }
                });
            }
        }
    }
</script>