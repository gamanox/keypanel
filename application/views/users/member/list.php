<div class="container main-content">
    <div class="row">
        <div class="s12 m12 l12">
            <div class="card card-middle small">
                <div class="card-content">
                    <span class="card-title grey-text"><?php echo lang('members_card_title'); ?></span>

                    <?php if( isset($members) and count($members) > 0 ) : ?>
                    <table class="responsive-table striped">
                        <thead>
                            <tr>
                                <th data-field="id"></th>
                                <th data-field="name"></th>
                                <th data-field="price"><?php echo lang('column_actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Alvin</td>
                                <td>Eclair</td>
                                <td>$0.87</td>
                            </tr>
                            <tr>
                                <td>Alan</td>
                                <td>Jellybean</td>
                                <td>$3.76</td>
                            </tr>
                            <tr>
                                <td>Jonathan</td>
                                <td>Lollipop</td>
                                <td>$7.00</td>
                            </tr>
                        </tbody>
                    </table>
                    <?php else : ?>

                    <?php endif; ?>

                </div>
                <div class="card-action">
                    <a href="<?php echo base_url('administration/add_member'); ?>" class="btn blue waves-effect waves-light s12 m3 l3 text-white"><i class="tiny material-icons left">perm_identity</i><?php echo lang('btn_add_member'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>