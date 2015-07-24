<div class="container main-content">
    <div class="row">
        
        <?php /* CARD - USER INFO */ ?>
        <div class="col s12 m2 l2">
            <div class="card profile hoverable">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 m12 l12 center-align">
                            <img src="<?php echo base_url('assets/images/profile-pic.png'); ?>" alt="Avatar" class="profile-pic responsive-img circle">
                        </div>
                    </div>
                    <p class="user-name center-align blue-grey-text text-darken-4"><?php echo $this->session->first_name; ?></p>

                </div>
            </div>
        </div>

        <div class="col s12 m7 l7">
            <div class="row">
                <div class="col s12 m7 l7">
                    <div class="row">
                        <?php /* CARD - NOTICIAS */ ?>
                        <div class="col s12 m12 l12">
                            <div class="card card-middle small">
                                <div class="card-content">
                                    <p class="card-title blue-grey-text text-darken-4">
                                        <i class="tiny material-icons">question_answer</i><?php echo lang('card-noticias-title'); ?>
                                    </p>
                                </div>
                                <div class="card-action">
                                    
                                </div>
                            </div>
                        </div>

                        <?php /* CARD - ACTUALIZACIONES */ ?>
                        <div class="col s12 m12 l12">
                            <div class="card card-middle small">
                                <div class="card-content">
                                    <p class="card-title blue-grey-text text-darken-4">
                                        <i class="tiny material-icons">notifications</i><?php echo lang('card-actualizaciones-title'); ?>
                                    </p>    
                                </div>
                                <div class="card-action">
                                    
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>

                <div class="col s12 m5 l5">
                    <div class="row">
                        <?php /* CARD - HISTORIAL */ ?>
                        <div class="col s12 m12 l12">
                            <div class="card card-middle small">
                                <div class="card-content">
                                    <p class="card-title blue-grey-text text-darken-4">
                                        <i class="tiny material-icons">restore</i><?php echo lang('card-historial-title'); ?>
                                    </p>    
                                </div>
                                <div class="card-action">
                                    
                                </div>
                            </div>
                        </div> 

                        <?php /* CARD - TENDENCIAS */ ?>
                        <div class="col s12 m12 l12">
                            <div class="card card-middle small">
                                <div class="card-content">
                                    <p class="card-title blue-grey-text text-darken-4">
                                        <i class="tiny material-icons">local_offer</i><?php echo lang('card-tendencias-title'); ?>
                                    </p>                    
                                </div>
                                <div class="card-action">
                                    
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>                

        <div class="col s12 m3 l3">
            <div class="row">
                <?php /* CARD - ORGANIGRAMAS PUBLICOS */ ?>
                <div class="col s12 m12 l12">
                    <div class="card small sector hoverable">
                        <div class="card-content">
                            <p class="card-title blue-grey-text text-darken-4"><?php echo lang('card-organigramas-publicos-title'); ?></p>
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
                        </div>
                        <div class="card-action">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>