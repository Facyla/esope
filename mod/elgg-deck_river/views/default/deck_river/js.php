

// js for deck-river plugin
$(document).ready(function() {
	if ( $('.deck-river').length ) {
		$('body').css('position','fixed');
		$('.elgg-page-default .elgg-page-body > .elgg-inner').css('width','100%');
		SetColumnsHeight();
		SetColumnsWidth();

		// load columns
		$('.column-river').each(function() {
			LoadColumn($(this));
		});

		// refresh column, use 'live' for new column
		$('.elgg-column-refresh-button').live('click', function() {
			RefreshColumn($(this).parents('.column-river'));
		});

		// refresh all columns
		$('.elgg-refresh-all-button').click(function() {
			$('.elgg-column-refresh-button').each(function() {
				RefreshColumn($(this).parents('.column-river'));
			});
		});

		// Column settings, use 'live' for new column
		$('.elgg-column-edit-button').live('click', function() {
			if (!$('#column-settings').length) { $(this).parent().append('<div id="column-settings" class="elgg-module-popup"></div>'); }
			ColumnSettings($(this).parents('.column-river').attr('rel'));
		});

		// Add new column
		$('.elgg-add-new-column').click(function() {
			var NbrColumn = $('.column-river').length;
			if (NbrColumn == '10') {
				elgg.system_message(elgg.echo('deck_river:limitColumnReached'));
			} else {
				if (!$('#column-settings').length) { $(this).parent().append('<div id="column-settings" class="elgg-module-popup"></div>'); }
				NumColumn = [];
				$('.column-river').each(function(){
					NumColumn.push($(this).attr('rel').split('-')[1]);
				});
				ColumnSettings( 'column-' + ( ( Math.max.apply(null, NumColumn) ) +1 ) );
			}
		});
	}
});

$(window).bind("resize", function() {
	if ( $('.deck-river').length ) {
		SetColumnsHeight();
		SetColumnsWidth();
	}
});

function LoadColumn(TheColumn) {
	var tab = $('.deck-river-lists').attr('rel');
	TheColumn.find('.elgg-river').load(elgg.config.wwwroot + 'mod/elgg-deck_river/views/default/page/components/ajax_list.php?tab=' + tab + '&column=' + TheColumn.attr('rel'), {}, function() {
		if ( TheColumn.find('.elgg-list-item').length >= 20 ) {
			TheColumn.find('.elgg-river').append('<li class="moreItem">More...</li>');

			// load more items
			TheColumn.find('.moreItem').click(function() {
				TheColumn = $(this).parents('.column-river');
				TheColumn.find('.elgg-icon-refresh').css('background', 'url("' + elgg.config.wwwroot + 'mod/elgg-deck_river/graphics/elgg_refresh.gif") no-repeat scroll -1px -1px transparent');
				var column = TheColumn.attr('rel');
				var posted = TheColumn.find('.elgg-river .elgg-list-item:last').attr('datetime');
				TheColumn.append('<div id="ajax_list" style="display:none;"><div>');
				$('#ajax_list').load(elgg.config.wwwroot + 'mod/elgg-deck_river/views/default/page/components/ajax_list.php?tab=' + tab + '&column=' + column + '&time_method=upper&time_posted=' + posted, {}, function(){
					TheColumn.find('.elgg-river').append($('#ajax_list').html()).append(TheColumn.find('.moreItem'));
					TheColumn.find('.elgg-icon-refresh').css('background', 'url("' + elgg.config.wwwroot + '_graphics/elgg_sprites.png") no-repeat scroll 0 -792px transparent');
					$('#ajax_list').remove();
				});
			});
		}
	});
}

function RefreshColumn(TheColumn) {
	TheColumn.find('.elgg-icon-refresh').css('background', 'url("' + elgg.config.wwwroot + 'mod/elgg-deck_river/graphics/elgg_refresh.gif") no-repeat scroll -1px -1px transparent');
	TheColumn.find('.elgg-list-item').removeClass('newRiverItem');
	var tab = TheColumn.parents('.deck-river-lists').attr('rel');
	var column = TheColumn.attr('rel');
	var posted = TheColumn.find('.elgg-river .elgg-list-item:first').attr('datetime');
	if (typeof posted == 'undefined') posted = 0; // if there are no item
	TheColumn.append('<div id="ajax_list'+column+'" style="display:none;"><div>');
	$('#ajax_list'+column).load(elgg.config.wwwroot + 'mod/elgg-deck_river/views/default/page/components/ajax_list.php?tab=' + tab + '&column=' + column + '&time_method=lower&time_posted=' + posted, {}, function(){
		$('#ajax_list'+column+' .elgg-list-item').addClass('newRiverItem');
		TheColumn.find('.elgg-river').prepend($('#ajax_list'+column).html());
		TheColumn.find('.newRiverItem').fadeIn('slow');
		TheColumn.find('.elgg-icon-refresh').css('background', 'url("' + elgg.config.wwwroot + '_graphics/elgg_sprites.png") no-repeat scroll 0 -792px transparent');
		$('#ajax_list'+column).remove();
	});
}

