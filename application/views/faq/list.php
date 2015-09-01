<div class="container main-content">
    <div class="row">
        <div class="col s12 m12">
            <div id="alertBox" class="card-panel red" style="display: none;">
                <span id="msg" class="white-text"></span>
            </div>
        </div>

        <div class="col s12">
            <div class="card-panel partial nopadding">
                <div class="card-header grey lighten-4">
                    <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><?php echo $title; ?></p>
                </div>
                <div class="card-content">
                    <?php if( $faqs->num_rows() == 0 ) : ?>
                    <div class="col s12">
                        <h6 class="m-b-20"><?php echo lang('no-faqs'); ?></h6>
                    </div>
                    <?php else : ?>
                    <table class="datatable striped" id="tblFaq">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="width: 15%;"><?php echo lang('date-created'); ?></th>
                                <th data-field="membership" style="width: 10%;"><?php echo lang('column-actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($faqs->result() as $key => $faq): ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                    <?php endif; ?>

                    <a href="javascript:;" class="btn"><?php echo lang('btn_add_faq'); ?></a>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a href="<?php echo base_url('admin/faq/add'); ?>" class="btn-floating btn-large red tooltipped" data-position="left" data-delay="50" data-tooltip="<?php echo lang('btn_add_faq'); ?>"><i class="large material-icons">add</i></a>
</div>

<script type="text/javascript">
    $(function(){
        /*$('.member-membership').on('change', function(){
            update_membership($(this));
        });*/
    });

    /*function update_membership(obj){
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
    }*/

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