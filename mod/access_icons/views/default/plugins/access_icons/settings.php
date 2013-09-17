<?php
/**
 * ADF_platform plugin settings
 * Params :
 * - contenu de la bannière (HTML insérable)
 * - hauteur de la bannière
 * - image de fond du header
 * - hauteur du header
 * - contenu du footer (HTML insérable)
 * - éléments de la page d'accueil : afficher les stats
 *
*/

$url = $vars['url'];

?>
<p><label><?php echo elgg_echo('access_icons:settings:helpurl'); ?></label><br />
	<?php echo elgg_echo('access_icons:settings:helpurl:help'); ?><br />
	<?php echo $url . elgg_view('input/text', array( 'name' => 'params[helpurl]', 'value' => $vars['entity']->helpurl, 'js' => 'style="width:50%;"' )); ?>
</p><br />


