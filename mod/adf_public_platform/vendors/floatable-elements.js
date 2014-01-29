/* Floatable element :
 - use .is-floatable class to allow elements to use this script
 - elements get class .floating when scrolling passes them
 - style them using element-specific CSS selectors
 */
var position = 0;
if ($('.is-floatable').offset() != null) {
	var position = $('.is-floatable').offset().top;
}
$(window).scroll(
	function() {
		if ($(window).scrollTop() >= position) {
		  // fixed
		  $('.is-floatable').addClass("floating");
		} else {
		  // relative
		  $('.is-floatable').removeClass("floating");
		}
	}
);

