(function($) {
    var _gaq = window._gaq || [];
    
    // facebook
    if (FB && FB.Event) {
        FB.Event.subscribe('edge.create',
            function(url) {
                _gaq.push(['_trackSocial', 'Facebook', 'Like', url]); 
            }
        );
    }
    
    // twitter
    if (twttr) {
        twttr.ready(function(twttr) {
            twttr.events.bind('tweet', function(event) {
                _gaq.push(['_trackSocial', 'Twitter', event.type]); 
            });
        });
    }
    
    // state name custom var
    if (SI_STATE_NAME) {
        _gaq.push(['_setCustomVar', 1, 'State', SI_STATE_NAME, 3]);
    }
})(window.jQuery);