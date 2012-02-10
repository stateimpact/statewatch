jQuery(function($) {
    var target = $('<p/>')
        .attr('id', 'wordcount')
        .text('Word count: ');
    var excerpt = $('#postexcerpt textarea');
    excerpt.parent('div').append(target);
    excerpt.bind('keyup change paste focus blur', function(e) {
        var words = $(this).val().split(' ');
        target.text('Word count: ' + words.length);
    });
    
    // trigger a change event to do initial count
    excerpt.change();
});