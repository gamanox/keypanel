<link rel="stylesheet" href="<?php echo base_url('assets/css/hcolumns.css'); ?>">
<style type="text/css">
    .column-view-container { width: 100%; }
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

        var title = '<div class="left"><a href="#">Info</a></div><div class="right"><a href="#"><img src="<?php echo base_url("assets/images/flow_link.png") ?>" alt="flow link"></a></div><div class="clearfix"></div>';
        $main_column.find('.card .card-header').html( title );
    }

    function loadProfile( id ){

    }
</script>