
$(function()
{
	var my_news = $(".body_news");
	var content_truncated = new Array();

	
	$.each(my_news, function(key, value){	
		content_truncated[key] = $(value).text().trim()    // remove leading and trailing spaces
			.substring(0, 170) 
			.split(" ") // separate characters into an array of words
			.slice(0, -1)    // remove the last full or partial word
			.join(" ") + "...";
	});
	

	$.each(content_truncated, function(key, value)
	{
		$("#"+key).text(value);
	});

});
