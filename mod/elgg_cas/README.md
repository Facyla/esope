= Elgg CAS =
This plugin provides CAS authentication. 

== Installation
1. Enable plugin
2. Configure it wether through settings page OR with a hardcoded file
3. Cas login can be performed on SITE/cas_auth - You may need to add the proper link in your theme



== Options

Autologin : works only on home page. Detects existing CAS authentication, and attempts to log in user.
Create account : requires LDAP plugin (ldap_auth) to get more information for the user


== Library versions and patch for openssl <= 0.9.8
Note : when used with openssl OpenSSL 0.9.8k, CAS authentication will fail
Please choose lib 1.3.2 (already patched) or apply patch to chosen library version
Patch : must be applied in Request/CurlRequest and CurlMultiRequest :
=> add curl_setopt($ch, CURLOPT_SSLVERSION,3); before calling curl
curl_setopt($handle, CURLOPT_SSLVERSION,CURL_SSLVERSION_TLSv1_2);
Since SSL3 security issues, you may want to update it to (requires testing) :
   curl_setopt($handle, CURLOPT_SSLVERSION,CURL_SSLVERSION_TLSv1_2);
See http://stackoverflow.com/questions/8619706/running-curl-with-openssl-0-9-8-against-openssl-1-0-0-server-causes-handshake-er


