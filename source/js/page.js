/*
 * page.js
 *
 * Author: pixelcave
 *
 * Custom javascript code for TurboAdmin
 *
 */
/////////////////////////////////////////////////////////////////////////////////////////////


/*
 * Widget menu functionality
 * 
 */
$('ul#widget-menu li a.w-link').click(function(){
    
	var widget = $(this).next();
    
    // if this is an open widget close it
	if ($(this).hasClass('active') == true)
	{
		widget.hide();
		$(this).removeClass('active');

        // and remove opacity from the admin panel content (not in IE 8.0)
        if (!jQuery.browser.msie || (jQuery.browser.msie && jQuery.browser.version == 9.0))
            $('#panel-outer').fadeTo('50', 1);
	}
	else // else close the opened widget if exists and open this one
	{
		$('ul#widget-menu li a.w-link').removeClass('active');
		$(this).addClass('active');
		$('.widget').hide();
        
        // a small timeout for the widget transition
		setTimeout(function(){widget.fadeIn(50);}, 50);

        // fade out a little the admin panel content (except from IE 8.0, not working smoothly)
        if (!jQuery.browser.msie || (jQuery.browser.msie && jQuery.browser.version == 9.0))
            $('#panel-outer').fadeTo('50', 0.5);
	}

	return false;
});

/* This function closes all the widgets */
function close_widgets() {
    
    // remove all active classes from widget menu links and hide all the widgets
	$('ul#widget-menu li a.w-link').removeClass('active');
	$('.widget').hide();

    // restore opacity
    if (!jQuery.browser.msie || (jQuery.browser.msie && jQuery.browser.version == 9.0))
        $('#panel-outer').fadeTo('50', 1);
	
	return false;
}

/* Close widgets when a click made outside of them & widgets div */
$(document).click(function(e) {
    close_widgets();
});
$('#widgets').click(function(e) {
    e.stopPropagation();
});
$('.widget').click(function(e) {
    e.stopPropagation();
});
///////////////////////////////////////////////////////////////////////////////////////////////


/*
 * Layout handler, used for demo purposes of possible layouts TurboAdmin can have
 * 
 */
function layout_handler( obj, toclass )
{
    $('#sub-menu li a').removeClass('active');
    $(obj).addClass('active');
    
    if ( toclass == 'clear')
        $('body').removeClass();
    else
        $('body').removeClass().addClass( toclass );
}
///////////////////////////////////////////////////////////////////////////////////////////////


/*
 * Enable close on click to class 'enable-close'
 * 
 */
$(function(){
    var element = $('.enable-close');

    element.css('cursor', 'pointer');
    element.click( function(){$(this).hide()} );
});
///////////////////////////////////////////////////////////////////////////////////////////////

/*
 * Creates the image & file gallery hover menu
 * 
 */
$(function(){
    $('.image-gallery li').mouseenter(function(){
        $(this).find('div').stop(true, true).fadeIn('500');
    });
    
    $('.image-gallery li').mouseleave(function(){
        $(this).find('div').stop(true, true).hide();
    });
    
    $('.file-gallery li').mouseenter(function(){
        $(this).find('div').stop(true, true).fadeIn('500');
    });
    
    $('.file-gallery li').mouseleave(function(){
        $(this).find('div').stop(true, true).hide();
    });
});
///////////////////////////////////////////////////////////////////////////////////////////////


/*
 * Twitter widget functionality
 * 
 */

/* Updates status on Twitter */
function update_twitter()
{
    var mt = $('#twitter-status-update');
    var tweet = $('textarea#t-twitter-status').val();

    // if the textarea has some text in it
    if (tweet) {
        mt.fadeOut(100, function(){ // hide the message div
            mt.html('<div class="msg-loading">Updating..</div>'); // show loading ajax gif
            mt.fadeIn(100, function(){ // show the div again and let twitter.fn.php do its job (update status)
                mt.load("inc/twitter.fn.php", {tweet: "" + tweet + ""});
            });
        });
    }

    return false;
}

