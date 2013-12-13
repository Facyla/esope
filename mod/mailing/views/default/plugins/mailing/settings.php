<?php
global $CONFIG;
?>

<p>Pour certains serveurs : changer le séparateur d'headers (EOL)
	<?php echo elgg_view('input/dropdown', array('name' => 'params[use_eol]', 'options_values' => array('rn' => "RN (par défaut)", 'n' => "N (si envois TEXT avec RN)"), 'value' => $vars['entity']->use_eol)); ?>
</p>

<p>Adresse d'expédition et/ou de réponse supplémentaire (la liste des adresses d'envoi possibles comprend : adresse du site, adresse de l'envoyeur + adresse de réponse + celle-ci)<br />Saisissez l'adresse mail seule : <strong>utilisateur@domaine.tld</strong>
	<?php echo elgg_view('input/text', array( 'name' 	=> 'params[sender]', 'value' 	=> $vars['entity']->sender )); ?>
</p>

<p>Nom de l'adresse d'expédition et/ou de réponse supplémentaire correspondant à l'adresse (par ex.: <?php echo $CONFIG->sitename; ?>)
	<?php echo elgg_view('input/text', array( 'name' 	=> 'params[sendername]', 'value' 	=> $vars['entity']->sendername )); ?>
</p>

<p>Titre par défaut du mailing (peut être modifié avant envoi).<br /><em>Vider le contenu et enregistrer pour retrouver la valeur par défaut initiale.</em>
	<?php
	if (empty($vars['entity']->subject)) echo elgg_view('input/text', array( 'name' 	=> 'params[subject]', 'value' 	=> elgg_echo('mailing:form:default:subject') ));
	else echo elgg_view('input/text', array( 'name' 	=> 'params[subject]', 'value' 	=> $vars['entity']->subject ));
	?>
</p>

<p>Contenu par défaut du mailing (peut être modifié avant envoi), en HTML seulement.<br /><em>Vider le contenu et enregistrer pour retrouver la valeur par défaut initiale.</em>
	<?php
	if (empty($vars['entity']->message)) echo elgg_view('input/longtext', array( 'name' 	=> 'params[message]', 'value' 	=> elgg_echo('mailing:form:default:message') ));
	else echo elgg_view('input/longtext', array( 'name' 	=> 'params[message]', 'value' 	=> $vars['entity']->message ));
	?>
</p>

<p>
	<a href="<?php echo $CONFIG->url . 'mod/mailing/mailing.php'; ?>">Envoyer un mailing</a>
</p>

