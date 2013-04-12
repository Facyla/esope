<?php
/**
 * User blog widget display view
 */

$widget_url = $vars['entity']->url;

if (!empty($widget_url)) {
  echo '<iframe src="' . html_entity_decode($widget_url) . '" style="height:600px; overflow-y:auto; width:288px;">Chargement en cours</iframe>';
} else {
  echo "Veuillez configurer le widget !";
}

