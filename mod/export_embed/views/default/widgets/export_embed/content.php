<?php
/**
 * User blog widget display view
 */

$embedurl = $vars['entity']->embedurl;

if (empty($embedurl)) {
  $site_url = $vars['entity']->site_url;
  $embedtype = $vars['entity']->embedtype;
  $embedparams = $vars['entity']->params;
}

if (empty($embedurl)) $embedurl = $vars['url'] . 'embed'; // En local => Aide du widget

echo '<iframe src="' . html_entity_decode($embedurl) . '" style="height:600px; overflow-y:auto; width:288px;">Chargement en cours</iframe>';

