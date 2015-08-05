<div class="navbar-fixed">
    <nav class="blue">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?php echo base_url('panel'); ?>" class="brand-logo"><img src="<?php echo base_url('assets/images/logo-white.png'); ?>" alt=""></a>
                <a href="#" data-activates="mobile-demo" class="button-collapse right"><i class="material-icons"><?php echo lang('btn_menu'); ?></i></a>
                <ul id="nav-dashboard" class="right hide-on-med-and-down">
                    <li class="account"><a href="<?php echo base_url('account'); ?>" class="waves-light waves-effect p-r-5 p-l-5">
                    <p class="user-name">
                    <span>
                    <?php echo $this->session->full_name; ?>
                    </span>
                    <?php
                            $avatar = $this->session->avatar;
                            if( isset($avatar) and $avatar != '' ) : ?>
                        <img src="<?php echo base_url('assets/images/profiles/'. $avatar); ?>" alt="Avatar" class="profile-pic responsive-img circle">
                        <?php else : ?>
                        <?php endif; ?>
                        </p>
                    </a></li>
                    <li><a href="<?php echo base_url('account'); ?>" class="waves-light waves-effect p-r-5 p-l-5"><i class="tiny material-icons">forum</i></a></li>
                    <li><a href="<?php echo base_url('account'); ?>" class="waves-light waves-effect p-r-5 p-l-5"><i class="tiny material-icons">notifications</i></a></li>
                    <li><a href="<?php echo base_url('account'); ?>" class="waves-light waves-effect p-r-5 p-l-5"><i class="tiny material-icons">settings</i></a></li>
                    <li><a href="#" class="waves-light waves-effect p-r-5 p-l-5"><i class="tiny material-icons">help</i></a></li>
                    <li class="blue"><a id="close-session" href="<?php echo base_url('account/logout'); ?>" class="btn blue accent-4 waves-light waves-effect"><?php echo lang('btn_cerrar_sesion'); ?></a></li>
                </ul>
                <ul id="mobile-demo" class="side-nav">
                    <li><a href="<?php echo base_url('account'); ?>"><i class="tiny material-icons">forum</i></a></li>
                    <li><a href="<?php echo base_url('account'); ?>"><i class="tiny material-icons">notifications</i></a></li>
                    <li><a href="<?php echo base_url('account'); ?>"><i class="tiny material-icons">settings</i></a></li>
                    <li><a href="#"><i class="tiny material-icons">help</i></a></li>
                    <li><a href="<?php echo base_url('account/logout'); ?>"><?php echo lang('btn_cerrar_sesion'); ?></a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="row light-blue">
    <div class="container">
        <nav class="nav-secundary">
            <ul class="nomargin left">
                <li><a href="<?php echo base_url('administration'); ?>"><?php echo lang('dashboard'); ?></a></li>
            </ul>
        </nav>

        <div class="clearfix"></div>
    </div>
</div>