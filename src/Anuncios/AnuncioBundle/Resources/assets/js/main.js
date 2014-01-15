$(document).ready(function()
{
	$(".anuncioShow .picture").hover(function()
	{
		$(this).children('.overlay, .overlayContent').show();
	}, function()
	{
		$(this).children('.overlay, .overlayContent').hide();
	});
});
