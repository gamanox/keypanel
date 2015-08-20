<?php $this->load->view('includes/common-functions'); ?>

<div class="s12 m12 l12">
    <div class="card-panel nopadding">
        <div class="card-header grey lighten-5">
            <p class="card-title grey-text nomargin valign-wrapper"><i class="material-icons valign">view_list</i>&nbsp;<?php echo lang('news_title'); ?></p>
        </div>

        <div class="card-content">
            <table class="striped datatable">
                <thead>
                    <tr>
                        <th data-field="name"><?php echo lang('column-info'); ?></th>
                        <th data-field="actions" style="width:10%"><?php echo lang('column_actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts->result() as $post): ?>
                    <tr>
                        <td>
                            <span><?php echo $post->title; ?></span><br>
                            <span class="grey-text lighten-1 tiny-text"><?php echo sprintf(lang('news_create_at'), date_to_humans($post->create_at)); ?></span>
                        </td>
                        <td>
                            <a class="blue-text darken-1" href="<?php echo base_url('admin/news/edit/'. $post->id); ?>"><i class="tiny material-icons">edit</i></a>
                            <a class="blue-text darken-1" href="<?php echo base_url('admin/news/delete/'. $post->id); ?>"><i class="tiny material-icons">delete</i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large red"><i class="large material-icons">add</i></a>
    <ul>
        <li>
            <a href="<?php echo base_url('news/add'); ?>" class="btn-floating blue tooltipped" data-position="left" data-delay="50" data-tooltip="<?php echo lang('btn_add_member'); ?>"><i class="tiny material-icons left">person_add</i></a>
        </li>
    </ul>
</div>