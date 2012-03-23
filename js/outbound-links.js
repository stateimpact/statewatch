jQuery(document).ready(function() {

    jQuery('a').each(function() {
        var a = jQuery(this);
        var href = a.attr('href');

        // Check if the a tag has a href, if not, stop for the current link
        if (href == undefined) {
            return;
        }

        var url = href.replace('http://', '').replace('https://', '');
        var hrefArray = href.split('.').reverse();
        var extension = hrefArray[0].toLowerCase();
        var hrefArray = href.split('/').reverse();
        var domain = hrefArray[2];
        var downloadTracked = false;

        // If the link is a download
        if (jQuery.inArray(extension, NavisAnalyticsFileTypes) != -1) {
            // Mark the link as already tracked
            downloadTracked = true;

            // Add the tracking code
            a.click(function() {
                _gaq.push(['_trackEvent', 'Downloads', extension.toUpperCase(), href]);
            });
        }

        // Remaining external links
        if ((href.match(/^http/)) && (!href.match(document.domain)) && (downloadTracked == false) ) {
        
        	if (jQuery(this).is(".roundup a")) {
        		// Add the tracking code
            	a.click(function() {
                _gaq.push(['_trackEvent', 'link roundup', href.match(/:\/\/(.[^/]+)/)[1], href]);
            	});
            } else if (jQuery(this).is(".link-list a")) {
            	// latest links module
            	a.click(function() {
                _gaq.push(['_trackEvent', 'latest links', href.match(/:\/\/(.[^/]+)/)[1], href]);
            	});
            } else {
            	// all remaining outbound links
            	a.click(function() {
                _gaq.push(['_trackEvent', 'Outbound Traffic', href.match(/:\/\/(.[^/]+)/)[1], href]);
            	});
            }
        }

    });

});