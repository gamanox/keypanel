<link rel="stylesheet" href="<?php echo base_url('assets/css/hcolumns.css'); ?>">
<style type="text/css">
    .column-view-container { width: 100%; }
</style>
<div class="container main-content">
    hello
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
                console.log(response);
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

        /*var nodes = {
            0: [
                { id: 1, label: "My Favorite Sites", type: "folder" },
                { id: 2, label: "Empty Folder", type: "folder"},
                { id: 3, label: "Direct link to Google", type: "link", url: "http://www.google.com"}
            ],

            1: [
                { id: 11, label: "Tech", type: "folder" },
                { id: 12, label: "Food", type: "folder" }
            ],

            11: [
                { id: 111, label: "PHP", type: "folder" },
                { id: 112, label: "Javascript", type: "folder" },
                { id: 113, label: "Hacker News", type:"link", url: "https://news.ycombinator.com/news" }
            ],

            12: [
                // empty node
            ],

            111: [
                { id: 1111, label: "PHP Engine", type: "folder" },
                { id: 1112, label: "PHP Extension", type: "folder" },
            ],

            112: [
                { id: 1121, label: "node.js", type: "link", url: "http://nodejs.org/" }
            ],

            1111: [
                { id: 11111, label: "PHP: Hypertext Preprocessor", type: "link", url: "http://php.net" }
            ],

            1112: [
                { id: 11121, label: "Twig", type: "link", url: "http://twig.sensiolabs.org/" }
            ],

            2: [
                // empty node
            ]
        };

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
        }); */
    });
</script>