/* Retrieves recent tweets */
function get_tweets()
{
    var ts = $('#twitter-updates');
    var count = 5; // set the number of the tweets to be retrieved

    ts.fadeOut(100, function(){ // hide #twitter-updates div
        ts.html('<div class="msg-loading mar-none">Loading updates..</div>'); // show loading message
        ts.fadeIn(100, function(){ // show the div again and let twitter.fn.php do its job (retrieve tweets)
            ts.load("inc/twitter.fn.php", {get_tweets: count} );
        });
    });

    return false;
}
///////////////////////////////////////////////////////////////////////////////////////////////


/*
 * Initialize code
 * 
 */
$(function(){
    
    /* Initialize Twitter functionality */
    $('#t-btn').click(function(){update_twitter();});
    $('#load-twitter-updates').click(function(){get_tweets();});

    /* Initialize Limit, limit textarea of Twitter status message to 140 characters */
    $('#t-twitter-status').limit('140', '#t-twitter-limit');

    /* Initialize Elastic, auto expanding textareas */
    // Add the class 'elastic' to a textarea and it will auto expand if needed, as you write
    $('.elastic').elastic();
    
    /* Initialize Datatables */
    // Must happen before uniform initialization for the select boxes to be styled
    $('.datatable').dataTable({ "sPaginationType": "full_numbers", "bPaginate": true, "bLengthChange": true, "bFilter": true, "bSort": true, "bInfo": true, "bAutoWidth": true });

    /* Initialize Uniform, form styling */
    $('select').uniform();
    $('input:checkbox').uniform();
    $('input:radio').uniform();
    $('input:file').uniform();

    /* Initialize Datepicker */
    // Add the class 'datepicker' to a text input and it will be datepicker enabled
    // for advanced usage and customization you can check out the demos at http://jqueryui.com/demos/datepicker/
    $('.datepicker').datepicker();

    /* Initialize Autocomplete */
    // To its simplest form, you can create tables with values
    var availableTags = [ "ActionScript", "AppleScript", "Asp", "BASIC", "C", "C++", "Clojure", "COBOL", "ColdFusion", "Erlang", "Fortran", "Groovy", "Haskell", "Java", "JavaScript", "Lisp", "Perl", "PHP", "Python", "Ruby", "Scala", "Scheme" ];
    var availableUsernames = [ "John", "Mike", "Lisa", "Emma", "Chloe", "turboadminer", "turbomoder", "admin", "George" ];
    
    // and assign each to the input you want
    // for advanced usage and customization you can check out the demos at http://jqueryui.com/demos/autocomplete/
    $('#search-keyword').autocomplete({source: availableTags});
    $('#search-user').autocomplete({source: availableUsernames});
    $('#searchbig-users').autocomplete({source: availableUsernames});

    /* Initialize Tabs */
    // Check out the structure tabs need to have (eg sidebar tabs in the custom page) and initialize this way as many as you like
    $('#w-tabs-settings').tabify();
    $('#w-tabs-pm').tabify();
    $('#w-tabs-twitter').tabify();
    $('#c-tabs').tabify();
    $('#s-tabs').tabify();
    $('#main-tabs').tabify();

    /* Initialize Tooltip */
    // Add the corresponding class to an element (depending on the position you would like to show up)
    // 'tiptip-top', 'tiptip-right', 'tiptip-bottom', 'tiptip-left'
    // and the text you want to appear in the tooltip, in the title attribute of the same element
    $('.tiptip-top').tipTip({maxWidth: "auto", edgeOffset: 1, delay: 100, fadeIn: 200, fadeOut: 200, defaultPosition: "top"});
    $('.tiptip-right').tipTip({maxWidth: "auto", edgeOffset: 1, delay: 100, fadeIn: 200, fadeOut: 200, defaultPosition: "right"});
    $('.tiptip-bottom').tipTip({maxWidth: "auto", edgeOffset: 1, delay: 100, fadeIn: 200, fadeOut: 200, defaultPosition: "bottom"});
    $('.tiptip-left').tipTip({maxWidth: "auto", edgeOffset: 1, delay: 100, fadeIn: 200, fadeOut: 200, defaultPosition: "left"});
    
    /* Initialize Progress Bar */
    // for advanced usage and customization you can check out the demos at http://jqueryui.com/demos/progressbar/
    $( ".progressbar" ).progressbar({ value: Math.floor(Math.random()*101) });

    /* Initialize FullCalendar */
    // for advanced usage and customization you can check out the documentation at http://arshaw.com/fullcalendar/docs/
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#fullcalendar').fullCalendar({
        editable: true,
        header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
        events: [
            {
                title: 'All Day Event',
                start: new Date(y, m, 1)
            },
            {
                title: 'Long Event',
                start: new Date(y, m, d-5),
                end: new Date(y, m, d-2)
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d-3, 16, 0),
                allDay: false
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d+4, 16, 0),
                allDay: false
            },
            {
                title: 'Meeting',
                start: new Date(y, m, d, 10, 30),
                allDay: false
            },
            {
                title: 'Write article',
                start: new Date(y, m, d, 12, 0),
                end: new Date(y, m, d, 14, 0),
                allDay: false
            },
            {
                title: 'Work on template',
                start: new Date(y, m, d+1, 19, 0),
                end: new Date(y, m, d+1, 22, 30),
                allDay: false
            },
            {
                title: 'Click for Google',
                start: new Date(y, m, 28),
                end: new Date(y, m, 29),
                url: 'http://google.com/'
            }
        ]
    });
    
    /* Initialize WYSIWYG editor */
    // This is the default settings for the wysiwyg editor, just add the class 'wysiwyg' to a textarea and you are ready
    $('.wysiwyg').wysiwyg({
        controls: {
            strikeThrough : {visible : true},
            underline     : {visible : true},

            separator00 : {visible : true},

            justifyLeft   : {visible : true},
            justifyCenter : {visible : true},
            justifyRight  : {visible : true},
            justifyFull   : {visible : true},

            separator01 : {visible : true},

            indent  : {visible : true},
            outdent : {visible : true},

            separator02 : {visible : true},

            subscript   : {visible : true},
            superscript : {visible : true},

            separator03 : {visible : true},

            undo : {visible : true},
            redo : {visible : true},

            separator04 : {visible : true},

            insertOrderedList    : {visible : true},
            insertUnorderedList  : {visible : true},
            insertHorizontalRule : {visible : true},

            h4mozilla : {visible : true && $.browser.mozilla, className : 'h4', command : 'heading', arguments : ['h4'], tags : ['h4'], tooltip : "Header 4"},
            h5mozilla : {visible : true && $.browser.mozilla, className : 'h5', command : 'heading', arguments : ['h5'], tags : ['h5'], tooltip : "Header 5"},
            h6mozilla : {visible : true && $.browser.mozilla, className : 'h6', command : 'heading', arguments : ['h6'], tags : ['h6'], tooltip : "Header 6"},

            h4 : {visible : true && !( $.browser.mozilla ), className : 'h4', command : 'formatBlock', arguments : ['<H4>'], tags : ['h4'], tooltip : "Header 4"},
            h5 : {visible : true && !( $.browser.mozilla ), className : 'h5', command : 'formatBlock', arguments : ['<H5>'], tags : ['h5'], tooltip : "Header 5"},
            h6 : {visible : true && !( $.browser.mozilla ), className : 'h6', command : 'formatBlock', arguments : ['<H6>'], tags : ['h6'], tooltip : "Header 6"},

            separator07 : {visible : true},

            cut   : {visible : true},
            copy  : {visible : true},
            paste : {visible : true}
        }
    });

});
///////////////////////////////////////////////////////////////////////////////////////////////