//<script>

elgg.provide('elgg.tooltip_editor');

elgg.tooltip_editor.init = function() {
	$('.tooltip-editor-edit').live('click', function(e) {
		e.preventDefault();
		elgg.tooltip_editor.edit($(this));
	});
	
	// reinit tooltips on ajax complete
	$(document).ajaxComplete(function() {
		elgg.tooltip_editor.initQtip();
	});

	elgg.tooltip_editor.initQtip();
}

elgg.tooltip_editor.initQtip = function() {
	$('.elgg-menu a[title!=""]').each(function(index, item) {
		
		var processed = $(this).attr('data-tooltip-initiated');
		if (processed) {
			return; // this has already been done
		}
		
		var content = $(this).children('.tooltip-editor-options').eq(0).attr('data-show-content');
		var title = $(this).children('.tooltip-editor-options').eq(0).attr('data-show-title');
		
		if (typeof content == 'undefined') {
			return;
		}
		
		if (typeof title == 'undefined') {
			var title = $(this).attr('title');
		}
		else {
			title = elgg.tooltip_editor.base64decode(title);
		}
		
		if (content.length > 0) {
			content = elgg.tooltip_editor.base64decode(content);
		}

		$(this).qtip({
			position: {
				my: $(this).children('.tooltip-editor-options').eq(0).attr('data-position-my'),
				at: $(this).children('.tooltip-editor-options').eq(0).attr('data-position-at')
			},
			show: {
				delay: $(this).children('.tooltip-editor-options').eq(0).attr('data-show-delay')
			},
			content: {
		        text: content,
				title: title,
				button: $(this).children('.tooltip-editor-options').eq(0).attr('data-show-button')
			},
			hide: {
				event: $(this).children('.tooltip-editor-options').eq(0).attr('data-show-hide')
			}
		});
		
		$(this).attr('data-tooltip-initiated', 1);
	});
}

elgg.tooltip_editor.edit = function(span) {
		
		var classList = span.attr('class').split(/\s+/);
		var token = '';
		
		$.each(classList, function(index, item){
			// look for our token
			if (item.indexOf('tooltip-editor-token-') === 0) {
				token = item.split("tooltip-editor-token-").pop();
			}
		});
		
		if (token.length === 0) {
			return;
		}
		
		$.fancybox({
			href: elgg.get_site_url() + 'ajax/view/tooltip_editor/form?token=' + token,
			autoDimensions: false,
			width: 320,
			height: 400
		});
}


elgg.tooltip_editor.base64decode = function(data) {

  //  discuss at: http://phpjs.org/functions/base64_decode/
  // original by: Tyler Akins (http://rumkin.com)
  // improved by: Thunder.m
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //    input by: Aman Gupta
  //    input by: Brett Zamir (http://brett-zamir.me)
  // bugfixed by: Onno Marsman
  // bugfixed by: Pellentesque Malesuada
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //   example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==');
  //   returns 1: 'Kevin van Zonneveld'
  //   example 2: base64_decode('YQ===');
  //   returns 2: 'a'

  var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    dec = '',
    tmp_arr = [];

  if (!data) {
    return data;
  }

  data += '';

  do { // unpack four hexets into three octets using index points in b64
    h1 = b64.indexOf(data.charAt(i++));
    h2 = b64.indexOf(data.charAt(i++));
    h3 = b64.indexOf(data.charAt(i++));
    h4 = b64.indexOf(data.charAt(i++));

    bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

    o1 = bits >> 16 & 0xff;
    o2 = bits >> 8 & 0xff;
    o3 = bits & 0xff;

    if (h3 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1);
    } else if (h4 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1, o2);
    } else {
      tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
    }
  } while (i < data.length);

  dec = tmp_arr.join('');

  return dec.replace(/\0+$/, '');
}

elgg.register_hook_handler('init', 'system', elgg.tooltip_editor.init);