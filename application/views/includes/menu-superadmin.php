<div class="navbar-fixed">
    <nav class="blue">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?php echo base_url('admin/panel'); ?>" class="brand-logo"><img src="<?php echo base_url('assets/images/logo-white.png'); ?>" alt=""></a>
                <a href="#" data-activates="mobile-demo" class="button-collapse left"><i class="material-icons"><?php echo lang('btn_menu'); ?></i></a>
                <ul id="nav-dashboard" class="right hide-on-med-and-down">
                    <li><a href="<?php echo base_url('admin/category'); ?>" class="waves-light waves-effect p-r-5 p-l-5"><i class="tiny material-icons">folder</i><span><?php echo lang('menu-categories'); ?></a></span></li>
                    <li><a href="<?php echo base_url('admin/organigrama'); ?>" class="waves-light waves-effect p-r-5 p-l-5"><i class="tiny material-icons">device_hub</i><span><?php echo lang('menu-organization'); ?></a></span></li>
                    <li><a href="<?php echo base_url('admin/member'); ?>"><i class="tiny material-icons">person</i><span><?php echo lang('menu-members'); ?></span></a></li>
                    <li><a href="<?php echo base_url('admin/news'); ?>"><i class="tiny material-icons">forum</i><span><?php echo lang('menu-news'); ?></span></a></li>
                    <li><a href="<?php echo base_url('admin/account'); ?>"><i class="tiny material-icons">settings</i><span><?php echo lang('menu-myaccount'); ?></span></a></li>
                    <li class="blue"><a id="close-session" href="<?php echo base_url('account/logout'); ?>" class="btn blue accent-4 waves-light waves-effect"><?php echo lang('btn_cerrar_sesion'); ?></a></li>
                </ul>

                <ul id="mobile-demo" class="side-nav">
                    <li><a href="<?php echo base_url('admin/category'); ?>" class="waves-light waves-effect p-r-5 p-l-5"><i class="tiny material-icons">folder</i><span><?php echo lang('menu-categories'); ?></a></span></li>
                    <li><a href="<?php echo base_url('admin/organigrama'); ?>" class="waves-light waves-effect p-r-5 p-l-5"><i class="tiny material-icons">device_hub</i><span><?php echo lang('menu-organization'); ?></a></span></li>
                    <li><a href="<?php echo base_url('admin/member'); ?>" class="waves-light waves-effect p-r-5 p-l-5"><i class="tiny material-icons">person</i><span><?php echo lang('menu-members'); ?></a></span></li>
                    <li><a href="<?php echo base_url('admin/news'); ?>"><i class="tiny material-icons">forum</i><span><?php echo lang('menu-news'); ?></a></span></li>
                    <li><a href="<?php echo base_url('admin/account'); ?>"><i class="tiny material-icons">settings</i><span><?php echo lang('menu-myaccount'); ?></a></span></li>
                    <li><a href="<?php echo base_url('account/logout'); ?>"><?php echo lang('btn_cerrar_sesion'); ?></a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>