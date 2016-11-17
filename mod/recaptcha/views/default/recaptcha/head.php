<?php
$publickey = elgg_get_plugin_setting('publickey', 'recaptcha');

// Following JS method do NOT work because when we register and load JS script & is converted to &amp; which breaks passing parameters :-(
// So using a cloning method instead

/* JS Regular method : would work if we could pass parameters to JS defered scripts
var ReCaptchaCallback = function() {
	$(".g-recaptcha").each(function(index) {
		grecaptcha.render('g-recaptcha-' + (index+1), {'sitekey' : '<?php echo $publickey; ?>'});
	});
};
*/
/* Alternative method
var ReCaptchaCallback = function(){
	$('.g-recaptcha').each(function(index, el) {
		grecaptcha.render(el, {'sitekey' : '<?php echo $publickey; ?>'});
	});
};
*/
?>

<script type="text/javascript">
// Cloning method : must occur after all page is loaded, so cannot use $(document).ready(function() {}));
$(window).load(function() {
	$(".g-recaptcha").each(function(index) {
		if (index > 0) {
			// Duplicate our first reCapcha
			$('#g-recaptcha-' + (index+1)).html($('#g-recaptcha-1').clone(true,true));
		}
	});
});
</script>

