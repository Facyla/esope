<?php
/**
 * Elgg pages widget
 *
 * @package ElggPages
 */

//$num = (int) $vars['entity']->pages_num;

$widget_id = $vars['entity']->guid;
$display_all = false;

$content = '';

/*
// Si un outil est choisi (et valide), on prend les bonnes valeurs pour l'afficher
if (!empty($vars['entity']->tool) && ($vars['entity']->tool != 'all')) {
	switch($vars['entity']->tool) {
		case 'forge':
			$url = 'https://gforge.inria.fr/';
			$title = elgg_echo('theme_inria:topbar:forge');
			break;
		case 'notepad':
			$url = 'https://notepad.inria.fr/';
			$title = elgg_echo('theme_inria:topbar:notepad');
			break;
		case 'framadate':
			$url = 'http://www.framadate.org/';
			$title = elgg_echo('theme_inria:topbar:framadate');
			break;
		case 'webinar':
			$url = 'http://qlf-devinar.inria.fr/';
			$title = elgg_echo('theme_inria:topbar:webinar');
			break;
		case 'ftp':
			$url = 'https://transfert.inria.fr/';
			$title = elgg_echo('theme_inria:topbar:ftp');
			break;
		case 'share':
			$url = 'https://partage.inria.fr';
			$title = elgg_echo('theme_inria:topbar:share');
			break;
		case 'confcall':
			$url = 'http://intranet.irisa.fr/irisa/services/pavu/documentation/audioconf#resa';
			$title = elgg_echo('theme_inria:topbar:confcall');
			break;
		case 'evo':
			$url = 'http://dsi.inria.fr/services_offerts/visio/EVO';
			$title = elgg_echo('theme_inria:topbar:evo');
			break;
		case 'mailinglist':
			$url = 'https://sympa.inria.fr/';
			$title = elgg_echo('theme_inria:topbar:mailinglist');
			break;
		case 'mailer':
			$url = 'https://zimbra.inria.fr';
			$title = elgg_echo('theme_inria:topbar:mailer');
			break;
		case 'mission':
			$url = 'https://portail-izi.inria.fr';
			$title = elgg_echo('theme_inria:topbar:mission');
			break;
		case 'mission2':
			$url = 'https://portail-izi.inria.fr/oreli';
			$title = elgg_echo('theme_inria:topbar:mission2');
			break;
		case 'holidays':
			$url = 'https://casa.inria.fr';
			$title = elgg_echo('theme_inria:topbar:holidays');
			break;
		case 'annuaire':
			$url = 'https://annuaire.inria.fr/';
			$title = elgg_echo('theme_inria:topbar:annuaire');
			break;
		case 'tickets':
			$url = 'https://tickets.inria.fr/';
			$title = elgg_echo('theme_inria:topbar:tickets');
			break;
		case 'all':
		default:
			$display_all = true;
			$title = elgg_echo('theme_inria:topbar:all');
	}
}


if ($display_all) {
	?>
	<table style="width:100%;">
		<tr>
			<td style="width:45%;">
				 <a target="blank" class="elgg-button elgg-button-action" href="https://gforge.inria.fr/"><?php echo elgg_echo('theme_inria:topbar:forge'); ?></a><br />
				 <br /><a target="blank" class="elgg-button elgg-button-action" href="https://notepad.inria.fr/"><?php echo elgg_echo('theme_inria:topbar:notepad'); ?></a><br />
				 <br /><a target="blank" class="elgg-button elgg-button-action" href="http://www.framadate.org/"><?php echo elgg_echo('theme_inria:topbar:framadate'); ?></a><br />
				 <br /><a target="blank" class="elgg-button elgg-button-action" href="http://qlf-devinar.inria.fr/"><?php echo elgg_echo('theme_inria:topbar:webinar'); ?></a><br />
				 <br /><a target="blank" class="elgg-button elgg-button-action" href="https://transfert.inria.fr/"><?php echo elgg_echo('theme_inria:topbar:ftp'); ?></a><br />
				 <br /><a target="blank" class="elgg-button elgg-button-action" href="https://partage.inria.fr"><?php echo elgg_echo('theme_inria:topbar:share'); ?></a><br />
				 <br /><a target="blank" class="elgg-button elgg-button-action" href="http://intranet.irisa.fr/irisa/services/pavu/documentation/audioconf#resa"><?php echo elgg_echo('theme_inria:topbar:confcall'); ?></a><br />
				 <br /><a target="blank" class="elgg-button elgg-button-action" href="http://dsi.inria.fr/services_offerts/visio/EVO">EVO</a><br />
				 <br /><a target="blank" class="elgg-button elgg-button-action" href="https://https://sympa.inria.fr//"><?php echo elgg_echo('theme_inria:topbar:mailinglist'); ?></a><br />
			</td>
			<td>
				<a target="blank" class="elgg-button elgg-button-action" href="https://www.inria.fr" class="menuitemtools"><?php echo elgg_echo('theme_inria:topbar:inria'); ?></a>
				<ul>
					<br /><a target="blank" class="elgg-button elgg-button-action" href="https://zimbra.inria.fr"><?php echo elgg_echo('theme_inria:topbar:mailer'); ?></a><br />
					<br /><a target="blank" class="elgg-button elgg-button-action" href="https://portail-izi.inria.fr"><?php echo elgg_echo('theme_inria:topbar:mission'); ?></a><br />
					<br /><a target="blank" class="elgg-button elgg-button-action" href="https://portail-izi.inria.fr/oreli"><?php echo elgg_echo('theme_inria:topbar:mission2'); ?></a><br />
					<br /><a target="blank" class="elgg-button elgg-button-action" href="https://casa.inria.fr"><?php echo elgg_echo('theme_inria:topbar:holidays'); ?></a><br />
					<br /><a target="blank" class="elgg-button elgg-button-action" href="https://annuaire.inria.fr/"><?php echo elgg_echo('theme_inria:topbar:annuaire'); ?></a><br />
					<br /><a target="blank" class="elgg-button elgg-button-action" href="https://tickets.inria.fr/"><?php echo elgg_echo('theme_inria:topbar:tickets'); ?></a><br />
				</ul>
			</td>
		</tr>
	</table>
	<?php
	
} else {
	
	echo '<h3 style="font-size:20px; float:none;">' . $title . '</h3>';
	if ($description) echo '<p>' . $description . '</p>';
	echo '<a target="blank" class="elgg-button elgg-button-action" href="' . $url . '" title="Ouvrir ' . $title . ' dans une nouvelle fenêtre">Ouvrir ' . $title . '</a>';
}
*/


