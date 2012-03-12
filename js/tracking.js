jQuery(document).ready(function($) {
    
    /***
    Click events are configured by adding an array of objects to the window
    object called `_clickEvents`. The included objects should include attributes
    called `selector` that jQuery can use to find the elements you're tracking,
    plus a `category` used by Google Analytics to namespace events.
    
    For example:
        var _clickEvents = [
            {category: 'a.trackme', category: 'Links I want to track'}
        ]
    
    ***/
    var events = window._clickEvents || [];
    
    $.each(events, function(i) {
        var selector = this.selector,
            category = this.category;
        
        $(selector).each(function(i) {
            var trackArray = [
                '_trackEvent',
                category,
                $(this).text()
            ];
            
            $(this).click(function(e) {
                _gaq.push(trackArray);
            });
        });
    });
});