<link rel="stylesheet" href="<?php echo base_url('assets/css/hcolumns.css'); ?>">
<style type="text/css">
    .column-view-container { width: 100%; }
    .collection .collection-item.active { background-color: #40A5FD; }
    .card-profile { height: 300px; width: 250px; }
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

        var title = '<div class="left"><a href="#">Info</a></div><div class="right"><a class="valign-wrapper" href="#"><img src="<?php echo base_url("assets/images/flow_link.png") ?>" alt="flow link"></a></div><div class="clearfix"></div>';
        $main_column.find('.card .card-header').html( title );
    }

    function unloadProfile(){
        $('.box-profile').remove();
    }

    function loadProfile( id ){
        var ColumnElm = $('<div></div>').addClass("column col s12 m3");

        var card = $('<div></div>').addClass('card panel partial nopadding');
        var cardTitle = '<div class="left">'+ id +'</div><div class="clearfix"></div>';
        var cardHeader = $('<div></div>').addClass('card-header grey lighten-4 p-t-5 p-l-10 p-b-5 p-r-10').html(cardTitle);

        var link = '<div class="center-align"><a class="btn blue accent-4 waves-light waves-effect" href="<?php echo base_url("organigrama/perfil-"); ?>'+ id +'"><?php echo lang("btn_entrar_perfil"); ?></a></div>';

        var cardContent = $('<div></div>').addClass('card-content card-profile').html(link);

        card.append(cardHeader);
        card.append(cardContent);

        ColumnElm.append(card);
        $('#columns').find(".column-view-composition").append(ColumnElm);
        $('#columns').scrollLeft($(".column-view-composition").width());
    }
</script>