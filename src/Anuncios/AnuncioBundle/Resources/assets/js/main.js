blueimp.Gallery.prototype.textFactory = function (obj, callback) {
	var $iframe = $('<iframe>').attr('src', obj.href);
    var $element = $('<div>')
            .addClass('text-content')
            .attr('title', obj.title);
    
    $.get(obj.href)
        .done(function (result) {
            $element.html(result);
            callback({
                type: 'load',
                target: $element[0]
            });
        })
        .fail(function () {
        	$element.append($iframe[0]);
        	callback({
                type: 'load',
                target: $element[0]
            });
            /*callback({
                type: 'error',
                target: $element[0]
            });*/
    });
    return $element[0];
};

$(document).ready(function()
{
	$(".anuncioShow .picture").hover(function()
	{
		$(this).children('.overlay, .overlayContent').show();
	}, function()
	{
		$(this).children('.overlay, .overlayContent').hide();
	});
	
	$(".viewResourcesButton").click(function(e)
	{
		e.preventDefault();
		
		var gallery = blueimp.Gallery(resourcesItems);
	});
});
