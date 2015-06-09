// Note : these scripts are not used, because older script did not work and update was not mandatory when updating the plugin

/*
function annotation_like(){
	//$("body").addClass("esope-search-wait");
	formdata = $("#esope-search-form").serialize();
	$.post("' . $esope_search_url . '", formdata, function(data){
		$("#esope-search-results").html(data);
		//$("body").removeClass("esope-search-wait");
	});
}
*/

jQuery(function($){
	$('.annotation-like').each(function(){
		var self = $(this);
		var count = self.find('.counter');
		self.find('a').each(function(){
			var handler = $(this);
			handler.click(function(){
				if (handler.hasClass('working')){
					return false;
				}
				handler.addClass('working')
				
				$.post(handler.attr('href'), {}, function(res){
					
					if (parseInt(res)){
						// Swap href, text for data-href, data-text
						var text = handler.text();
						var href = handler.attr('href');
						handler.attr('href', handler.data('href'));
						handler.data('href', href);
						handler.text(handler.data('text'));
						handler.data('text', text);
						
						var liked = self.find('.liked').length > 0;
						// Count up/down
						count.text(parseInt(count.text()) + (liked ? -1 : 1));
						
						// Update like status
						handler.toggleClass('liked');
						handler.toggleClass('like');
						self.trigger('annotation-like-success');
					}else{
						self.trigger('annotation-like-error');
//						alert('error');
					}
					handler.removeClass('working');
				});
				return false;
			});
		});
	});
});