function ColumnSettings(column) {
	$('#column-settings').draggable().load(elgg.config.wwwroot + 'mod/elgg-deck_river/views/default/deck_river/column_settings.php?tab='+ $('.deck-river-lists').attr('rel') + '&column=' + column, {}, function() {
		$('#column-settings .elgg-head a').click(function() {
			$('#column-settings').remove();
		});
		if ($('.column-type option:selected').val() == 'search') {
			$('#column-settings .search-type').show('slow');
		}
		$('.column-type').change(function() {
			if ($('.column-type option:selected').val() == 'search') {
				$('#column-settings .search-type').show('slow');
			} else {
				$('#column-settings .search-type').hide('slow');
			}
		});
		$('.deck-river-form-column-settings').submit(function() { return false; });
		$(".elgg-button").click(function(event) {
			if ($(this).parent("form").beenSubmitted) // Prevent double-click
				return false;
			else {
				$(this).parent("form").beenSubmitted = true;
				dataString = $('.deck-river-form-column-settings').serialize() + "&submit=" + $(this).attr("value");
				elgg.action('deck_river/column_settings', {
					data: dataString,
					success: function(json) {
						TheResponse = json['output'].split(',');
						if (TheResponse[2]) $('li.column-river[rel="'+TheResponse[1]+'"] h3').html(TheResponse[2]);
						if (TheResponse[0] == 'change') {
							$('li.column-river[rel="'+TheResponse[1]+'"] .elgg-list').html('<div class="elgg-ajax-loader "></div>');
							LoadColumn($('li.column-river[rel="'+TheResponse[1]+'"]'));
						}
						if (TheResponse[0] == 'delete') {
							$('li.column-river[rel="'+TheResponse[1]+'"]').fadeOut().animate({'width':0},'', function() {
								$(this).remove();
								SetColumnsWidth();
							});
						}
						if (TheResponse[0] == 'new') {
							$('.deck-river-lists-container').append('<li class="column-river" rel="'+TheResponse[1]+'"><ul class="column-header"></ul><ul class="elgg-river elgg-list"></ul></li>');
							$('li.column-river[rel="'+TheResponse[1]+'"] .column-header').html($('li.column-river[rel="column-1"] .column-header').html());
							SetColumnsHeight();
							SetColumnsWidth();
							$('li.column-river[rel="'+TheResponse[1]+'"] .elgg-list').html('<div class="elgg-ajax-loader "></div>');
							LoadColumn($('li.column-river[rel="'+TheResponse[1]+'"]'));
							$('li.column-river[rel="'+TheResponse[1]+'"] h3').html(TheResponse[2]);
							$('.deck-river-lists').animate({ scrollLeft: $('.deck-river-lists').width()});
						}
						$('#column-settings').remove();
						return false;
					}
				});
				return false;
			}
		});
	});
}

function SetColumnsHeight() {
	var offset = $('.deck-river-lists').offset();
	$('.elgg-river').height($(window).height() - offset.top - $('.column-header').height() - scrollbarWidth());
	$('.deck-river-lists').height($(window).height() - offset.top);
}

function SetColumnsWidth() {
	var WindowWidth = $('.deck-river-lists').width();
	var CountLists = $('.column-river').length;
	var ListWidth = 0; var i = 0;
	while ( ListWidth < 300 ) {
		ListWidth = (WindowWidth) / ( CountLists - i );
		i++;
	}
	$('.elgg-river, .column-header').width(ListWidth);
	$('.deck-river-lists-container').width(ListWidth * CountLists);
}

function scrollbarWidth() {
	if (!$._scrollbarWidth) {
		var $body = $('body');
		var w = $body.css('overflow', 'hidden').width();
		$body.css('overflow','scroll');
		w -= $body.width();
		if (!w) w=$body.width()-$body[0].clientWidth; // IE in standards mode
		$body.css('overflow','');
		$._scrollbarWidth = w+1;
	}
	return $._scrollbarWidth;
}

// End of js for deck-river plugin
