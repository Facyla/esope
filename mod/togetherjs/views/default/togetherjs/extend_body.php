<script>
// Update name and profile picture
TogetherJS.refreshUserData();

// Load tinymce support
$(function () {
  tinymce.init({ 
    selector: '.mceContentBody',
  });
});

</script>

<div id="together-js">
	<button id="togetherjs-collaborate" type="button">Collaboration en temps réel</button>
	<script>
	document.getElementById("togetherjs-collaborate").addEventListener("click", TogetherJS, false);
	</script>
</div>

