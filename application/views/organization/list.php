<div class="container main-content">
    <div class="row">
        <h4><?php echo $title; ?></h4>
        <table class="datatable hover mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp is-upgraded">
            <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric"><?php echo lang('org_name'); ?></th>
                    <th><?php echo lang('org_type'); ?></th>
                    <th><?php echo lang('org_create_at'); ?></th>
                    <th><?php echo lang('column-actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nodes->result() as $node): ?>
                <tr>
                    <td>
                        <?php if (in_array($node->type, array(ORGANIZATION, AREA))): ?>
                            <a href="<?php echo base_url('admin/organigrama/explore/'. $node->id); ?>"><?php echo $node->name; ?></a>
                        <?php else: ?>
                            <a><?php echo $node->name; ?></a>
                        <?php endif; ?>
                    </td>
                    <td><?php echo lang($node->type); ?></td>
                    <td><?php echo date_to_humans($node->create_at, 'd/m/Y'); ?></td>
                    <td>
                        <a class="blue-text darken-1" href="<?php echo base_url('admin/organigrama/edit/'. $node->id); ?>"><i class="tiny material-icons">edit</i></a>
                        <a style="cursor: pointer;" class="blue-text darken-1" onclick="javascript:trash(<?php echo $node->id; ?>, this);"><i class="tiny material-icons">delete</i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large red"><i class="large material-icons">add</i></a>
    <ul>
        <?php if (isset($parent) and in_array($parent->type, array(ORGANIZATION,AREA))): ?>
            <li>
                <li><a href="<?php echo base_url('admin/organigrama/profile_add/'.$parent->id); ?>" class="btn-floating blue tooltipped" data-position="left" data-delay="50" data-tooltip="<?php echo lang('org_profile_add'); ?>"><i class="material-icons">person_add</i></a></li>
                <li><a href="<?php echo base_url('admin/organigrama/area_add/'.$parent->id); ?>" class="btn-floating blue tooltipped" data-position="left" data-delay="50" data-tooltip="<?php echo lang('org_area_add'); ?>"><i class="material-icons">folder</i></a></li>
            </li>
        <?php else: ?>
            <li>
                <li><a href="<?php echo base_url('admin/organigrama/add'); ?>" class="btn-floating blue tooltipped" data-position="left" data-delay="50" data-tooltip="<?php echo lang('org_add'); ?>"><i class="material-icons">device_hub</i></a></li>
            </li>
        <?php endif; ?>
    </ul>
</div>

<script type="text/javascript">
function trash(id, obj) {
    if (confirm("<?php echo lang('desea_realizar_esta_accion');?>")){
        obj          = $(obj);
        var old_obj  = obj.html();
        var entities = [];

        if(id != undefined){
            entities.push(id);
        }

        $.each($('.datatable tbody input[type=checkbox]'), function() {
            if ($(this).attr("checked")) {
                entities.push(
                    $(this).val()
                );
            }
        });

        if (entities.length > 0) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('admin/organigrama/delete'); ?>',
                data: {
                    entities: entities
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