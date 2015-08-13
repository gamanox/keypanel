<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <title><?php echo lang('main-title'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/materialize.css'); ?>" media="screen,projection">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css'); ?>" media="screen,projection">
    <link href="favicon.png" rel="icon" type="image/png">
</head>
<body id="micro">
    <div class="container">
        <nav class="header">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo"><img src="<?php echo base_url('assets/images/logo-micrositio.png'); ?>" alt=""></a>
                <ul id="nav-mobile" class="center-align">
                    <li class="active"><a href="#"><?php echo lang('main-menu-inicio'); ?></a></li>
                    <li><a href="#"><?php echo lang('main-menu-caracteristicas'); ?></a></li>
                    <li><a href="#"><?php echo lang('main-menu-contacto'); ?></a></li>
                </ul>
            </div>
        </nav>

        <div class="row">
            <div class="col sm12 m8 l8">
                <div class="card">
                    <div class="card-image">
                        <span class="card-title"><?php echo lang('main_que_es_keypanel'); ?></span>
                    </div>
                </div>
            </div>

            <form id="login-card" class="col sm12 m4 l4">
                <div class="card">
                    <div class="card-content">
                        <h6 class="blue-grey-text text-darken-4"><?php echo lang('micrositio_form_title'); ?></h6>
                        <a id="forgot-pass" href="#"><p class="blue-grey-text text-lighten-3"><?php echo lang('btn_forgot_password'); ?></p></a>

                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input name="member[username]" id="email" type="text" class="validate">
                                <label for="email"><?php echo lang('username'); ?></label>
                            </div>
                            <div class="input-field col s12 m12 l12">
                                <input name="member[password]" id="password" type="password" class="validate">
                                <label for="password"><?php echo lang('password'); ?></label>
                            </div>
                        </div>

                        <div class="row">
                            <button name="action" class="col s12 m12 l12 btn-large blue waves-effect waves-light"><?php echo lang('main_ingresar'); ?></button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col sm12 m4 l4">
                <div class="card small feature">
                    <div class="card-content">
                        <div class="row">
                            <h6 class="s12 m12 l12 blue-grey-text text-darken-4"><?php echo lang('main_nuestro_servicio'); ?></h6>
                        </div>

                        <div class="row">
                            <p class="s12 m12 l12 blue-grey-text text-lighten-3"><?php echo lang('main_nuestro_servicio_desc'); ?></p>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="row"><a id="knowmore" href="#" class="btn-large blue waves-effect waves-light col s12 m12 l12 text-white"><?php echo lang('main_caracteristicas'); ?></a></div>
                    </div>
                </div>
            </div>

            <div class="col sm12 m4 l4">
                <div class="card small feature">
                    <div class="card-content">
                        <div class="row">
                            <h6 class="col s12 m12 l12 blue-grey-text text-darken-4"><?php echo lang('main_estadisticas'); ?></h6>
                        </div>
                        <div class="row">
                            <p class="col s12 m12 l12 blue-grey-text text-lighten-3"><?php echo lang('main_estadisticas_desc'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col sm12 m4 l4">
                <div class="card small feature">
                    <div class="card-content">
                        <div class="row">
                            <h6 class="col s12 m12 l12 blue-grey-text text-darken-4"><?php echo lang('main_solicita_una_prueba'); ?></h6>
                        </div>
                        <div class="row">
                            <p class="col s12 m12 l12 blue-grey-text text-lighten-3"><?php echo lang('main_solicita_una_desc'); ?></p>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="row"><a id="knowmore" href="#" class="btn-large blue waves-effect waves-light col s12 m12 l12 text-white"><?php echo lang('main_solicita_tu_prueba'); ?></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="<?php echo base_url('assets/js/materialize.min.js'); ?>"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#login-card").on("submit", function(e){
                e.preventDefault();
                e.stopPropagation();
                login();
            });
        });
        function login(){
            var str = $('#login-card').serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url("account/login"); ?>',
                data: str,
                dataType: 'jsonp',
                beforeSend:function(){},
                complete:function(){},
                success:function(response) {
                    if( response.status )
                        location.href = response.redirect_url
                }
            });
        }
    </script>
</body>
</html>