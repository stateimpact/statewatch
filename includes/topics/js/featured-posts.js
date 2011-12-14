(function($) {
    
    Backbone.sync = function(method, model, options) {
        var actions = {
            'create': 'save_featured_posts',
            'update': 'save_featured_posts',
            'read'  : 'get_posts_for_topic'
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
    
    window.StoryList = Backbone.Collection.extend({
        
        model: Story,
        
        url: window.ajaxurl,
        
        initialize: function(models, options) {
            if (options) {
                this.name = options.name || "latest";
            } else {
                this.name = "latest";
            }
            this.view = new StoryListView({ collection: this });
            
            return this;
        },
        
        comparator: function(story) {
            if (this.name = "latest") {
                return Date.parse(story.get('date'));
            } else {
                return this.order;
            }
        }
    });
    
    
    var StoryView = Backbone.View.extend({
        className: "story",
        
        events: {
            'click a.toggle' : 'toggleStory'
        },
                
        initialize: function(options) {
            _.bindAll(this);
            this.template = _.template( $('#story-template').html() );
            
            return this.render();
        },
        
        render: function() {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        },
        
        toggleStory: function(e) {
            e.preventDefault();
            var story = this.model;
            if (story.collection.name === "latest") {
                story.collection.remove(story);
                window.featuredstories.featured.add(story);
            } else {
                story.collection.remove(story);
                window.featuredstories.latest.add(story);
            }
        }
        
    });
    
    var StoryListView = Backbone.View.extend({
        
        initialize: function(options) {
            _.bindAll(this);
            this.el = $('#' + this.collection.name);
            this.collection.bind('reset', this.render);
            this.collection.bind('add', this.addStory);
            
            var that = this;
            if (this.collection.name === "featured") {
                var el = $(this.el);
                el.sortable({
                    cursor: 'pointer',
                    update: function(event, ui) {
                        el.children('div.story').each(function(i) {
                            var id = $(this).find('a.toggle').attr('id');
                            var story = that.collection.get(id);
                            story.set({ order: i });
                        });
                        window.featuredstories.save();
                    }
                });
            }
            
        },
        
        render: function() {
            var el = this.el;
            $(el).empty();
            this.collection.each(function(story, i, stories) {
                $(el).append(story.view.el);
            });
        },
        
        addStory: function(link) {
            $(this.el).append(link.view.el);
        }
        
    });
    
    window.FeaturedStories = Backbone.View.extend({
        
        el: "#featured-posts",
        
        events: {
            'click input.button' : 'search',
            'keyup input.search' : 'search',
            'focus input.search' : 'disableSubmit',
            'blur  input.search' : 'enableSubmit'
        },
        
        initialize: function(options) {
            _.bindAll(this);
            this.post_parent = options.post_parent;
            if (this.post_parent) {
                this.latest = new StoryList([], { name: 'latest' });
                this.latest.fetch({ data: 
                    { post_parent: this.post_parent, action: 'get_posts_for_topic' }
                });
                    
                this.featured = new StoryList([], { name: 'featured' });
                this.featured.fetch({ data: 
                    { post_parent: this.post_parent, action: 'get_featured_posts_for_topic' }
                });
            }
            
            $('form').submit(this.save);
            return this;
        },
        
        disabler: function(e) { e.preventDefault(); },
        
        disableSubmit: function(e) {
            $('form').bind('submit', this.disabler);
        },
        
        enableSubmit: function(e) {
            $('form').unbind('submit', this.disabler);
        },
        
        search: function(e) {
            var query = this.$('input.search').val();
            if (query.length > 3) {
                this.latest.fetch({ 
                    data: {
                        s: query,
                        post_parent: this.post_parent,
                        action: 'get_posts_for_topic'
                    }
                });
            } else if (query.length == 0) {
                this.latest.fetch({
                    data: { post_parent: this.post_parent }
                });
            }
            return this;
        },
        
        save: function() {
            var data = {
                featured_posts: this.featured.pluck('id'),
                post_parent: this.post_parent,
                action: 'save_featured_posts'
            }
            
            $.ajax({ 
                url: window.ajaxurl,
                type: 'POST',
                data: data,
                success: function(resp) {
                    console.log(resp);
                }
            });
            return this;
        }
        
    });
    

})(window.jQuery);