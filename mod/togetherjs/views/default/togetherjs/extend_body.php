<script>
// Update name and profile picture
TogetherJS.refreshUserData();

TogetherJS.addTracker(tinymceEditor, true);

$(function () {
  tinymce.init({ 
    selector: '.elgg-input-longtext',
  });
});

/*
  // check for a tinymce instance
  if (tinymce !== undefined) {
    tinymce.on("AddEditor", function (event) {
      var editor = event.editor;
      editor.on("init", function (event) {
        //add EventListener here
      });
    });
  }
});
*/
</script>

<div id="together-js">
	<button id="togetherjs-collaborate" type="button">Collaboration en temps réel</button>
	<script>
	document.getElementById("togetherjs-collaborate").addEventListener("click", TogetherJS, false);
	</script>
</div>

