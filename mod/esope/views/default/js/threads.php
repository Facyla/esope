// Sympa mais casse les liens "normaux" que ce plugin ne gère pas => inutilisable

$(function(){
	$('.elgg-menu .elgg-menu-item-reply a').click(function(){
		guid = $.parseQuery(this.href).guid;
		// Added by Facyla to avoid overriding unwanted links
		if ($('#reply-topicreply-' + guid).length) {
		  $('#edit-topicreply-' + guid).hide();
		  $('#reply-topicreply-' + guid).slideToggle('slow');
		  return false;
		} else {
		  return true;
		}
		
	});
	$('.elgg-menu .elgg-menu-item-edit a').click(function(){
		guid = $.parseQuery(this.href).guid;
		// Added by Facyla to avoid overriding unwanted links
		if ($('#reply-topicreply-' + guid).length) {
		$('#reply-topicreply-' + guid).hide();
		$('#edit-topicreply-' + guid).slideToggle('slow');
		  return false;
		} else {
		  return true;
		}
	});
});
