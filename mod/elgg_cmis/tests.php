<html>
<head>
		 <script type="text/javascript" src="https://partage.inria.fr/share/res/js/yui-common.js"></script>
		<script type="text/javascript" src="https://partage.inria.fr/share/res/js/bubbling.v2.1-min.js"></script>
		<script type="text/javascript" src="https://partage.inria.fr/share/res/js/alfresco-min.js"></script>
		
		<!-- Alfresco.WebPreview  -->
		<script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/web-preview-min.js"></script>

		<!-- Alfresco.WebPreview.Plugins -->
		<!-- Alfresco.WebPreviewer.Plugins.WebPreviewer -->
		<script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/WebPreviewer-min.js"></script>
		<script type="text/javascript" src="https://partage.inria.fr/share/res/js/flash/extMouseWheel-min.js"></script>
		<!-- Alfresco.WebPreviewer.Plugins.FlashFox -->
		<script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/FlashFox-min.js"></script>
		<!-- Alfresco.WebPreviewer.Plugins.StrobeMediaPlayback -->
		<script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/StrobeMediaPlayback-min.js"></script>
		<!-- Alfresco.WebPreviewer.Plugins.Video -->
		<script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/Video-min.js"></script>

		<!-- Alfresco.WebPreviewer.Plugins.Audio -->
		<script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/Audio-min.js"></script>

		<!-- Alfresco.WebPreviewer.Plugins.Flash -->
		<script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/Flash-min.js"></script>

		<!-- Alfresco.WebPreviewer.Plugins.Image -->
		<script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/Image-min.js"></script>
		<style type="text/css" media="screen">
		@import "https://partage.inria.fr/share/res/components/preview/web-preview.css";
		@import "https://partage.inria.fr/share/res/components/preview/WebPreviewerHTML.css";
		@import "https://partage.inria.fr/share/res/components/preview/Audio.css";
		@import "https://partage.inria.fr/share/res/components/preview/Image.css";
		</style>

</head>
<body>
<?php
$file_url = 'test.txt';
$file_url = 'testimg.jpg';
$file_url = urlencode($file_url);
// https://partage.inria.fr/share/components/preview/WebPreviewer.swf
/* Useful WebPreviewer extensions :
<!-- Alfresco.WebPreview  -->
   <script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/web-preview-min.js"></script>

<!-- Alfresco.WebPreview.Plugins -->

<!-- Alfresco.WebPreviewer.Plugins.WebPreviewer -->
   <script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/WebPreviewer-min.js"></script>
   <script type="text/javascript" src="https://partage.inria.fr/share/res/js/flash/extMouseWheel-min.js"></script>

<!-- Alfresco.WebPreviewer.Plugins.FlashFox -->
   <script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/FlashFox-min.js"></script>

<!-- Alfresco.WebPreviewer.Plugins.StrobeMediaPlayback -->
   <script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/StrobeMediaPlayback-min.js"></script>

<!-- Alfresco.WebPreviewer.Plugins.Video -->
   <script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/Video-min.js"></script>

<!-- Alfresco.WebPreviewer.Plugins.Audio -->
   <script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/Audio-min.js"></script>

<!-- Alfresco.WebPreviewer.Plugins.Flash -->
   <script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/Flash-min.js"></script>

<!-- Alfresco.WebPreviewer.Plugins.Image -->
   <script type="text/javascript" src="https://partage.inria.fr/share/res/components/preview/Image-min.js"></script>
   <style type="text/css" media="screen">
      @import "https://partage.inria.fr/share/res/components/preview/web-preview.css";
      @import "https://partage.inria.fr/share/res/components/preview/WebPreviewerHTML.css";
      @import "https://partage.inria.fr/share/res/components/preview/Audio.css";
      @import "https://partage.inria.fr/share/res/components/preview/Image.css";
   </style>




<script type="text/javascript">//<![CDATA[
   new Alfresco.WebPreview("template_x002e_web-preview_x002e_document-details_x0023_default").setOptions(
   {
      nodeRef: "workspace://SpacesStore/fefbf2ef-7a6c-4c99-8d8d-d4a44b993aba",
      name: "Contenu test texte",
      mimeType: "text/plain",
      size: "32",
      thumbnails: ["avatar32", "doclib", "webpreview", "avatar", "medium", "imgpreview"],
      pluginConditions: [{"attributes": {"mimeType": "application\/x-shockwave-flash"}, "plugins": [{"attributes": {}, "name": "Flash"}]}]
   }).setMessages({"preview.fullwindow": "Maximiser"});
   //]]></script>
*/


