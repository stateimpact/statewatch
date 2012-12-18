function AddNamespace(namespacePath) {
	var rootObject = window;
	var namespaceParts = namespacePath.split('.');
	for (var i = 0; i < namespaceParts.length; i++) {
		var currentPart = namespaceParts[i];
		if (!rootObject[currentPart]) {
			rootObject[currentPart] = new Object();
		}
		rootObject = rootObject[currentPart];
	}
}
AddNamespace('STATEIMPACT.ServerConstants');
STATEIMPACT.ServerConstants.webHost = 'apps.NPR.org';
STATEIMPACT.ServerConstants.dfpServer = 'ad.doubleclick.net';
STATEIMPACT.ServerConstants.dfpNetwork = 'n6735';
STATEIMPACT.ServerConstants.dfpSite = 'NPR';

AddNamespace('STATEIMPACT.PageInfo');
STATEIMPACT.PageInfo.page = {};
STATEIMPACT.PageInfo.page.web_host = 'http://' + STATEIMPACT.ServerConstants.webHost;
STATEIMPACT.PageInfo.getUrlParameter = function (pname, pdefault) {
    try {
        pname = pname.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regexS = "[\\?&]" + pname + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(window.location.href);
        if (results === null) {
            return pdefault;
        } else {
            return results[1];
        }
    } catch (e) {
        // error
    }
};

AddNamespace('STATEIMPACT.Devices');
if ('ontouchstart' in document.documentElement) {
	var winWidth = window.innerWidth;
	if (winWidth >= 768 && winWidth <= 1024) {
		jQuery('html').addClass('NPRtablet');
	}
	if (winWidth <= 767) {
		jQuery('html').addClass('NPRphone');
	}
}
if (STATEIMPACT.PageInfo.getUrlParameter('device') == 'tablet') {
	jQuery('html').addClass('NPRtablet');
}
if (STATEIMPACT.PageInfo.getUrlParameter('device') == 'phone') {
	jQuery('html').addClass('NPRphone');
}
STATEIMPACT.Devices.isOnTablet = function () {
	if (jQuery('html').hasClass('NPRtablet')) {
		return true;
	} else {
		return false;
	}
};
STATEIMPACT.Devices.isOnPhone = function () {
	if (jQuery('html').hasClass('NPRphone')) {
		return true;
	} else {
		return false;
	}
};
jQuery(document).ready(function () {
	if (STATEIMPACT.Devices.isOnTablet()) {
		setTimeout(function () {
			jQuery('div[data-portrait]').each(function (index) {
				var newLocation = jQuery(this).attr('data-portrait');
				jQuery(this).children().not('script').clone().appendTo('#' + newLocation);
			});
		}, 500);
	}
});

var DFP = {};
DFP.tile = 0;
DFP.ord = Number(window.ord) || Math.floor(Math.random() * 1E10);

DFP.getParameterFromQueryString = function(strParamName) {
    var strReturn = "";
    var strHref = window.location.href;
    if ( strHref.indexOf("?") > -1 )
    {
        var strQueryString = strHref.substr(strHref.indexOf("?"));
        var aQueryString = strQueryString.split("&");
        for ( var iParam = 0; iParam < aQueryString.length; iParam++ )
        {
          if (aQueryString[iParam].indexOf(strParamName + "=") > -1 )
          {
            var aParam = aQueryString[iParam].split("=");
            strReturn = aParam[1];
            break;
          }
        }
    }
    return strReturn;
}

DFP.queryParameters = {sc: DFP.getParameterFromQueryString('sc'), ft: DFP.getParameterFromQueryString('ft')};

