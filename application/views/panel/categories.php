<style type="text/css">
    #chart { background: #F5F5F5; }
    text, h6.title { color: rgba(255,255,255,1); }
    text#info-title { fill: #FFF; stroke: #fff; font-size: 1.5em; font-weight: 300; }
    text#info-niveles, text#info-perfiles, text#info-link { fill: #FFF; stroke: #fff; font-weight: 300; }
    text#info-niveles, text#info-perfiles { font-size: 1.4em }
    text#info-link { font-size: 1em; }

    a.link { cursor: pointer; }
    .hidden { display: none; }
    .grandparent text { font-weight: 300; font-size: 1.2em; }

    rect { fill: none; stroke: #fff; }
    rect title { color: #fff; }

    rect.parent,
    .grandparent rect { stroke-width: 2px; stroke: #F5F5F5; }

    /*.grandparent rect { fill: #7db8fa; }
    .grandparent:hover rect { fill: #7db8fa; }*/

    .children rect.parent,
    .grandparent rect,
    .depth rect.parent { cursor: pointer; }
    .children rect.parent, .depth rect.parent { fill: #7db8fa; fill-opacity: .8; }
    .children:hover rect.child, .depth:hover rect.child { fill: #7db8fa; }
</style>
<div class="row">
    <div class="container main-content">
        <?php /*<h4><?php echo $categoria->name; ?></h4>*/?>
        <p id="chart"></p>
    </div>
</div>
<script src="<?php echo base_url('assets/js/d3.min.js'); ?>"  type="text/javascript"></script>
<script type="text/javascript">
    var margin = {top: 40, right: 0, bottom: 0, left: 0},
        width = $('.main-content').width(),
        height = 500 - margin.top - margin.bottom,
        formatNumber = d3.format(",d"),
        transitioning;

    var x = d3.scale.linear()
        .domain([0, width])
        .range([0, width]);

    var y = d3.scale.linear()
        .domain([0, height])
        .range([0, height]);

    function wordWrap(d, i){
        var words  = d.data.key.split(' ');
        var line   = new Array();
        var length = 0;
        var text   = "";
        var width  = d.dx;
        var height = d.dy;
        var word;
        do {
            word = words.shift();
            line.push(word);
            if (words.length)
                this.firstChild.data = line.join(' ') + " " + words[0];
            else
                this.firstChild.data = line.join(' ');

            length = this.getBBox().width;
            if (length < width && words.length) {
                ;
            }
            else {
                text = line.join(' ');
                this.firstChild.data = text;
                if (this.getBBox().width > width) {
                    text = d3.select(this).select(function() {return this.lastChild;}).text();
                    text = text + "...";
                    d3.select(this).select(function() {return this.lastChild;}).text(text);
                    d3.select(this).classed("wordwrapped", true);
                    break;
                }
                else
                    ;

                if (text != '') {
                    d3.select(this).append("svg:tspan")
                        .attr("x", 0)
                        .attr("dx", "0.15em")
                        .attr("dy", "0.9em")
                        .text(text);
                }
                else
                    ;

                if(this.getBBox().height > height && words.length) {
                    text = d3.select(this).select(function() {return this.lastChild;}).text();
                        text = text + "...";
                        d3.select(this).select(function() {return this.lastChild;}).text(text);
                            d3.select(this).classed("wordwrapped", true);
                            break;
                        }
                else
                    ;

                line = new Array();
            }
        } while (words.length);

        this.firstChild.data = '';
    }

    var treemap = d3.layout.treemap()
        .children(function(d, depth) { return depth ? null : d._children; })
        .sort(function(a, b) { return a.value - b.value; })
        .ratio(height / width * 0.5 * (1 + Math.sqrt(5)))
        .round(false)
        .value( function(d) { return d.value + 250; });

    var svg = d3.select("#chart").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.bottom + margin.top)
        .attr(':xmlns','http://www.w3.org/2000/svg')
        .attr(':xmlns:xlink','http://www.w3.org/1999/xlink')
        .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
            .style("shape-rendering", "crispEdges");

    var grandparent = svg.append("g")
        .attr("class", "grandparent");

    grandparent.append("rect")
        .attr("y", -margin.top )
        .attr("width", width)
        .attr("height", margin.top);

    grandparent.append("text")
        .attr("x", 6)
        .attr("y", 13 - margin.top)
        .attr("dy", ".75em");

    d3.json('<?php echo base_url("organigrama/getTreeJSON?id_category=". $categoria->id); ?>', function(error, root) {
        if (error) throw error;

        initialize(root);
        accumulate(root);
        layout(root);
        display(root);

        function initialize(root) {
            root.x     = root.y = 0;
            root.dx    = width;
            root.dy    = height;
            root.depth = 0;
        }

        // Aggregate the values for internal nodes. This is normally done by the
        // treemap layout, but not here because of our custom implementation.
        // We also take a snapshot of the original children (_children) to avoid
        // the children being overwritten when when layout is computed.
        function accumulate(d) {
            return (d._children = d.children)
                ? d.value = d.children.reduce(function(p, v) { return p + accumulate(v); }, 0)
                : d.value;
        }
        // function accumulate(d) {
        //     return d.children
        //         ? d.value = d.children.reduce(function(p, v) { return p + accumulate(v); }, 0)
        //         : d.value + d.count;
        // }

        // Compute the treemap layout recursively such that each group of siblings
        // uses the same size (1×1) rather than the dimensions of the parent cell.
        // This optimizes the layout for the current zoom state. Note that a wrapper
        // object is created for the parent node for each group of siblings so that
        // the parent’s dimensions are not discarded as we recurse. Since each group
        // of sibling was laid out in 1×1, we must rescale to fit using absolute
        // coordinates. This lets us use a viewport to zoom.
        function layout(d) {
            if (d._children) {
                treemap.nodes({_children: d._children});
                d._children.forEach(function(c) {
                    c.x = d.x + c.x * d.dx;
                    c.y = d.y + c.y * d.dy;
                    c.dx *= d.dx;
                    c.dy *= d.dy;
                    c.parent = d;
                    layout(c);
                });
            }
        }

        function display(d) {
            var base = "<?php echo base_url('organigrama/id-');?>";
            grandparent
                .datum(d.parent)
                .on("click", transition)
                .select("text")
                .text(name(d));

            var g1 = svg.insert("g", ".grandparent")
                .datum(d)
                .attr("class", "depth");

            var g = g1.selectAll("g")
                .data(d._children)
                .enter().append("g")
                .on("click", function(d) {
                    if( d.type == 'organigrama' )
                        window.location = base + d.slug;
                });

            g.filter(function(d) { return d._children; })
                .classed("children", true)
                .on("click", transition);

            g.selectAll(".child")
                .data(function(d) { return d._children || [d]; })
                .enter().append("rect")
                .attr("class", "child")
                .call(rect);

            g.append("rect")
                .attr("class", "parent")
                .call(rect)
                .append("title")
                .text(function(d) { return d.name; });

            g.append("text")
                .attr("dy", ".75em")
                .attr('id','info-title')
                .text(function(d) { return d.name; })
                .style("font-size", function(d) {
                    console.log( d.name +': '+ this.getComputedTextLength() +' '+ d.dx +' '+ d.x /*Math.min(10 * (d.x), (2 * (d.x) - 8) / this.getComputedTextLength())*/ ); /*return Math.min(2 * (d.dx - d.x), (2 * (d.dx - d.x) - 8) / this.getComputedTextLength() * 1) + "px";*/
                    if( this.getComputedTextLength() > d.dx){
                        return Math.min(2 * d.dx, (2 * d.dx - 8) / this.getComputedTextLength() * 10) + "px";
                    }
                    else
                        return '1.3em';
                })
                .call(text);
                

            g.append("a")
                .attr(':xlink:href', function(d) { return base + d.slug; })
                .attr('target','_top')
                .attr('class','link')
                .append("text")
                .attr("dy", ".75em")
                .attr('id','info-link')
                .text("<?php echo lang('d3_ver_organigrama'); ?>")
                .call(hyperlink);

            g.append("text")
                .attr("dy", ".75em")
                .attr('id','info-niveles')
                .attr('text-anchor','end')
                .text(function(d) {
                    return d.niveles + (d.niveles > 1 ? ' <?php echo lang("d3_niveles"); ?>' : ' <?php echo lang("d3_nivel"); ?>');
                })
                .call(niveles);

            g.append("text")
                .attr("dy", ".75em")
                .attr('id','info-perfiles')
                .attr('text-anchor','end')
                .text(function(d) {
                    if( typeof d.profiles === 'undefined' || d.profiles == 0)
                        return '<?php echo lang("d3_sin_perfiles"); ?>';
                    else
                        return d.profiles + (d.profiles == 1 ? ' <?php echo lang("d3_perfil"); ?>' : ' <?php echo lang("d3_perfiles"); ?>');
                })
                .call(perfiles);

            function transition(d) {
                if (transitioning || !d) return;
                transitioning = true;

                var g2 = display(d),
                t1 = g1.transition().duration(750),
                t2 = g2.transition().duration(750);

                // Update the domain only after entering new elements.
                x.domain([d.x, d.x + d.dx]);
                y.domain([d.y, d.y + d.dy]);

                // Enable anti-aliasing during the transition.
                svg.style("shape-rendering", null);

                // Draw child nodes on top of parent nodes.
                svg.selectAll(".depth").sort(function(a, b) { return a.depth - b.depth; });

                // Fade-in entering text.
                g2.selectAll("text").style("fill-opacity", 0);

                // Transition to the new view.
                t1.selectAll("text#info-title").call(text).style("fill-opacity", 0);
                t2.selectAll("text#info-title").call(text).style("fill-opacity", 1);

                t1.selectAll("text#info-link").call(hyperlink).style("fill-opacity", 0);
                t2.selectAll("text#info-link").call(hyperlink).style("fill-opacity", 1);

                t1.selectAll("text#info-niveles").call(niveles).style("fill-opacity", 0);
                t2.selectAll("text#info-niveles").call(niveles).style("fill-opacity", 1);

                t1.selectAll("text#info-perfiles").call(perfiles).style("fill-opacity", 0);
                t2.selectAll("text#info-perfiles").call(perfiles).style("fill-opacity", 1);

                t1.selectAll("rect").call(rect);
                t2.selectAll("rect").call(rect);

                // Remove the old node when the transition is finished.
                t1.remove().each("end", function() {
                    svg.style("shape-rendering", "crispEdges");
                    transitioning = false;
                });
            }

            return g;
        }

        function text(text) {
            text.attr("x", function(d) { return x(d.x) + 10; })
                .attr("y", function(d) { return y(d.y) + 10; })
                .attr("width", function(d) { return x(d.x + d.dx) - x(d.x) - 10; });
        }

        function hyperlink(text) {
            text.attr('class', function(d) { return (d.type == 'organigrama' ? 'visible' : 'hidden'); })
                .attr("x", function(d) { return x(d.x) + 10; })
                .attr("y", function(d) { return y(d.y) + 40; });
        }

        function niveles(text) {
            text.attr('class', function(d) { return ( typeof d.niveles === 'undefined' ? 'hidden' : 'visible' ); })
                .attr("x", function(d) { return x(d.dx + d.x) - 20; })
                .attr("y", function(d) { return y(d.dy + d.y) - 60; });
        }

        function perfiles(text) {
            text.attr("x", function(d) { return x(d.dx + d.x) - 20; })
                .attr("y", function(d) { return y(d.dy + d.y) - 35; });
        }

        function rect(rect) {
            rect.attr("x", function(d) { return x(d.x); })
                .attr("y", function(d) { return y(d.y); })
                .attr("width", function(d) { return x(d.x + d.dx) - x(d.x); })
                .attr("height", function(d) { return y(d.y + d.dy) - y(d.y); });
        }

        function name(d) {
            return d.parent
                ? name(d.parent) + ' > ' + d.name
                : d.name;
        }
    });
</script>