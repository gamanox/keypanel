<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="">
    <title></title>
    <?php echo link_tag('assets/stylesheets/material.min.css'); ?>    
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link href="favicon.png" rel="icon" type="image/png" />
</head>
<body>
    <div class="container">
        Micrositio
        <?php if( $this->session->is_loggedin ) : ?>
            <!-- Esta loggeado -->
        <?php else : ?>
            <!-- No esta loggeado, mostramos el form para login -->
        <?php endif; ?>
    </div>
    <script src="<?php echo base_url('assets/javascripts/material.min.js'); ?>"></script>
</body>
</html>