DFP.renderLocation = function(deviceEnv) {
    if (DFP.shouldRenderForDevice(deviceEnv)) {
        var scValue = '';
        var site = STATEIMPACT.serverVars.DFPsite;

        var size = '300x250';
        var sponsorshiptext = '<p class="left">NPR thanks our sponsors</p><p class="right"><a href="/about/place/corpsupport/">Become an NPR sponsor</a></p>';
        if (STATEIMPACT.Devices.isOnTablet()) {
            size = '2048x180';
            site = STATEIMPACT.serverVars.DFPmobile;
            sponsorshiptext = '';
        }
        else if (STATEIMPACT.Devices.isOnPhone()) {
            size = '640x100';
            site = STATEIMPACT.serverVars.DFPmobile;
            sponsorshiptext = '';
        }

        if (typeof DFP.queryParameters.sc === 'string' && DFP.queryParameters.sc.length > 0) {
            scValue = DFP.queryParameters.sc;
        }
        else if (typeof document.referrer === 'string' && document.referrer.search('facebook.com') > -1) {
            scValue = 'fb';
        }
        else if (typeof DFP.queryParameters.ft === 'string') {
            scValue = DFP.queryParameters.ft;
        }

        var orient = '';
        if (STATEIMPACT.Devices.isOnPhone() || STATEIMPACT.Devices.isOnTablet()) {
            if (window.orientation == 0 || window.orientation == 180) {
                orient = 'portrait';
            } else if (window.orientation == 90 || window.orientation == -90) {
                orient = 'landscape';
            }
            orient = 'portrait'; /* FOR TESTING */
        }

        DFP.target = 'http://' + STATEIMPACT.serverVars.DFPserver + '/adj/' + STATEIMPACT.serverVars.DFPnetwork + '.' + site + STATEIMPACT.serverVars.DFPtarget;

        var toRender = '<scr' + 'ipt src="'
            + DFP.target
            + ';sz=' + size
            + ';tile=' + (++DFP.tile)
            + ';sc=' + scValue
            + ';ord=' + DFP.ord
            + ';orient=' + orient
            + ';" type="text/javascript" language="javascript"></scr' + 'ipt>' + sponsorshiptext;

		//console.log(toRender);
		document.write(toRender);

        if (STATEIMPACT.Devices.isOnPhone()) {
            jQuery(document).ready(function() {
                jQuery(window).bind('orientationchange', DFP.hideAdsOnOrientationChange);
            });
        }
    }
}

DFP.render88 = function(deviceEnv) {
    DFP.target = 'http://' + STATEIMPACT.serverVars.DFPserver + '/adj/' + STATEIMPACT.serverVars.DFPnetwork + '.' + STATEIMPACT.serverVars.DFPsite + STATEIMPACT.serverVars.DFPtarget;

    var toRender = '<scr' + 'ipt src="'
        + DFP.target
        + ';sz=88x31'
        + ';tile=' + (++DFP.tile)
        + ';ord=' + DFP.ord
        + ';" type="text/javascript" language="javascript"></scr' + 'ipt>';

    document.write(toRender);
}

DFP.hideAdsOnOrientationChange = function() {
    if (window.orientation == 90 || window.orientation == -90) {
        jQuery('#adhesion').remove();
    }
}

DFP.shouldRenderForDevice = function(deviceEnv) {
    if (!deviceEnv) {
        return false;
    } else {
        var shouldRender = false;
        var winWidth = jQuery(window).width();
        var winOrientation = window.orientation;

        switch (deviceEnv) {
            case 'desktop':
                var ieEightCheck = (jQuery.browser.msie === true && (jQuery.browser.version === '7.0' || jQuery.browser.version === '8.0'));
                if (ieEightCheck) {
                    shouldRender = true;
                } else if (!STATEIMPACT.Devices.isOnTablet() && winWidth > 1024) {
                    shouldRender = true;
                }
                
                break;
            case 'mobile':
                if ((STATEIMPACT.Devices.isOnPhone() || STATEIMPACT.Devices.isOnTablet()) && winWidth >= 300 && winWidth <= 1024) {
                    // block ads from ever showing on small-screen mobile devices
                    if (winWidth >= 480 || winOrientation == 0 || winOrientation == 180) {
//                        if (document.cookie.indexOf('sponsorcap') === -1) {
                            shouldRender = true;
//                            DFP.setCookieVal();
//                        } else {
//                            shouldRender = false;
//                        }
                    }
                }
                break;
            default:
                break;
        }
		//console.log(deviceEnv + ' shouldRender: ' + shouldRender);
        return shouldRender;
    }
}

DFP.setCookieVal = function() {
    var date = new Date();
    date.setTime(date.getTime()+(60*1000));
    var expires = "; expires="+date.toGMTString();
    document.cookie = "sponsorcap=true"+expires+"; path=/";
}