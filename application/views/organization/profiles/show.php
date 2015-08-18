<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

print_r_pre($profile);
?>
<div class="container main-content">
    <div class="row">
        <?php /*CARD PROFILE*/; ?>
        <div class="col s12 m3">
            <div class="card card-panel profile hoverable">
                <?php if (isset($profile->avatar) and $profile->avatar != '') :?>
                    <div class="col s12 m12 l12 center-align"><img src="<?php echo base_url('assets/images/profiles/' . $profile->avatar); ?>" alt="Avatar" class="profile-pic responsive-img circle"></div>
                <?php endif; ?>
                <p class="user-name center-align blue-grey-text text-darken-4"><?php echo $profile->full_name; ?></p>

                <?php if (isset($profile->contact)) : ?>
                    <p class="user-bio center-align blue-grey-text text-darken-4"><?php echo substr($profile->contact->bio, 0, 30) . ' <a href="javascript:;">' . lang('read_more') . '</a>'; ?></p>
                <?php endif; ?>
                <div class="divider"></div>
            </div>
        </div>

        <?php /*CARD DESCRIPTION*/; ?>
        <div class="col s12 m5">
            <div class="card small partial hoverable">
                <div class="card-header">
                    <p class="card-title blue-grey-text text-darken-4 valign-wrapper"><i class="tiny material-icons valign">local_offer</i>&nbsp;<?php echo lang('description'); ?></p>
                </div>
                <div class="card-content">
                    <?php if (isset($profile->contact)) : ?>
                        <p class="user-bio center-align blue-grey-text text-darken-4"><?php echo $profile->contact->description; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php /* CARD TENDENCIAS */ ?>
        <div class="col s12 m4">
            <div class="card small partial hoverable">
                <div class="card-header">
                    <p class="card-title blue-grey-text text-darken-4 valign-wrapper"><i class="tiny material-icons valign">local_offer</i>&nbsp;<?php echo lang('org_related_tags'); ?></p>
                </div>
                <div class="card-content">
                    <?php foreach ($profile->tags->result() as $term): ?>
                    <span class="blue white-text trend"><?php echo $term->name; ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>