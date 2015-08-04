<div class="container main-content">
    <div class="row">

        <?php /* CARD - USER INFO */ ?>
        <div class="col s12 m2 l2">
            <div class="card card-panel profile hoverable">
                <div class="row">
                    <div class="col s12 m12 l12 center-align">
                        <?php if( isset($this->session->avatar) ) : ?>
                        <img src="<?php echo base_url('assets/images/profiles/'. $this->session->avatar); ?>" alt="Avatar" class="profile-pic responsive-img circle">
                        <?php else : ?>
                        <?php endif; ?>
                    </div>
                </div>
                <p class="user-name center-align blue-grey-text text-darken-4"><?php echo $this->session->full_name; ?></p>
                <div class="divider"></div>

                <p class="user-address blue-grey-text text-darken-1">
                    <i class="tiny material-icons blue-grey-text text-darken-1">location_on</i>
                </p>
                <p class="user-phone blue-grey-text text-darken-1">
                    <i class="tiny material-icons blue-grey-text text-darken-1">smartphone</i>
                </p>
                <a href="#" class="terms-conditions blue-grey-text text-darken-1"><?php echo lang('btn_terminos_y_condiciones'); ?></a>
            </div>
        </div>

        <div class="col s12 m7 l7">
            <div class="row">
                <?php //echo var_dump($path_view); ?>
                <?php if( isset( $path_view) ) $this->load->view($path_view); ?>
            </div>
        </div>

        <div class="col s12 m3 l3">
            <div class="row">
                <?php /* CARD - ORGANIGRAMAS PUBLICOS */ ?>
                <div class="col s12 m12 l12">
                    <div class="card small sector hoverable">
                        <div class="card-content">
                            <p class="card-title blue-grey-text text-darken-4"><?php echo lang('card-organigramas-publicos-title'); ?></p>
                            <p class="card-description blue-grey-text text-darken-1"><?php echo lang('card-organigramas-publicos-desc'); ?></p>
                        </div>
                        <div class="card-action">

                        </div>
                    </div>
                </div>

                <?php /* CARD - ORGANIGRAMAS PRIVADOS */ ?>
                <div class="col s12 m12 l12">
                    <div class="card small sector hoverable">
                        <div class="card-content">
                            <p class="card-title blue-grey-text text-darken-4"><?php echo lang('card-organigramas-privados-title'); ?></p>
                            <p class="card-description blue-grey-text text-darken-1"><?php echo lang('card-organigramas-privados-desc'); ?></p>
                        </div>
                        <div class="card-action">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>