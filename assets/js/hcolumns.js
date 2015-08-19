// hColumns by bu <bu@hax4.in>, BSD License

(function($) {
    var defaultConfig = {
        nodeSource: function() {
            return window.alert("dummy source, you need to create a node source")
        },
        noContentString: "There is no node here",
        labelText_maxLength: 15,
        customNodeTypeIndicator: {},
        customNodeTypeHandler: {}
    };
    var defaultHandler = {
        folder: function(hColumn, node, data) {
            var column_label = data.label;

            hColumn.nodeSource(data.id, function(err, data) {
                if (err) {
                    return $.error(err)
                }
                return hColumn.columnView._addColumnList(data, hColumn.columnView, column_label);
            })
        },
        link: function(hColumn, node, data) {
            loadProfile( data.id );
            // return window.open(data.url)
        }
    };
    var defaultIndicator = {
        folder: "chevron_right",
        link: "account_circle"
    };
    var methods = {
        init: function(options) {
            var settings = $.extend(defaultConfig, options);
            var handlers = $.extend(defaultHandler, settings.customNodeTypeHandler);
            var indicators = $.extend(defaultIndicator, settings.customNodeTypeIndicator);
            return this.each(function() {
                var self = $(this),
                    data = self.data("columnView");
                methods.settings = settings;
                settings.columnView = methods;
                settings.handlers = handlers;
                settings.indicators = indicators;
                settings.container_node = this;
                if (!data) {
                    self.data("hColumn", settings);
                    self.addClass("column-view-container");
                    $("<div></div>").addClass("column-view-composition").appendTo(self);
                    self.on("click", ".column ul li", settings.columnView._entryClick);
                    settings.nodeSource(null, function(err, data) {
                        if (err) {
                            return $.error(err)
                        }
                        return settings.columnView._addColumnList(data)
                    })
                }
            })
        },
        _entryClick: function() {
            var columnView = $(this).parents(".column-view-container").data("hColumn");
            var current_container = $(this).parents(".column-view-container");
            var current_click_column = $(this).parents(".column");
            var current_click_level = $(this).parents(".column").index();
            var current_node_type = $(this).data("node-type");
            var current_node_data = $(this).data("node-data");
            $(current_container).find(".column-view-composition .column:gt(" + current_click_level + ")").remove();
            current_click_column.find(".active").removeClass("active");
            $(this).addClass("active");
            return columnView.handlers[current_node_type](columnView, this, current_node_data)
        },
        _addColumnList: function(list, columnView, title_column) {
            var title_column = !title_column ? 'Title' : title_column;
            var self = !columnView ? this : columnView;
            var ListElm = $("<ul></ul>").addClass('collection');
            if (list.length === 0) {
                var NoContentElm = $("<p></p>").text(columnView.settings.noContentString);
                return self._addColumn(NoContentElm, self)
            }
            list.map(function(entry) {
                var EntryElm = $("<li></li>").addClass('collection-item').data("node-id", entry.id).data("node-type", entry.type).data("node-data", entry);
                var EntryIconElm = $("<i></i>").addClass('tiny material-icons').html(self.settings.indicators[entry.type]);
                if (entry.label.length > self.settings.labelText_maxLength) {
                    entry.label = entry.label.substring(0, self.settings.labelText_maxLength - 5) + "..."
                }

                if( entry.type == 'link' ){
                    var node_label = '<a class="loadProfile" href="javascript:;">'+ entry.label +'</a>';
                }
                else {
                    var node_label = document.createTextNode(entry.label);
                }

                EntryElm.append(node_label);
                EntryElm.append(EntryIconElm);
                EntryElm.appendTo(ListElm)
            });

            return self._addColumn(ListElm, self, title_column);
        },
        _addColumn: function(content_dom_node, columnView, title_column) {

            var ColumnElm = $("<div></div>").addClass("column col s12 m3");

            var card = $('<div></div>').addClass('card panel partial nopadding');
            var cardTitle = '<div class="left">'+ title_column +'</div><div class="clearfix"></div>';
            var cardHeader = $('<div></div>').addClass('card-header grey lighten-4 p-t-5 p-l-10 p-b-5 p-r-10').html(cardTitle);

            var cardContent = $('<div></div>').addClass('card-content nopadding');
            cardContent.append(content_dom_node);

            card.append(cardHeader);
            card.append(cardContent);

            ColumnElm.append(card);
            $(columnView.settings.container_node).find(".column-view-composition").append(ColumnElm);
            $(columnView.settings.container_node).scrollLeft($(".column-view-composition").width())
        }
    };
    $.fn.hColumns = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1))
        } else if (typeof method === "object" || !method) {
            return methods.init.apply(this, arguments)
        } else {
            $.error("Method " + method + " does not exist on jQuery.hColumns")
        }
    }
})(jQuery);
