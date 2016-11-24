<?php
$title = elgg_echo('elgg_cmis:title');
$content = '';

$own = elgg_get_logged_in_user_entity();
$own_guid = elgg_get_logged_in_user_guid();

require_once elgg_get_plugins_path() . 'elgg_cmis/vendors/chemistry-phpclient/atom/cmis-lib.php';



$cmis_url = elgg_get_plugin_setting('cmis_url', 'elgg_cmis');
$atom_url = elgg_get_plugin_setting('cmis_atom_url', 'elgg_cmis');
$repo_url = $cmis_url . $atom_url;
//$repo_url = elgg_get_plugin_setting('user_cmis_url', $own_guid, 'elgg_cmis'); // Custom repo
$repo_username = elgg_get_plugin_user_setting('cmis_login', $own_guid, 'elgg_cmis');
$repo_password = elgg_get_plugin_user_setting('cmis_password2', $own_guid, 'elgg_cmis');
$key = $own->guid . $own->salt;
if (!empty($repo_password)) {
	$repo_password = base64_decode($repo_password);
	$repo_password = esope_vernam_crypt($repo_password, $key);
}
$repo_debug = elgg_get_plugin_setting('debugmode', 'elgg_cmis', false);
if ($repo_debug == 'yes') $repo_debug = true; else $repo_debug = false;

if ($repo_debug) $content .= "URL : $repo_url<br />Identifiant : $repo_username<br />Mot de passe : $repo_password<br />";

if (empty($repo_url) || empty($repo_username) || empty($repo_password)) {
	echo 'WARNING : required parameters are missing - please <a href="' . elgg_get_site_url() . 'settings/plugins/' . $own->username . '" target="_new">update your user CMIS plugin settings</a>';
	exit;
}



# Licensed to the Apache Software Foundation (ASF) under one
# or more contributor license agreements.	See the NOTICE file
# distributed with this work for additional information
# regarding copyright ownership.	The ASF licenses this file
# to you under the Apache License, Version 2.0 (the
# "License"); you may not use this file except in compliance
# with the License.	You may obtain a copy of the License at
# 
# http://www.apache.org/licenses/LICENSE-2.0
# 
# Unless required by applicable law or agreed to in writing,
# software distributed under the License is distributed on an
# "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
# KIND, either express or implied.	See the License for the
# specific language governing permissions and limitations
# under the License.


$client = new CMISService($repo_url, $repo_username, $repo_password);

if ($repo_debug) {
		$content .= "Repository Information:<br />===========================================<br />";
		$content .= print_r($client->workspace, true);
		$content .= "<br />===========================================<br /><br />";
}

$objs = $client->query("select * from cmis:folder");
if ($repo_debug) {
		$content .= "Returned Objects<br />:<br />===========================================<br />";
		$content .= print_r($objs, true);
		$content .= "<br />===========================================<br /><br />";
}

if ($objs) foreach ($objs->objectList as $obj) {
		if ($obj->properties['cmis:baseTypeId'] == "cmis:document") {
				$content .= "Document: " . $obj->properties['cmis:name'] . "<br />";
		} elseif ($obj->properties['cmis:baseTypeId'] == "cmis:folder") {
				$content .= "Folder: " . $obj->properties['cmis:name'] . "<br />";
		} else {
				$content .= "Unknown Object Type: " . $obj->properties['cmis:name'] . "<br />";
		}
}

if ($repo_debug > 2) {
		$content .= "Final State of CLient:<br />===========================================<br />";
		$content .= print_r($client, true);
}

if (!empty($content)) {
	$content = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => false));
	echo elgg_view_page($title, $content);
}

