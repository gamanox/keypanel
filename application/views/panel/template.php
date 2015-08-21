<div class="container main-content">
    <div class="row">

        <?php if( $this->session->type == MEMBER ) : ?>
        <?php /* CARD - USER INFO */ ?>
        <?php
            // echo var_dump($user_info);

            $contact   = $user_info->contact;
            $addresses = $user_info->addresses->row();
        ?>
        <div class="col s12 m2 l2">
            <div class="card card-panel profile hoverable">
                <?php
                    $avatar = $this->session->avatar;
                    if( isset($user_info->avatar) and $user_info->avatar != '' ) : ?>
                <div class="col s12 m12 l12 center-align"><img src="<?php echo base_url('assets/images/profiles/'. $user_info->avatar); ?>" alt="Avatar" class="profile-pic responsive-img circle"></div>
                <?php endif; ?>
                <p class="user-name center-align blue-grey-text text-darken-4"><?php echo $this->session->full_name; ?></p>

                <?php if( isset($contact)) : ?>
                <p class="user-bio center-align blue-grey-text text-darken-4"><?php echo substr($contact->bio, 0, 30) .' <a href="javascript:;">'. lang('read_more') .'</a>'; ?></p>
                <?php endif; ?>
                <div class="divider"></div>

                <?php /* SOCIAL LINKS */ ?>
                <?php if( isset($contact->facebook) and !empty($contact->facebook) ) :?>
                <a href="<?php echo $contact->facebook; ?>" target="_blank" class="fb" title="Facebook"></a>
                <?php endif; ?>

                <?php if( isset($contact->twitter) and !empty($contact->twitter) ) :?>
                <a href="<?php echo $contact->twitter; ?>" target="_blank" class="tw" title="Twitter"></a>
                <?php endif; ?>

                <?php if( isset($contact->email_personal) and !empty($contact->email_personal) ) :?>
                <a href="#" class="mail" title="Email"></a>
                <?php endif; ?>

                <div class="divider"></div>
                <?php if( isset($addresses)) : ?>
                <p class="user-address blue-grey-text text-darken-1">
                    <i class="tiny material-icons blue-grey-text text-darken-1">location_on</i>
                    <span><?php echo $addresses->street .' '. $addresses->num_ext .', '. $addresses->num_int .', '. $addresses->country;  ?></span>
                </p>
                <?php endif; ?>

                <?php if( isset($contact)) : ?>
                <p class="user-phone blue-grey-text text-darken-1">
                    <i class="tiny material-icons blue-grey-text text-darken-1">smartphone</i>
                    <?php if( isset($contact->phone_personal) and !empty($contact->phone_personal)) : ?>
                    <span><?php echo $contact->phone_personal; ?></span>
                    <?php endif; ?>

                    <?php if( isset($contact->phone_business) and !empty($contact->phone_business)) : ?>
                    <span><?php echo $contact->phone_business; ?></span>
                    <?php endif; ?>
                </p>
                <?php endif; ?>
                <a href="#" class="terms-conditions blue-grey-text text-darken-1"><?php echo lang('btn_terminos_y_condiciones'); ?></a>
            </div>
        </div>
        <?php endif; ?>

        <div class="col <?php echo ( $this->session->type == MEMBER ? 's12 m7 l7' : 's12 m9 l9' ); ?>">
            <div class="row">
                <?php
                    if( isset( $dynamic_view) ) {
                        $view_param = array();
                        foreach ($vars_to_load as $var) {
                            if( isset($$var) )
                                $view_param[$var] = $$var;
                        }

                        // echo '<pre>'. print_r($news, true) .'</pre>';
                        // echo '<pre>'. print_r($view_param, true) .'</pre>';
                        // echo '<pre>'. print_r($user_info, true) .'</pre>';

                        $this->load->view($dynamic_view, $view_param);
                    }
                ?>
            </div>
        </div>

        <div class="col s12 m3 l3">
            <div class="row">
                <?php /* CARD - ORGANIGRAMAS PUBLICOS */ ?>
                <div class="col s12 m12 l12">
                    <div class="card panel sector hoverable">
                        <div class="card-content">
                            <p class="card-title blue-grey-text text-darken-4"><?php echo lang('card-organigramas-publicos-title'); ?></p>
                            <p class="card-description blue-grey-text text-darken-1"><?php echo lang('card-organigramas-publicos-desc'); ?></p>
                            <div class="image"></div>
                        </div>
                        <div class="card-action no-padding">
                            <a href="<?php echo base_url('organigramas_publicos'); ?>" class="col s12 m12 l12 btn-large blue waves-effect waves-light"><?php echo strtoupper(lang('btn_entrar')); ?></a>
                        </div>
                    </div>
                </div>

                <?php /* CARD - ORGANIGRAMAS PRIVADOS */ ?>
                <div class="col s12 m12 l12">
                    <div class="card panel sector hoverable">
                        <div class="card-content">
                            <p class="card-title blue-grey-text text-darken-4"><?php echo lang('card-organigramas-privados-title'); ?></p>
                            <p class="card-description blue-grey-text text-darken-1"><?php echo lang('card-organigramas-privados-desc'); ?></p>
                            <div class="image"></div>
                        </div>
                        <div class="card-action no-padding">
                            <a href="<?php echo base_url('organigramas_privados'); ?>" class="col s12 m12 l12 btn-large blue waves-effect waves-light"><?php echo strtoupper(lang('btn_entrar')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>