<link href="<?php echo base_url('assets/css/codeMirror/codemirror.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/codeMirror/monokai.css'); ?>" rel="stylesheet">

<div class="container main-content">
    <div class="row">
        <div class="col s12">
            <div class="card-panel partial nopadding">
                <div class="card-header grey lighten-4">
                    <p class="card-title blue-grey-text text-darken-4 nomargin valign-wrapper"><?php echo lang('faq_add'); ?></p>
                </div>
                <div class="card-content">
                    <form action="<?php echo base_url('admin/faq/add'); ?>" method="post">
                        <div class="input-field col s12 nopadding">
                            <input class="validate" name="title" id="title" type="text" required>
                            <label for="title"><?php echo lang('faq-title'); ?></label>
                        </div>
                        <div class="clearfix"></div>

                        <div id="content"></div>

                        <div class="clearfix"></div>
                        <button class="btn m-t-10" type="submit"><?php echo lang('btn_save_faq'); ?></button>
                    </form>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url('assets/js/materialnote/ckMaterializeOverrides.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/materialnote/lib/codeMirror/codemirror.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/materialnote/lib/codeMirror/xml.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/materialnote/materialNote.js'); ?>"></script>
<script type="text/javascript">
    var toolbar = [
        ['style', ['style', 'bold', 'italic', 'underline', 'strikethrough', 'clear']],
        ['fonts', ['fontsize', 'fontname']],
        ['color', ['color']],
        ['undo', ['undo', 'redo', 'help']],
        ['ckMedia', ['ckImageUploader', 'ckVideoEmbeeder']],
        ['misc', ['link', 'picture', 'table', 'hr', 'codeview', 'fullscreen']],
        ['para', ['ul', 'ol', 'paragraph', 'leftButton', 'centerButton', 'rightButton', 'justifyButton', 'outdentButton', 'indentButton']],
        ['height', ['lineheight']],
    ];

    $('#content').materialnote({
        toolbar: toolbar,
        height: 350,
        minHeight: 100,
        defaultBackColor: '#e0e0e0'
    });
</script>