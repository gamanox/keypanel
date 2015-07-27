<div class="navbar-fixed">
    <nav class="blue accent-2">
        <div class="container">
            <div class="nav-wrapper">
                <a href="#!" class="brand-logo"><img src="<?php echo base_url('assets/images/logo-white.png'); ?>" alt=""></a>
                <a href="#" data-activates="mobile-demo" class="button-collapse left"><i class="material-icons"><?php echo lang('btn_menu'); ?></i></a>
                <ul id="nav-dashboard" class="right hide-on-med-and-down">
                    <li><a href="<?php echo base_url('account'); ?>" class="waves-light waves-effect p-r-5 p-l-5"><i class="tiny material-icons">settings</i></a></li>
                    <li><a href="#" class="waves-light waves-effect p-r-5 p-l-5"><i class="tiny material-icons">help</i></a></li>
                    <li class="blue accent-2"><a id="close-session" href="<?php echo base_url('account/logout'); ?>" class="btn blue accent-4 waves-light waves-effect"><?php echo lang('btn_cerrar_sesion'); ?></a></li>
                </ul>
                <ul id="mobile-demo" class="side-nav">
                    <li><a href="<?php echo base_url('account'); ?>"><i class="tiny material-icons">settings</i> Mi cuenta</a></li>
                    <li><a href="#"><i class="tiny material-icons">help</i> Ayuda</a></li>
                    <li><a href="<?php echo base_url('account/logout'); ?>"><?php echo lang('btn_cerrar_sesion'); ?></a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="row blue accent-3">
    <div class="container">
        <nav class="nav-secundary">
            <ul class="nomargin left">
                <li><a href="<?php echo base_url('administration/members'); ?>"><?php echo lang('menu_members'); ?></a></li>
                <li><a href="#"><?php echo lang('menu_enterprises'); ?></a></li>
            </ul>
        </nav>

        <div class="clearfix"></div>
    </div>
</div>