?>
<embed type="application/x-shockwave-flash"
   src="WebPreviewer.swf"
   width="600px"
   height="400px"
   id="WebPreviewer"
   name="WebPreviewer"
   quality="high"
   allowscriptaccess="all"
   allowfullscreen="true"
   wmode="transparent"
   flashvars="fileName=<?php echo $file_url; ?>&amp;paging=false&amp;url=<?php echo $file_url; ?>&amp;i18n_actualSize=Actual%20Size&amp;i18n_fitPage=Fit%20Page&amp;i18n_fitWidth=Fit%20Width&amp;i18n_fitHeight=Fit%20Height&amp;i18n_fullscreen=Fullscreen&amp;i18n_fullwindow=Maximize&amp;i18n_fullwindow_escape=Press%20Esc%20to%20exit%20full%20window%20mode&amp;i18n_page=Page&amp;i18n_pageOf=of" />

<hr />

<div id="alfresco-webpreviewer" class="alfresco-webpreviewer">
<script type="text/javascript">//<![CDATA[
new Alfresco.WebPreview("alfresco-webpreviewer").setOptions({
	//nodeRef: "<?php echo $file_url; ?>",
	url: "<?php echo $file_url; ?>",
	name: "Contenu test texte",
	mimeType: "text/plain",
	size: "32",
	thumbnails: ["avatar32", "doclib", "webpreview", "avatar", "medium", "imgpreview"],
	pluginConditions: [{"attributes": {"thumbnail": "imgpreview", "mimeType": "video\/mp4"}, "plugins": [{"attributes": {"poster": "imgpreview", "posterFileSuffix": ".png"}, "name": "StrobeMediaPlayback"}, {"attributes": {"poster": "imgpreview", "posterFileSuffix": ".png"}, "name": "FlashFox"}, {"attributes": {"poster": "imgpreview", "posterFileSuffix": ".png"}, "name": "Video"}]}, {"attributes": {"thumbnail": "imgpreview", "mimeType": "video\/m4v"}, "plugins": [{"attributes": {"poster": "imgpreview", "posterFileSuffix": ".png"}, "name": "StrobeMediaPlayback"}, {"attributes": {"poster": "imgpreview", "posterFileSuffix": ".png"}, "name": "FlashFox"}, {"attributes": {"poster": "imgpreview", "posterFileSuffix": ".png"}, "name": "Video"}]}, {"attributes": {"thumbnail": "imgpreview", "mimeType": "video\/x-flv"}, "plugins": [{"attributes": {"poster": "imgpreview", "posterFileSuffix": ".png"}, "name": "StrobeMediaPlayback"}, {"attributes": {"poster": "imgpreview", "posterFileSuffix": ".png"}, "name": "FlashFox"}]}, {"attributes": {"thumbnail": "imgpreview", "mimeType": "video\/quicktime"}, "plugins": [{"attributes": {"poster": "imgpreview", "posterFileSuffix": ".png"}, "name": "StrobeMediaPlayback"}]}, {"attributes": {"thumbnail": "imgpreview", "mimeType": "video\/ogg"}, "plugins": [{"attributes": {"poster": "imgpreview", "posterFileSuffix": ".png"}, "name": "Video"}]}, {"attributes": {"thumbnail": "imgpreview", "mimeType": "video\/webm"}, "plugins": [{"attributes": {"poster": "imgpreview", "posterFileSuffix": ".png"}, "name": "Video"}]}, {"attributes": {"mimeType": "video\/mp4"}, "plugins": [{"attributes": {}, "name": "StrobeMediaPlayback"}, {"attributes": {}, "name": "FlashFox"}, {"attributes": {}, "name": "Video"}]}, {"attributes": {"mimeType": "video\/x-m4v"}, "plugins": [{"attributes": {}, "name": "StrobeMediaPlayback"}, {"attributes": {}, "name": "FlashFox"}, {"attributes": {}, "name": "Video"}]}, {"attributes": {"mimeType": "video\/x-flv"}, "plugins": [{"attributes": {}, "name": "StrobeMediaPlayback"}, {"attributes": {}, "name": "FlashFox"}]}, {"attributes": {"mimeType": "video\/quicktime"}, "plugins": [{"attributes": {}, "name": "StrobeMediaPlayback"}]}, {"attributes": {"mimeType": "video\/ogg"}, "plugins": [{"attributes": {}, "name": "Video"}]}, {"attributes": {"mimeType": "video\/webm"}, "plugins": [{"attributes": {}, "name": "Video"}]}, {"attributes": {"mimeType": "audio\/mpeg"}, "plugins": [{"attributes": {}, "name": "StrobeMediaPlayback"}, {"attributes": {}, "name": "FlashFox"}, {"attributes": {}, "name": "Audio"}]}, {"attributes": {"mimeType": "audio\/x-wav"}, "plugins": [{"attributes": {}, "name": "Audio"}]}, {"attributes": {"thumbnail": "webpreview"}, "plugins": [{"attributes": {"paging": "true", "src": "webpreview"}, "name": "WebPreviewer"}]}, {"attributes": {"thumbnail": "imgpreview"}, "plugins": [{"attributes": {"src": "imgpreview"}, "name": "Image"}]}, {"attributes": {"mimeType": "image\/jpeg"}, "plugins": [{"attributes": {"srcMaxSize": "500000"}, "name": "Image"}]}, {"attributes": {"mimeType": "image\/png"}, "plugins": [{"attributes": {"srcMaxSize": "500000"}, "name": "Image"}]}, {"attributes": {"mimeType": "image\/gif"}, "plugins": [{"attributes": {"srcMaxSize": "500000"}, "name": "Image"}]}, {"attributes": {"mimeType": "application\/x-shockwave-flash"}, "plugins": [{"attributes": {}, "name": "Flash"}]}]
   })
   .setMessages({"preview.fullwindow": "Maximiser", "label.browserReport": "Le navigateur ne prend pas en charge {0}", "error.error": "Ce contenu ne peut \u00eatre affich\u00e9 \u00e0 cause d'une erreur inconnue.", "error.content": "Le contenu ne peut \u00eatre affich\u00e9 car il n'est pas de type png, jpg, gif ou swf.", "preview.fullscreen": "Plein \u00e9cran", "preview.fitWidth": "Adapter \u00e0 la largeur", "label.noPreview": "Ce document ne peut pas \u00eatre pr\u00e9visualis\u00e9.<br\/><a class=\"theme-color-1\" href=''{0}''>Cliquez ici pour le t\u00e9l\u00e9charger.<\/a>", "preview.pageOf": "sur", "Image.downloadLargeFile": "Cliquez ici pour le t\u00e9l\u00e9charger.", "error.io": "La pr\u00e9visualisation ne peut \u00eatre charg\u00e9e depuis le serveur. ", "Image.viewLargeFile": "Cliquez ici pour l'afficher quand m\u00eame.", "Image.tooLargeFile": "Le fichier {0} est sans doute trop volumineux pour s''afficher ({1}).", "label.noContent": "Ce document ne poss\u00e8de pas de contenu.", "preview.fitHeight": "Adapter \u00e0 la hauteur", "preview.fullwindowEscape": "Appuyer sur la touche Esc \/ \u00c9chap pour quitter le mode plein \u00e9cran", "label.noFlash": "Pour afficher la pr\u00e9visualisation, veuillez t\u00e9l\u00e9charger la derni\u00e8re version du lecteur Flash depuis <br\/><a href=\"http:\/\/www.adobe.com\/go\/getflashplayer\">Adobe Flash Player Download Center<\/a>.", "label.preparingPreviewer": "Pr\u00e9paration de la pr\u00e9visualisation...", "label.error": "Impossible d''afficher le contenu \u00e0 cause d''une erreur au niveau du module d''extension ''{0}'' : {1}", "preview.fitPage": "Adapter \u00e0 la page", "preview.page": "Page", "preview.actualSize": "Taille r\u00e9elle"});
