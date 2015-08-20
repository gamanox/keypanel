<link rel="stylesheet" href="<?php echo base_url('assets/css/hcolumns.css'); ?>">
<style type="text/css">
    .column-view-container { width: 100%; }
    .collection .collection-item.active { background-color: #40A5FD; }
    .card-profile { height: 400px; width: 250px; }
    .column { vertical-align: top; }
    .column ul li i { margin-top: -20px; }
</style>
<div class="container main-content">
    <?php //echo '<pre>'. print_r($organigrama, true) .'</pre>'; ?>
    <h5 class="light"><?php echo $organigrama->name; ?></h5>
    <div id="columns"></div>
</div>
<script src="<?php echo base_url('assets/js/hcolumns.js'); ?>"></script>
<script>
    $(document).ready(function() {
        var nodes;
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("organigrama/find_nodes"); ?>',
            data: { id_organigrama: <?php echo $organigrama->id; ?>},
            dataType: 'json',
            beforeSend:function(){},
            complete:function(){},
            success:function(response) {
                nodes = response;
                $("#columns").hColumns({
                    labelText_maxLength: 30,

                    nodeSource: function(node_id, callback) {
                        if(node_id === null) {
                            node_id = 0;
                        }

                        if( !(node_id in nodes) ) {
                            return callback("Node not exists");
                        }

                        return callback(null, nodes[node_id]);
                    }
                });
            }
        });

        setTimeout( function(){
            loadInfo();
        }, 500);
    });

    function loadInfo(){
        var $main_column = $('#columns').find('.column').first();

        var title = '<div class="left"><p class="card-title nomargin nopadding"><a class="black-text" href="#">Info</a></p></div><div class="right"><a class="valign-wrapper" href="#"><img src="<?php echo base_url("assets/images/flow_link.png") ?>" alt="flow link"></a></div><div class="clearfix"></div>';
        $main_column.find('.card .card-header').html( title );
    }

    function unloadProfile(){
        $('.box-profile').remove();
    }

    function loadProfile( id ){
        var ColumnElm = $('<div></div>').addClass("column col s12 m3");

        var card = $('<div></div>').addClass('card panel partial nopadding');
        var cardTitle = '<div class="left"><p class="card-title nomargin nopadding">&nbsp;</p></div><div class="clearfix"></div>';
        var cardHeader = $('<div></div>').addClass('card-header grey lighten-4 p-t-10 p-l-10 p-b-10 p-r-10').html(cardTitle);

        card.append(cardHeader);
        var cardContent = $('<div></div>').addClass('card-content card-profile').html('');

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("profile/preview"); ?>',
            data: { id_profile: id },
            dataType: 'jsonp',
            beforeSend:function(){},
            complete:function(){},
            success:function(response) {
                console.log(response);
                if( response.status ){
                    // Profile picture
                    var profile = response.profile;
                    if( profile.avatar != null ){
                        var url = '<?php echo base_url("assets/images/profiles"); ?>';
                        cardContent.append('<div class="col s12 m12 l12 center-align"><img src="'+ url +'/'+ profile.avatar +'" alt="Avatar" class="profile-pic responsive-img circle"></div>');
                    }

                    // Full name
                    cardContent.append('<div class="center-align p-b-10">'+ profile.full_name +'</div>');

                    // Bio
                    if( profile.contact != null){
                        var bio = profile.contact.bio;
                        if( bio != null ){
                            cardContent.append('<div class="col s12 m-t-10 p-t-10 p-b-10"><p class="light" style="white-space: normal !important;">'+ bio.substr(1,90) +'...</p></div>');
                        }
                    }

                    // Divider
                    cardContent.append('<div class="clearfix"></div>');

                    // RRSS
                    if( profile.contact != null){
                        cardContent.append('<div class="divider"></div>');
                        var rrss = '';
                        // FB
                        if( profile.contact.facebook != null ){
                            rrss += '<a href="'+ profile.contact.facebook +'" target="_blank" class="fb" title="Facebook"></a>';
                        }

                        if( profile.contact.twitter != null ){
                            rrss += '<a href="'+ profile.contact.twitter +'" target="_blank" class="tw" title="Twitter"></a>';
                        }

                        if( profile.contact.email_personal != null ){
                            rrss += '<a href="mailto:'+ profile.contact.email_personal +'" class="mail" title="Email"></a>';
                        }

                        cardContent.append( '<div class="center-align p-t-10 p-b-10">'+ rrss +'</div>' );
                    }

                    // Related
                    // cardContent.append('<div class="divider"></div>');

                    // Link
                    cardContent.append('<div class="divider"></div>');
                    cardContent.append('<div class="center-align p-t-20"><a class="btn blue accent-4 waves-light waves-effect" href="<?php echo base_url("organigrama/perfil-"); ?>'+ id +'"><?php echo lang("btn_entrar_perfil"); ?></a></div>');
                }
            }
        });

        card.append(cardContent);

        ColumnElm.append(card);
        $('#columns').find(".column-view-composition").append(ColumnElm);
        $('#columns').scrollLeft($(".column-view-composition").width());
    }
</script>