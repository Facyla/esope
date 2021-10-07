<?php
$plugin = elgg_extract('entity', $vars);

$url = elgg_get_site_url();

// Define select options
$yn_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$ny_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

// Preset / default configuration
if (empty($plugin->js_config)) {
	$plugin->js_config = '
	"privacyUrl": "", /* Privacy policy url */

	"hashtag": "#tarteaucitron", /* Open the panel with this hashtag */
	"cookieName": "gdpr-tarteaucitron", /* Cookie name */

	"orientation": "bottom", /* Banner position (top - bottom) */

	"groupServices": false, /* Group services by category */
	
	"showAlertSmall": true, /* Show the small banner on bottom right */
	"cookieslist": false, /* Show the cookie list */
	
	"closePopup": false, /* Show a close X on the banner */

	"showIcon": true, /* Show cookie icon to manage cookies */
	//"iconSrc": "", /* Optionnal: URL or base64 encoded image */
	"iconPosition": "BottomLeft", /* BottomRight, BottomLeft, TopRight and TopLeft */

	"adblocker": false, /* Show a Warning if an adblocker is detected */
	
	"DenyAllCta" : true, /* Show the deny all button */
	"AcceptAllCta" : true, /* Show the accept all button when highPrivacy on */
	"highPrivacy": true, /* HIGHLY RECOMMANDED Disable auto consent */
	
	"handleBrowserDNTRequest": false, /* If Do Not Track == 1, disallow all */

	"removeCredit": true, /* Remove credit link */
	"moreInfoLink": true, /* Show more info link */

	"useExternalCss": false, /* If false, the tarteaucitron.css file will be loaded */
	"useExternalJs": false, /* If false, the tarteaucitron.js file will be loaded */

	//"cookieDomain": ".my-multisite-domaine.fr", /* Shared cookie for multisite */
	
	"readmoreLink": "", /* Change the default readmore link */

	"mandatory": true, /* Show a message about mandatory cookies */
';
}


echo '<h3>Paramètres de configuration</h3>';
echo '<p>' . elgg_view('output/url', ['href' => "https://tarteaucitron.io/fr/install/", 'text' => elgg_echo('tarteaucitron:settings:url_install')]) . '</p>';
echo '<p>' . elgg_view('output/url', ['href' => "https://github.com/AmauriC/tarteaucitron.js", 'text' => elgg_echo('tarteaucitron:settings:url_github')]) . '</p>';


// Configuration JS de tarteaucitron
echo '<div><label>' . elgg_echo('tarteaucitron:settings:enable_banner') . ' ' . elgg_view('input/select', ['name' => 'params[enable_banner]', 'value' => $plugin->enable_banner, 'options_values' => $yn_opt]) . '</label></div>';
echo '<div><label>' . elgg_echo('tarteaucitron:settings:js_config') . ' ' . elgg_view('input/plaintext', ['name' => 'params[js_config]', 'value' => $plugin->js_config]) . '</label></div>';

echo '<div><label>' . elgg_echo('tarteaucitron:settings:js_services') . ' ' . elgg_view('input/plaintext', ['name' => 'params[js_services]', 'value' => $plugin->js_services]) . '</label></div>';


