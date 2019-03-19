ReCAPTCHA plugin
================

This plugin provides the views and settings to support reCAPTCHA on your site


## Get started
1. Enable the plugin
2. In plugin's settings, click on the link to create a new public/secret key (and an account if needed)
3. Set your public and private keys


## Default behaviour
* 2 actions are verified using reCAPTCHA: 'register' and 'user/requestnewpassword'
* reCAPTCHA is also added to any form using the 'input/captcha' view

Notes:
* verification is not performed if public and secret key are not set
* captcha view is not replaced but extended with reCAPTCHA, so you can use simultaneously several captcha methods


## Checking new actions
You can easily check new actions by extending the proper views and actions:
1. Extend the form view with 'input/recaptcha':
	elgg_extend_view('form/pluginname/formname', 'input/recaptcha');
2. Hook into the corresponding action to add the reCAPTCHA hook:
	elgg_register_plugin_hook_handler("action", 'pluginname/formname', 'recaptcha_verify_hook');


## Troubleshooting
If reCaptcha is not displayed, there may be several causes: 
* Users may have disabled JavaScript: it is required for reCaptcha to work
* If accessed from China, google.com is blocked: use plugin setting option to update the script source URL and set it to www.recaptcha.net


## Developpers tips
Developpers can also use an alternate method to allow the use of several public/secret keys, or get the keys from other plugins:

1. Add the input view into the wanted form:
	echo elgg_view('input/recaptcha', array('publickey' => 'custom_public_key'));
2. Check the provided response into the corresponding action:
	$verified = recaptcha_verify($response, $secretkey);


## History
* 2.3.1 : 20190319 - settings: add alternative script source URL option
* 2.3 : 20171114 - use AMD for JS
* 1.12.0 : 20160723 - Update to Elgg 1.12
  * do not block if settings are not set
  * alert if settings are not set
* 0.1 : 20150710 - Initial release
  * plugin structure
  * views
  * settings


