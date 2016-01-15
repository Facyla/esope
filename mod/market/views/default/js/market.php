<?php
/**
 * Javascript for market plugin
 *
 * @package Market
 */

$numchars = elgg_get_plugin_setting('market_numchars', 'market');

if (0) { ?><script><?php }
?>
elgg.provide('elgg.market');

elgg.market.init = function() {

	var $form = $('form[name="marketForm"]');
	$form.on('submit', function(e) {
			
		if(!($('input[name="accept_terms"]').prop('checked'))) {		
			alert(elgg.echo('market:accept:terms:error'));
			$('input[name="accept_terms"]').focus();
			e.preventDefault(); //prevent form from submitting
		}
		//e.preventDefault();
	});
	
	$('.market_charleft').val(<?php echo $numchars; ?> - $('#plaintext-description').val().length);

	$('#plaintext-description').keyup(function () {
		var $countField = $('.market_charleft');
		var maxLimit = <?php echo $numchars; ?>;
		// if too long...trim it!
		console.log('Max: ' + maxLimit + ' Chars: ' + $(this).val().length);
		if ($(this).val().length > maxLimit) {
			$(this).val($(this).val().substring(0, maxLimit));
		} else {
			// otherwise, update 'characters left' counter
			$countField.val(maxLimit - $(this).val().length);
		}
	});

	$('#market-type').change(function() {
		var value = $(this).val();
		$('#market-price').prop('readonly', false);	
		if (value == 'free') {
			$('#market-price').val('0');
			$('#market-price').prop('readonly', true);
		} else if (value == 'swap') {
			$('#market-price').val('');
			$('#market-price').prop('readonly', true);
		}
	});

};

elgg.register_hook_handler('init', 'system', elgg.market.init);