//]]>
</script>
   </div>
<div id="alfresco-webpreviewer-body" class="web-preview">
	<div id="alfresco-webpreviewer-previewer-div" class="previewer">
		<div class="message">Préparation de la prévisualisation...</div>
	</div>
</div>


<?php/*
DOC from http://forums.alfresco.com/forum/end-user-discussions/alfresco-explorer/how-embed-alfresco-document-external-site-11112009-1609

Re: how to embed Alfresco document in external site?
I realise you've posted this in the Alfresco Explorer forum, but you can embed the Share WebPreviewer with code along the lines of:
<embed type="application/x-shockwave-flash"

   src="http://<server>:<port>/share/components/preview/WebPreviewer.swf"

   width="670px"

   height="670px"

   id="WebPreviewer"

   name="WebPreviewer"

   quality="high"

   allowscriptaccess="sameDomain"

   allowfullscreen="true"

   wmode="transparent"

   flashvars="fileName=aaar.png&amp;paging=false&amp;url=http%3A%2F%2Flocalhost%3A8080%2Falfresco%2Fservice%2Fapi%2Fnode%2Fworkspace%2FSpacesStore%2F15ddb4a8-63a5-4bf3-95a8-4d121d2eaed2%2Fcontent%3Fc%3Dforce%26noCacheToken%3D1257980553515%26guest%3Dtrue&amp;show_fullscreen_button=true&amp;i18n_actualSize=Actual%20Size&amp;i18n_fitPage=Fit%20Page&amp;i18n_fitWidth=Fit%20Width&amp;i18n_fitHeight=Fit%20Height&amp;i18n_fullscreen=Fullscreen&amp;i18n_fullwindow=Maximize&amp;i18n_fullwindow_escape=Press%20Esc%20to%20exit%20full%20window%20mode&amp;i18n_page=Page&amp;i18n_pageOf=of" />

Note the flashvars variable is a string passed through "encodeURIComponent" consisting of the following variables:
fileName=aaar.png

paging=false

url=http://localhost:8080/alfresco/service/api/node/workspace/SpacesStore/15ddb4a8-63a5-4bf3-95a8-4d121d2eaed2/content?c=force&noCacheToken=1257980553515&guest=true

show_fullscreen_button=true

i18n_actualSize=Actual Size

i18n_fitPage=Fit Page

i18n_fitWidth=Fit Width

i18n_fitHeight=Fit Height

i18n_fullscreen=Fullscreen

i18n_fullwindow=Maximize

i18n_fullwindow_escape=Press Esc to exit full window mode

i18n_page=Page

i18n_pageOf=of"

Note the noCacheToken on the end of the "url" variable to ensure your users are always viewing the latest content. It's up to you whether you generate this value or not.
The i18n messages make the tag somewhat unwieldy, so there's a (completely unsupported and not fully tested) version of the WebPreviewer.swf that has the English strings built-in by default here: http://mikehatfield-alfresco.s3.amazonaws.com/WebPreviewer.swf.zip
<embed type="application/x-shockwave-flash"

   src="http://<server>:<port>/share/components/preview/WebPreviewer.swf"

   width="670px"

   height="670px"

   id="WebPreviewer"

   name="WebPreviewer"

   quality="high"

   allowscriptaccess="sameDomain"

   allowfullscreen="true"

   wmode="transparent"

   flashvars="fileName=aaar.png&amp;paging=false&amp;url=http%3A%2F%2Flocalhost%3A8080%2Falfresco%2Fservice%2Fapi%2Fnode%2Fworkspace%2FSpacesStore%2F15ddb4a8-63a5-4bf3-95a8-4d121d2eaed2%2Fcontent%3Fc%3Dforce%26noCacheToken%3D1257980553515%26guest%3Dtrue&amp;show_fullscreen_button=true" />
Thanks,
Mike

*/ ?>

</body>
</html>

