<?php
$publickey = elgg_get_plugin_setting('publickey', 'recaptcha');
?>

<script type="text/javascript">
<?php
/* Regular method : would work if we could pass parameters to JS defered scripts
var ReCaptchaCallback = function() {
	$(".g-recaptcha").each(function(index) {
		grecaptcha.render('g-recaptcha-' + (index+1), {'sitekey' : '<?php echo $publickey; ?>'});
	});
};
*/
/*
var ReCaptchaCallback = function(){
	$('.g-recaptcha').each(function(index, el) {
		grecaptcha.render(el, {'sitekey' : '<?php echo $publickey; ?>'});
	});
};
*/
?>
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