// This array should be identical to the one in edit view...
$options_values = array(
		// val => title
		//'all' => elgg_echo('theme_inria:topbar:all'),
		'forge' => elgg_echo('theme_inria:topbar:forge'),
		'notepad' => elgg_echo('theme_inria:topbar:notepad'),
		'framadate' => elgg_echo('theme_inria:topbar:framadate'),
		'webinar' => elgg_echo('theme_inria:topbar:webinar'),
		'ftp' => elgg_echo('theme_inria:topbar:ftp'),
		'share' => elgg_echo('theme_inria:topbar:share'),
		'confcall' => elgg_echo('theme_inria:topbar:confcall'),
		'evo' => elgg_echo('theme_inria:topbar:evo'),
		'mailinglist' => elgg_echo('theme_inria:topbar:mailinglist'),
		'mailer' => elgg_echo('theme_inria:topbar:mailer'),
		'mission' => elgg_echo('theme_inria:topbar:mission'),
		'mission2' => elgg_echo('theme_inria:topbar:mission2'),
		'holidays' => elgg_echo('theme_inria:topbar:holidays'),
		'annuaire' => elgg_echo('theme_inria:topbar:annuaire'),
		'tickets' => elgg_echo('theme_inria:topbar:tickets'),
	);

foreach ($options_values as $opt => $name) {
	if ($vars['entity']->{$opt} == 'yes') {
		switch($vars['entity']->{$opt}) {
			case 'forge': $url = 'https://gforge.inria.fr/'; break;
			case 'notepad': $url = 'https://notepad.inria.fr/'; break;
			case 'framadate': $url = 'http://www.framadate.org/'; break;
			case 'webinar': $url = 'http://qlf-devinar.inria.fr/'; break;
			case 'ftp': $url = 'https://transfert.inria.fr/'; break;
			case 'share': $url = 'https://partage.inria.fr'; break;
			case 'confcall': $url = 'http://intranet.irisa.fr/irisa/services/pavu/documentation/audioconf#resa'; break;
			case 'evo': $url = 'http://dsi.inria.fr/services_offerts/visio/EVO'; break;
			case 'mailinglist': $url = 'https://sympa.inria.fr/'; break;
			case 'mailer': $url = 'https://zimbra.inria.fr'; break;
			case 'mission': $url = 'https://portail-izi.inria.fr'; break;
			case 'mission2': $url = 'https://portail-izi.inria.fr/oreli'; break;
			case 'holidays': $url = 'https://casa.inria.fr'; break;
			case 'annuaire': $url = 'https://annuaire.inria.fr/'; break;
			case 'tickets': $url = 'https://tickets.inria.fr/'; break;
		}
		$content .= '<a target="_blank" class="inria-tool-link inria-tool-'.$opt.'" href="' . $url . '" title="Ouvrir ' . $name . ' dans une nouvelle fenêtre">' . $name . '</a>';
	}
}

if (empty($content)) {
	echo "<p>Veuillez choisir les outils que vous souhaitez afficher.</p>";
} else echo $content;
?>

<style>
#elgg-widget-<?php echo $widget_id; ?> header h2:after { content: ": <?php echo $title; ?>"; }
</style>

