<?php
global $CONFIG;

// Doc : see https://togetherjs.com/docs/#extending-togetherjs
if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	$username = $own->name;
	$usericon = $own->getIconURL('small');
}

?>
<script>
	// Use own server
	//var TogetherJSConfig_hubBase = "http://127.0.0.1:10005";
	
var TogetherJSConfig_siteName = "<?php echo $CONFIG->site->name ?>";
var TogetherJSConfig_toolName = "TogetherJS";
var TogetherJSConfig_findRoom = "Global"
var TogetherJSConfig_inviteFromRoom = true;
var TogetherJSConfig_dontShowClicks = true;
var TogetherJSConfig_suppressInvite = true;
var TogetherJSConfig_suppressJoinConfirmation = true;
var TogetherJSConfig_disableWebRTC = true;
var TogetherJSConfig_getUserName = function () { return '<?php echo $username; ?>'; };
var TogetherJSConfig_getUserAvatar = function () { return '<?php echo $usericon; ?>'; };
//var TogetherJSConfig_tinymce = true;

//var target = tinyMCE.activeEditor.id;
//var content = tinyMCE.activeEditor.getContent();


var TogetherJSConfig_on_ready = function () {
	
	var TinyMCEEditor = util.Class({
		
		trackerName: "TinyMCEEditor",
		
		constructor: function (el) {
			//this.element = $(el)[0];
			assert($(this.element).hasClass("elgg-input-longtext"));
			this.element = tinyMCE.activeEditor.id;
			this._change = this._change.bind(this);
			this._editor().document.on("change", this._change);
		},

		tracked: function (el) {
			return this.element === $(el)[0];
		},

		destroy: function (el) {
			this._editor().document.removeListener("change", this._change);
		},

		update: function (msg) {
			this._editor().document.setValue(msg.value);
		},

		init: function (update, msg) {
			this.update(update);
		},

		makeInit: function () {
			return {
			  element: this.element,
			  tracker: this.trackerName,
			  value: this._editor().document.getValue()
			};
		},

		_editor: function () {
			return this.element.env;
		},

		_change: function (e) {
			// FIXME: I should have an internal .send() function that automatically
			// asserts !inRemoteUpdate, among other things
			if (inRemoteUpdate) {
			  return;
			}
			sendData({
			  tracker: this.trackerName,
			  element: this.element,
			  value: this.getContent()
			});
		},

		getContent: function() {
			return this._editor().document.getValue();
		}
	});

	TinyMCEEditor.scan = function () {
		return $(".elgg-input-longtext");
	};

	TinyMCEEditor.tracked = function (el) {
		return !! $(el).closest(".elgg-input-longtext").length;
	};
	
	// skip setInit
	TogetherJS.addTracker(TinyMCEEditor, true);
	
};


// @TODO : don't load it always : use register and load in calling pages instead...
</script>
<script src="https://togetherjs.com/togetherjs.js"></script>

<script>
/*
TogetherJS.hub.on("app.tinymceUpdate", function (msg) {
	console.log("TEST 1");
	//var elementFinder = TogetherJS.require("elementFinder");
	// If the element can't be found this will throw an exception:
	//var element = elementFinder.findElement(msg.element);
	tinyMCE.get(msg.element).setContent(msg.value, {format : 'raw'});
});
*/

TogetherJS.hub.on("form-update", function (msg) {
	console.log("TEST 2");
	newcontent = msg.value;
	tinyMCE.get(msg.element).setContent(newcontent, {format : 'raw'});
});

TogetherJS.hub.on("app.form-update", function (msg) {
	console.log("TEST 3");
	newcontent = msg.value;
	tinyMCE.get(msg.element).setContent(newcontent, {format : 'raw'});
});



</script>

