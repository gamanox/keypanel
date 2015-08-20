<?php $this->load->view('includes/common-functions'); ?>
<div class="container main-content">
    <div class="row">
        <h4><?php echo $title; ?></h4>

        <div class="col s12 m12">
            <div id="alertBox" class="card-panel red" style="display: none;">
                <span id="msg" class="white-text"></span>
            </div>
        </div>

        <table class="datatable striped  hover mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp is-upgraded">
            <thead>
                <tr>
                    <th data-field="name"><?php echo lang('info-general'); ?></th>
                    <th data-field="actions" style="width: 15%;"><?php echo lang('membership'); ?></th>
                    <th data-field="membership" style="width: 10%;"><?php echo lang('column-actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members->result() as $key => $member): ?>
                <tr>
                    <td>
                        <span><?php echo $member->full_name .' - <a class="indigo-text" href="mailto:'. $member->email .'">'. $member->email .'</a>'; ?></span><br>
                        <span class="grey-text lighten-1 tiny-text"><?php echo sprintf(lang('label-member-since'), lang(MEMBER)); ?>: <?php echo date_to_humans($member->create_at); ?></span>
                    </td>
                    <td>
                        <div class="switch">
                            <label>
                                Off
                                <input id="member_<?php echo $member->id; ?>" class="member-membership" <?php echo ($member->status_row == ENABLED ? 'checked' : ''); ?> data-id='<?php echo $member->id; ?>' type="checkbox">
                                <span class="lever"></span>
                                On
                            </label>
                        </div>
                    </td>
                    <td>
                        <a class="blue-text darken-1" href="<?php echo base_url('admin/member/edit/'. $member->id); ?>"><i class="tiny material-icons">edit</i></a>
                        <a href="#!" class="blue-text darken-1" onclick="javascript:trash(<?php echo $member->id; ?>, this);"><i class="tiny material-icons">delete</i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large red"><i class="large material-icons">add</i></a>
    <ul>
        <li>
            <a href="<?php echo base_url('admin/member/add'); ?>" class="btn-floating blue tooltipped" data-position="left" data-delay="50" data-tooltip="<?php echo lang('btn_add_member'); ?>"><i class="tiny material-icons left">person_add</i></a>
        </li>
    </ul>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.member-membership').on('change', function(){
            update_membership($(this));
        });
    });

    function update_membership(obj){
        $("#alertBox").hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('admin/member/update_membership_status'); ?>',
            data: {id: $(obj).data('id'), status_row: ($(obj).prop("checked")== false ? 0 : 1)},
            dataType: 'jsonp',
            success:function(response) {
                if(!response.status){
                    $("#alertBox").show();
                    $("#alertBox #msg").html(response.msg);
                }
            }
        });
    }

    function trash(id, obj) {
        if (confirm("<?php echo lang('desea_realizar_esta_accion');?>")){
            obj          = $(obj);
            var old_obj  = obj.html();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('admin/member/delete'); ?>',
                data: {
                    member_id: id
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
</script>