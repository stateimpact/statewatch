(function($) {
    
    Backbone.sync = function(method, model, options) {
        var actions = {
            'create': 'save_related_content',
            'update': 'save_related_content',
            'read'  : 'fetch_related_content'
        };
        
        var data = options.data || {};
        if (!data.action) {
            data.action = actions[method];
        }
        
        _.extend(data, model.toJSON());
        
        if (!data.action) return;
        
        $.ajax({
            url: window.ajaxurl,
            type: 'POST',
            data: data,
            success: options.success,
            error: options.error
        });
    }
    
    var Story = Backbone.Model.extend({
        
        initialize: function(attributes, options) {
            this.view = new StoryView({ model: this });
            return this;
        },
        
        defaults: {
            title: "",
            permalink: "",
            type: "post",
            thumbnail: "",
            order: 0,
            post_date: null
        },
        
        url: window.ajaxurl
    });
    
    var StoryList = Backbone.Collection.extend({
        
        model: Story,
        
        url: window.ajaxurl,
        
        initialize: function(models, options) {
            this.name = options.name || "latest";
            return this;
        }
        
        comparator: function(story) {
            if (this.name = "latest") {
                return this.post_date;
            } else {
                return this.order;
            }
        }
    });
    
    
    var StoryView = Backbone.View.extend({
        classname: "story",
        
        events: {},
        
        initialize: function(options) {
            _.bindAll(this);
            return this.render();
        }
        
        render: function() {
            
            return this;
        }
    });
    
})(window.jQuery);