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

$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );

$no_yes_force_opt = $no_yes_opt;
$no_yes_force_opt['force'] = elgg_echo('option:force');

$no_yes_groupoption_opt = $no_yes_opt;
$no_yes_groupoption_opt['groupoption'] = elgg_echo('option:groupoption');

$replace_homepage_opt = $no_yes_opt;
$replace_public_homepage_opt = array('default' => elgg_echo('adf_platform:replacehome:default'), 'cmspages' => elgg_echo('adf_platform:replacehome:cmspages'), 'no' => elgg_echo('adf_platform:replacehome:no') );

$groups_discussion_opt = $yes_no_opt;
$groups_discussion_opt['always'] = elgg_echo('adf_platform:settings:groups:discussion:always');

$group_tools_default_opt = $no_yes_opt;
$group_tools_default_opt['auto'] = elgg_echo('adf_platform:settings:groups:tools_default:auto');

$groups_disable_widgets_opt = $no_yes_opt;
$groups_disable_widgets_opt['public'] = elgg_echo('esope:groups:disable_widgets:public');
$groups_disable_widgets_opt['loggedin'] = elgg_echo('esope:groups:disable_widgets:loggedin');

$pages_list_subpages_opt = $no_yes_opt;
$pages_list_subpages_opt['user'] = elgg_echo('adf_platform:settings:pages_list_subpages:user');
$pages_list_subpages_opt['group'] = elgg_echo('adf_platform:settings:pages_list_subpages:group');
//$pages_list_subpages_opt['all'] = elgg_echo('adf_platform:settings:pages_list_subpages:all');

$registered_objects = get_registered_entity_types('object');

$group_defaultaccess_opt = array('default' => elgg_echo('adf_platform:groupdefaultaccess:default'), 'groupvis' => elgg_echo('adf_platform:groupdefaultaccess:groupvis'), 'group' => elgg_echo('adf_platform:groupdefaultaccess:group'), 'members' => elgg_echo('adf_platform:groupdefaultaccess:members'), 'public' => elgg_echo('adf_platform:groupdefaultaccess:public'));

$group_groupjoin_enablenotif_opt = array(
		'email' => elgg_echo('option:notify:email'),
		'site' => elgg_echo('option:notify:site'),
		'all' => elgg_echo('option:notify:all'),
		'no' => elgg_echo('option:notify:no'),
	);

$invite_picker_opt = array(
		'friendspicker' => elgg_echo('adf_platform:invite_picker:friendspicker'),
		'userpicker' => elgg_echo('adf_platform:invite_picker:userpicker'),
	);


// SET DEFAULT VALUES

/* Unused since new theme w/ Urbilog
// Banner content
if (!isset($vars['entity']->header) || ($vars['entity']->header == 'RAZ')) { $vars['entity']->header = elgg_echo('adf_platform:header:default'); }
// header background URL
if (strlen($vars['entity']->headbackground) == 0) { $vars['entity']->headbackground = $url . 'mod/adf_public_platform/img/headimg.jpg'; }
// header background height
if (strlen($vars['entity']->headheight) == 0) { $vars['entity']->headheight = 330; }
// Footer content
if (strlen($vars['entity']->footer) == 0) { $vars['entity']->footer = elgg_echo('adf_platform:footer:default'); }
*/

// Homepage replacement
if (empty($vars['entity']->replace_public_homepage)) { $vars['entity']->replace_public_homepage == 'default'; }

// No stats on homepage
if (strlen($vars['entity']->displaystats) == 0) { $vars['entity']->displaystats = 'no'; }

// Header image
//if (empty($vars['entity']->headerimg)) { $vars['entity']->headerimg = 'mod/adf_public_platform/img/theme/departement.png'; }
if (empty($vars['entity']->backgroundcolor)) { $vars['entity']->backgroundcolor = '#efeeea'; }
//if (empty($vars['entity']->backgroundimg)) { $vars['entity']->backgroundimg = 'mod/adf_public_platform/img/theme/motif_fond.jpg'; }

// STYLES : see css/elgg view for style load & use
// Set default colors - theme ADF
// Titles
if (empty($vars['entity']->titlecolor)) { $vars['entity']->titlecolor = '#0A2C83'; }
if (empty($vars['entity']->textcolor)) { $vars['entity']->textcolor = '#333333'; }
// Links
if (empty($vars['entity']->linkcolor)) { $vars['entity']->linkcolor = '#002E6E'; }
if (empty($vars['entity']->linkhovercolor)) { $vars['entity']->linkhovercolor = '#0A2C83'; }
// Header-footer color + various other use (menu + input borders and focus...)
if (empty($vars['entity']->color1)) { $vars['entity']->color1 = '#0050BF'; }
if (empty($vars['entity']->color4)) { $vars['entity']->color4 = '#002E6E'; }
// Widget + Group modules
if (empty($vars['entity']->color2)) { $vars['entity']->color2 = '#F75C5C'; }
if (empty($vars['entity']->color3)) { $vars['entity']->color3 = '#C61B15'; }
// Buttons
if (empty($vars['entity']->color5)) { $vars['entity']->color5 = '#014FBC'; }
if (empty($vars['entity']->color6)) { $vars['entity']->color6 = '#033074'; }
if (empty($vars['entity']->color7)) { $vars['entity']->color7 = '#FF0000'; }
if (empty($vars['entity']->color8)) { $vars['entity']->color8 = '#990000'; }
// Module title
if (empty($vars['entity']->color14)) { $vars['entity']->color14 = '#FFFFFF'; }
// Button title
if (empty($vars['entity']->color15)) { $vars['entity']->color15 = '#FFFFFF'; }
// Divers Gris - utilisés dans interface essentiellement (mieux vaut ne pas modifier)
if (empty($vars['entity']->color9)) { $vars['entity']->color9 = '#CCCCCC'; }
if (empty($vars['entity']->color10)) { $vars['entity']->color10 = '#999999'; }
if (empty($vars['entity']->color11)) { $vars['entity']->color11 = '#333333'; }
if (empty($vars['entity']->color12)) { $vars['entity']->color12 = '#DEDEDE'; }
// Sub-menu
if (empty($vars['entity']->color13)) { $vars['entity']->color13 = '#CCCCCC'; }
// Fonts
if (empty($vars['entity']->font1)) { $vars['entity']->font1 = 'Lato, sans-serif'; }
if (empty($vars['entity']->font2)) { $vars['entity']->font2 = 'Lato-bold, sans-serif'; }
if (empty($vars['entity']->font3)) { $vars['entity']->font3 = 'Puritan, sans-serif'; }
if (empty($vars['entity']->font4)) { $vars['entity']->font4 = 'Puritan, Arial, sans-serif'; }
if (empty($vars['entity']->font5)) { $vars['entity']->font5 = 'Monaco, "Courier New", Courier, monospace'; }
if (empty($vars['entity']->font6)) { $vars['entity']->font6 = 'Georgia, times, serif'; }

// Footer background color
//if (empty($vars['entity']->footercolor)) { $vars['entity']->footercolor = '#555555'; }
// Additionnal CSS content - loaded at the end
if (strlen($vars['entity']->css) == 0) { $vars['entity']->css = elgg_echo('adf_platform:css:default'); }

// Footer
if (!isset($vars['entity']->footer) || ($vars['entity']->footer == 'RAZ')) {
	$vars['entity']->footer = '<ul>
				<li><a href="#">Charte</a></li>
				<li><a href="#">Mentions légales</a></li>
				<li><a href="#">A propos</a></li>
				<li><a href="#">Contact</a></li>
			</ul>
			<a href="#" target="_blank"><img src="' . $url . 'mod/theme_yourtheme/graphics/logo.png" alt="Logo" /></a>';
}

if (empty($vars['entity']->opengroups_defaultaccess)) { $vars['entity']->opengroups_defaultaccess = 'groupvis'; }
if (empty($vars['entity']->closedgroups_defaultaccess)) { $vars['entity']->closedgroups_defaultaccess = 'group'; }
if (empty($vars['entity']->awesomefont)) $vars['entity']->awesomefont = 'yes';
if (empty($vars['entity']->fixedwidth)) $vars['entity']->fixedwidth = 'no';

// Set default Wire access
if (empty($vars['entity']->thewire_default_access)) { $vars['entity']->thewire_default_access = 'default'; }

// Hide by default some profile fields that are known to be used for configuration but should not be displayed
if (!isset($vars['entity']->group_hide_profile_field)) { $vars['entity']->group_hide_profile_field = 'customcss, cmisfolder, feed_url, customtab1, customtab2, customtab3, customtab4, customtab5, customtab6, customtab7, customtab8'; }

//Set archive and old group marker
if (empty($vars['entity']->groups_archive)) $vars['entity']->groups_archive = 'yes';
if (empty($vars['entity']->groups_old_display)) $vars['entity']->groups_old_display = 'yes';
if (empty($vars['entity']->groups_old_timeframe)) $vars['entity']->groups_old_timeframe = 15552000; // 3600 * 24 * 30 * 6 (about 6 months)



// CORRECT BAD-FORMATTED VALUES
// Remove spaces
if (!empty($vars['entity']->remove_user_tools) && (strpos($vars['entity']->remove_user_tools, ' ') != false)) $vars['entity']->remove_user_tools = str_replace(' ', '', $vars['entity']->remove_user_tools);



// Restauration d'une sauvegarde précédente :
if (!empty($vars['entity']->import_settings)) {
	$import_settings = $vars['entity']->import_settings;
	echo "<h3>Restauration des paramètres</h3>";
	$import_settings = html_entity_decode($import_settings, ENT_QUOTES, 'UTF-8');
	$import_settings = mb_decode_numericentity($import_settings, array (0x0, 0xffff, 0, 0xffff), 'UTF-8');
	//$import_settings = convert_uudecode($import_settings);
	if ($import_settings = unserialize($import_settings)) {
		echo "Lecture des données de restauration...OK<br />";
		// Pas besoin de tout supprimer : on peut se contenter de mettre à jour ce qui est spéifié, et uniquement ça (évite de virer de nouveaux champs par exemple)
		//$vars['entity']->unsetAllSettings();
		//echo "Suppression anciens paramètres...OK<br />";
		$restore_count = 0;
		$restore_same = 0;
		$restore_updated = 0;
		foreach ($import_settings as $name => $value) {
			$restore_count++;
			if ($name == 'import_settings') continue;
			$old = htmlentities($vars['entity']->$name, ENT_QUOTES, 'UTF-8');
			$new = htmlentities($value, ENT_QUOTES, 'UTF-8');
			if ($old == $new) {
				//echo "<strong>$name : <strong>non modifié</strong> => $new";
				$restore_same++;
			} else {
				echo "<strong>$name : Restauration des paramètres fournis</strong><br />$old &nbsp; <strong style=\"color:red\"> => </strong> &nbsp; $new<hr />";
				$vars['entity']->setSetting($name, $value);
				$restore_updated++;
			}
		}
		$vars['entity']->import_settings = null;
		$restore_report = "Restauration de vos paramètres terminée !  $restore_count paramètres lus, et $restore_updated modifiés ($restore_same identiques).<br />";
		system_message($restore_report);
	} else register_error("Erreur lors de la restauration des paramètres : données invalides.");
}



/*
// Tests avec tabs : non finalisés // en fait c'est mieux avec des onglets en accordéon..
$class = "adf-settings";
$tabs[] = array('title' => "Config générale", 'url' => "#general", 'id' => "adf-settings-general", 'class' => $class);
$tabs[] = array('title' => "Interface", 'url' => "#interface", 'id' => "adf-settings-interface", 'class' => $class);
$tab_content = '<div id="adf-settings-general" class="adf-settings">Config générale</div>
<div id="adf-settings-interface" class="adf-settings">Config interface</div>';
echo '<div id="adf-settings-tabs">
	<?php echo elgg_view('navigation/tabs', array('tabs' => $tabs)); ?>
</div>
<div id="adf-settings-wrapper">
	<?php echo $tab_content; ?>
</div>';
*/

/* SETTINGS SECTIONS
	* page d'accueil publique
	* page d'accueil connectée
	* Interface
	* Comportements
	* Groupes
	* Membres et annuaire
	* Widgets
	* Styles
	* Expert
	* Import/export
	
*/

?>
<script type="text/javascript">
$(function() {
	$('#adf-settings-accordion').accordion({ header: 'h3', autoHeight: false, heightStyle: 'content' });
});
</script>

<div id="adf-settings-accordion">
	<p><?php echo elgg_echo('adf_platform:homeintro'); ?></p>



	<!-- ACCUEIL PUBLIC //-->
	<h3><i class="fa fa-home"></i> <?php echo elgg_echo('adf_platform:config:publichomepage'); ?></h3>
	<div>
		<p><label><?php echo elgg_echo('adf_platform:settings:replace_public_homepage'); ?> 
			<?php echo elgg_view('input/dropdown', array('name' => 'params[replace_public_homepage]', 'options_values' => $replace_public_homepage_opt, 'value' => $vars['entity']->replace_public_homepage)); ?></label>
		</p>
		<?php
		// Note : les réglages s'appliquent sur la page d'accueil par défaut en mode walled garden
		// Cette page peut être gérée par cmspages
		if (empty($vars['entity']->replace_public_homepage) || ($vars['entity']->replace_public_homepage == 'default')) { ?>
			<p><label><?php echo elgg_echo('adf_platform:homeintro'); ?> 
				<?php echo elgg_view('input/longtext', array('name' => 'params[homeintro]', 'value' => $vars['entity']->homeintro, 'class' => 'elgg-input-rawtext')); ?></label>
			</p><br />
			<p><label><?php echo elgg_echo('adf_platform:home:displaystats'); ?> 
				<?php echo elgg_view('input/dropdown', array('name' => 'params[displaystats]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->displaystats)); ?></label>
			</p>
			<?php
		} else if ($vars['entity']->replace_public_homepage == 'cmspages') {
			if (!elgg_is_active_plugin('cmspages')) { register_error(elgg_echo('adf_platform:cmspages:notactivated')); }
			echo '<a href="' . $url . 'cmspages/?pagetype=homepage-public" target="_new">' . elgg_echo('adf_platform:homepage:cmspages:editlink') . '</a>';
		}
		?>
	</div>


	<!-- ACCUEIL CONNECTE //-->
	<h3><i class="fa fa-home"></i> <?php echo elgg_echo('adf_platform:config:loggedhomepage'); ?></h3>
	<div>
		<?php
		echo '<p><label>' . elgg_echo('adf_platform:settings:replace_home');
			echo elgg_view('input/dropdown', array('name' => 'params[replace_home]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->replace_home)) . '</label>';
		echo '</p><br />';
		
		// Remplacement de la Home (activité) par un tableau de bord configurable
		if ($vars['entity']->replace_home == 'yes') {
			// Premiers pas (page à afficher/masquer)
			echo '<p><label>' . elgg_echo('adf_platform:settings:firststeps');
				echo elgg_view('input/text', array('name' => 'params[firststeps_guid]', 'value' => $vars['entity']->firststeps_guid)) . '</label>';
				echo '<em>' . elgg_echo('adf_platform:settings:firststeps:help') . '</em>';
			echo '</p><br />';
			// Entête configurable
			echo '<p><label>' . elgg_echo('adf_platform:dashboardheader');
				echo elgg_view('input/longtext', array('name' => 'params[dashboardheader]', 'value' => $vars['entity']->dashboardheader)) . '</label>';
			echo '</p><br />';
			
			// Groupe "principal"
			if (elgg_is_active_plugin('groups')) {
				echo '<p><label>' . elgg_echo('adf_platform:homegroup_guid');
					echo elgg_view('input/groups_select', array('name' => 'params[homegroup_guid]', 'value' => $vars['entity']->homegroup_guid, 'empty_value' => true)) . '</label>';
				echo '</p>';
				echo '<p><label>' . elgg_echo('adf_platform:homegroup_autojoin');
					echo elgg_view('input/dropdown', array('name' => 'params[homegroup_autojoin]', 'options_values' => $no_yes_force_opt, 'value' => $vars['entity']->homegroup_autojoin)) . '</label>';
				echo '</p><br />';
			}
			
			// Colonne gauche
			echo '<fieldset>';
				if (elgg_is_active_plugin('groups')) {
					echo '<p><label>' . elgg_echo('adf_platform:index_groups');
						echo elgg_view('input/dropdown', array('name' => 'params[index_groups]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->index_groups)) . '</label>';
					echo '</p>';
				}
				if (elgg_is_active_plugin('members')) {
					echo '<p><label>' . elgg_echo('adf_platform:index_members');
						echo elgg_view('input/dropdown', array('name' => 'params[index_members]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->index_members)) . '</label>';
					echo '</p>';
					echo '<p><label>' . elgg_echo('adf_platform:index_recent_members');
						echo elgg_view('input/dropdown', array('name' => 'params[index_recent_members]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->index_recent_members)) . '</label>';
					echo '</p>';
				}
			echo '</fieldset>';
			// Colonne centrale
			echo '<fieldset>';
				if (elgg_is_active_plugin('thewire')) {
					echo '<p><label>' . elgg_echo('adf_platform:index_wire');
						echo elgg_view('input/dropdown', array('name' => 'params[index_wire]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->index_wire)) . '</label>';
				echo '</p>';
				}
			echo '</fieldset>';
			// Colonne droite
			echo '<fieldset>';
				if (elgg_is_active_plugin('groups')) {
					echo '<p><label>' . elgg_echo('adf_platform:homegroup_index');
						echo elgg_view('input/dropdown', array('name' => 'params[homegroup_index]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->homegroup_index)) . '</label>';
					echo '</p>';
					echo '<p><label>' . elgg_echo('adf_platform:homesite_index');
						echo elgg_view('input/dropdown', array('name' => 'params[homesite_index]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->homesite_index)) . '</label>';
					echo '</p>';
				}
			echo '</fieldset>';
			
		} ?>
	</div>



<!-- INTERFACE //-->
	<h3><i class="fa fa-picture-o"></i> <?php echo elgg_echo('adf_platform:config:interface'); ?></h3>
	<div>
		<img src="<?php echo $url . $vars['entity']->faviconurl; ?>" style="float:right; max-height:64px; max-width:64px; background:black;" />
		<p><label><?php echo elgg_echo('adf_platform:faviconurl'); ?><br />
			<?php echo $url . elgg_view('input/text', array('name' => 'params[faviconurl]', 'value' => $vars['entity']->faviconurl, 'js' => 'style="width:50%;"')); ?></label><br />
			<em><?php echo elgg_echo('adf_platform:faviconurl:help'); ?></em>
		</p><br />

		<p><label><?php echo elgg_echo('adf_platform:headertitle'); ?><br />
			<?php echo elgg_view('input/text', array('name' => 'params[headertitle]', 'value' => $vars['entity']->headertitle)); ?></label><br />
			<em><?php echo elgg_echo('adf_platform:headertitle:help'); ?></em>
		</p><br />

		<img src="<?php echo $url . $vars['entity']->headerimg; ?>" style="float:right; max-height:50px; max-width:600px; background:black;" />
		<p><label><?php echo elgg_echo('adf_platform:settings:headerimg'); ?><br />
			<?php echo $url . elgg_view('input/text', array('name' => 'params[headerimg]', 'value' => $vars['entity']->headerimg, 'js' => 'style="width:50%;"')); ?></label><br />
			<em><?php echo elgg_echo('adf_platform:settings:headerimg:help'); ?></em>
		</p><br />
		
		<img src="<?php echo $url . $vars['entity']->backgroundimg; ?>" style="float:right; max-height:100px; max-width:200px; background:black;" />
		<p><label><?php echo elgg_echo('adf_platform:settings:backgroundimg'); ?><br />
			<?php echo $url . elgg_view('input/text', array('name' => 'params[backgroundimg]', 'value' => $vars['entity']->backgroundimg, 'js' => 'style="width:50%;"')); ?></label><br />
			<em><?php echo elgg_echo('adf_platform:settings:backgroundimg:help'); ?></em>
		</p><br />

		<p><label><?php echo elgg_echo('adf_platform:settings:header'); ?><br />
			<?php echo elgg_view('input/longtext', array('name' => 'params[header]', 'value' => $vars['entity']->header, 'class' => 'elgg-input-rawtext')); ?></label>
			<em><?php echo elgg_echo('adf_platform:settings:header:help'); ?></em>
		</p><br />

		<p><label><?php echo elgg_echo('adf_platform:settings:helplink'); ?><br />
			<?php echo $url . elgg_view('input/text', array('name' => 'params[helplink]', 'value' => $vars['entity']->helplink, 'js' => 'style="width:50%;"')); ?></label><br />
			<em><?php echo elgg_echo('adf_platform:settings:helplink:help'); ?></em>
		</p><br />
		
		<p><label><?php echo elgg_echo('adf_platform:settings:footer'); ?>
			<?php echo elgg_view('input/longtext', array('name' => 'params[footer]', 'value' => $vars['entity']->footer, 'class' => 'elgg-input-rawtext')); ?></label>
		</p><br />

		<p><label><?php echo elgg_echo('adf_platform:settings:analytics'); ?>
			<?php echo elgg_view('input/plaintext', array('name' => 'params[analytics]', 'value' => $vars['entity']->analytics)); ?></label>
		</p><br />

		<p><label><?php echo elgg_echo('adf_platform:settings:publicpages'); ?><br />
			<?php // un nom de pages par ligne demandé (plus clair), mais on acceptera aussi séparé par virgules et point-virgule en pratique
			echo elgg_view('input/plaintext', array('name' => 'params[publicpages]', 'value' => $vars['entity']->publicpages)) . '</label>';
			echo '<em>' . elgg_echo('adf_platform:settings:publicpages:help') . '</em>';
			?>
		</p>
	</div>



<!-- STYLES //-->
	<h3><i class="fa fa-paint-brush"></i> <?php echo elgg_echo('adf_platform:config:styles'); ?></h3>
	<div>
		<?php
		echo '<p><label>Font Awesome ' . elgg_view('input/dropdown', array('name' => 'params[awesomefont]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->awesomefont)) . '</label></p>';
		echo '<p><label>Fixed width ' . elgg_view('input/dropdown', array('name' => 'params[fixedwidth]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->fixedwidth)) . '</label></p>';
		echo '<p><label>(alpha) Semantic UI ' . elgg_view('input/dropdown', array('name' => 'params[semanticui]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->semanticui)) . '</label><br /><em>Attention : despite its promising functionnalities, using Semantic UI can have unexpected effects on various jQuery elements, such as accordion and other existing JS tools. Please test carefully before using on a production site.</em></p>';
		
		echo '<h4>' . elgg_echo('adf_platform:fonts') . '</h4>';
		echo '<p><em>' . elgg_echo('adf_platform:fonts:details') . '</em></p>';
		?>
		<p><label><?php echo elgg_echo('adf_platform:font1'); ?>
			<?php echo elgg_view('input/text', array('name' => 'params[font1]', 'value' => $vars['entity']->font1)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:font2'); ?>
			<?php echo elgg_view('input/text', array('name' => 'params[font2]', 'value' => $vars['entity']->font2)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:font3'); ?>
			<?php echo elgg_view('input/text', array('name' => 'params[font3]', 'value' => $vars['entity']->font3)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:font4'); ?>
			<?php echo elgg_view('input/text', array('name' => 'params[font4]', 'value' => $vars['entity']->font4)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:font5'); ?>
			<?php echo elgg_view('input/text', array('name' => 'params[font5]', 'value' => $vars['entity']->font5)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:font6'); ?>
			<?php echo elgg_view('input/text', array('name' => 'params[font6]', 'value' => $vars['entity']->font6)); ?></label>
		</p>
		
		<?php echo '<h4>' . elgg_echo('adf_platform:colors') . '</h4>'; ?>
		<?php echo '<p><em>' . elgg_echo('adf_platform:colors:details') . '</em></p>'; ?>
		<p><label><?php echo elgg_echo('adf_platform:settings:backgroundcolor'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[backgroundcolor]', 'value' => $vars['entity']->backgroundcolor)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:title:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[titlecolor]', 'value' => $vars['entity']->titlecolor)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:text:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[textcolor]', 'value' => $vars['entity']->textcolor)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:link:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[linkcolor]', 'value' => $vars['entity']->linkcolor)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:link:hovercolor'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[linkhovercolor]', 'value' => $vars['entity']->linkhovercolor)); ?></label>
		</p>

		<h4><?php echo elgg_echo('adf_platform:config:styles:headerfooter'); ?></h4>
		<p><label><?php echo elgg_echo('adf_platform:color1:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color1]', 'value' => $vars['entity']->color1)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color4:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color4]', 'value' => $vars['entity']->color4)); ?></label>
		</p>

		<h4><?php echo elgg_echo('adf_platform:config:styles:groupmodules'); ?></h4>
		<p><label><?php echo elgg_echo('adf_platform:color2:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color2]', 'value' => $vars['entity']->color2)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color3:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color3]', 'value' => $vars['entity']->color3)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color14:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color14]', 'value' => $vars['entity']->color14)); ?></label>
		</p>

		<h4><?php echo elgg_echo('adf_platform:config:styles:buttons'); ?></h4>
		<p><label><?php echo elgg_echo('adf_platform:color5:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color5]', 'value' => $vars['entity']->color5)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color6:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color6]', 'value' => $vars['entity']->color6)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color7:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color7]', 'value' => $vars['entity']->color7)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color8:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color8]', 'value' => $vars['entity']->color8)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color15:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color15]', 'value' => $vars['entity']->color15)); ?></label>
		</p>

		<!--
		<p><label><?php echo elgg_echo('adf_platform:color9:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color9]', 'value' => $vars['entity']->color9)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color10:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color10]', 'value' => $vars['entity']->color10)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color11:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color11]', 'value' => $vars['entity']->color11)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color12:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color12]', 'value' => $vars['entity']->color12)); ?></label>
		</p>
		//-->
		<p><label><?php echo elgg_echo('adf_platform:color13:color'); ?>
			<?php echo elgg_view('input/color', array('name' => 'params[color13]', 'value' => $vars['entity']->color13)); ?></label>
		</p>

		<p><label><?php echo elgg_echo('adf_platform:css'); ?><br />
			<?php echo elgg_view('input/plaintext', array('name' => 'params[css]', 'value' => $vars['entity']->css, 'js' => ' style="min-height:300px;"')); ?></label>
			<em><?php echo elgg_echo('adf_platform:css:help'); ?></em>
		</p>
		
		<?php
		// @TODO Notifications, Digest and Newsletter default wrappers
		if (elgg_is_active_plugin('html_email_handler')) {
			echo '<p><label>' . elgg_echo('esope:html_email_handler:css') . '<br />';
				echo elgg_view('input/plaintext', array('name' => 'params[notification_css]', 'value' => $vars['entity']->notification_css, 'js' => ' style="min-height:300px;"')) . '</label>';
			echo '<em>' . elgg_echo('esope:html_email_handler:css:help') . '</em>';
			echo '</p>';
			echo '<p>' . elgg_echo('esope:html_email_handler:wrapper:help') . '</p>';
		}
		if (elgg_is_active_plugin('digest')) {
			echo '<p><strong>' . elgg_echo('esope:digest:css') . '</strong><br />';
			echo elgg_echo('esope:digest:css:help') . '<br />';
			echo elgg_echo('esope:digest:wrapper:help') . '</p>';
		}
		if (elgg_is_active_plugin('newsletter')) {
			echo '<p><strong>' . elgg_echo('esope:newsletter:css') . '</strong><br />';
			echo elgg_echo('esope:newsletter:css:help') . '<br />';
			echo elgg_echo('esope:newsletter:wrapper:help') . '</p>';
		}
		?>
	</div>



<!-- COMPORTEMENT //-->
	<h3><i class="fa fa-cog"></i> <?php echo elgg_echo('adf_platform:config:behaviour'); ?></h3>
	<div>
		<p><label><?php echo elgg_echo('adf_platform:settings:redirect'); ?><br />
			<?php echo $url . elgg_view('input/text', array('name' => 'params[redirect]', 'value' => $vars['entity']->redirect, 'js' => 'style="width:50%;"')); ?></label>
		</p>
		
		<br />
		<h4><?php echo elgg_echo('adf_platform:config:toolslistings'); ?></h4>
		<p><?php echo elgg_echo('adf_platform:config:toolslistings:details'); ?></p>
		<?php
		if (elgg_is_active_plugin('blog')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:blog_user_listall') . ' ' . elgg_view('input/dropdown', array('name' => 'params[blog_user_listall]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->blog_user_listall)) . '</label></p>';
		}
		if (elgg_is_active_plugin('bookmarks')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:bookmarks_user_listall') . ' ' . elgg_view('input/dropdown', array('name' => 'params[bookmarks_user_listall]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->bookmarks_user_listall)) . '</label></p>';
		}
		/*
		if (elgg_is_active_plugin('brainstorm')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:brainstorm_user_listall') . ' ' . elgg_view('input/dropdown', array('name' => 'params[brainstorm_user_listall]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->brainstorm_user_listall)) . '</label></p>';
		}
		*/
		if (elgg_is_active_plugin('file')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:file_user_listall') . ' ' . elgg_view('input/dropdown', array('name' => 'params[file_user_listall]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->file_user_listall)) . '</label></p>';
		}
		if (elgg_is_active_plugin('pages')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:pages_user_listall') . ' ' . elgg_view('input/dropdown', array('name' => 'params[pages_user_listall]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->pages_user_listall)) . '</label></p>';
			echo '<p><label>' . elgg_echo('adf_platform:settings:pages_list_subpages') . ' ' . elgg_view('input/dropdown', array('name' => 'params[pages_list_subpages]', 'options_values' => $pages_list_subpages_opt, 'value' => $vars['entity']->pages_list_subpages)) . '</label></p>';
			echo '<p><label>' . elgg_echo('adf_platform:settings:pages_reorder') . ' ' . elgg_view('input/dropdown', array('name' => 'params[pages_reorder]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->pages_reorder)) . '</label></p>';
		}
		
		if (elgg_is_active_plugin('thewire')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:thewire_default_access') . ' ' . elgg_view('input/text', array('name' => 'params[thewire_default_access]', 'value' => $vars['entity']->thewire_default_access)) . '</label><br /><em>' . elgg_echo('adf_platform:settings:thewire_default_access:details') . '</em></p>';
		}
		
		// Add limit links to navigation
			echo '<p><label>' . elgg_echo('adf_platform:settings:river_hide_block') . ' ' . elgg_view('input/dropdown', array('name' => 'params[river_hide_block]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->river_hide_block)) . '</label><br /><em>' . elgg_echo('adf_platform:settings:river_hide_block:details') . '</em></p>';
		
		// Add limit links to navigation
			echo '<p><label>' . elgg_echo('adf_platform:settings:advanced_pagination') . ' ' . elgg_view('input/dropdown', array('name' => 'params[advanced_pagination]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->advanced_pagination)) . '</label></p>';
		?>
		
		<br />
		<h4><?php echo elgg_echo('adf_platform:config:filters'); ?></h4>
		<?php
		echo '<p><label>' . elgg_echo('adf_platform:settings:filters:friends') . ' ' . elgg_view('input/dropdown', array('name' => 'params[disable_friends]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->disable_friends)) . '</label></p>';
		echo '<p><label>' . elgg_echo('adf_platform:settings:filters:mine') . ' ' . elgg_view('input/dropdown', array('name' => 'params[disable_mine]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->disable_mine)) . '</label></p>';
		echo '<p><label>' . elgg_echo('adf_platform:settings:filters:all') . ' ' . elgg_view('input/dropdown', array('name' => 'params[disable_all]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->disable_all)) . '</label></p>';
		echo '<br />';
		echo '<p><label>' . elgg_echo('adf_platform:settings:advancedsearch') . ' ' . elgg_view('input/dropdown', array('name' => 'params[advancedsearch]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->advancedsearch)) . '</label></p>';
		?>
	</div>



<!-- GROUPES //-->
	<?php if (elgg_is_active_plugin('groups')) {
		echo '<h3><i class="fa fa-users"></i> ' . elgg_echo('adf_platform:config:groups') . '</h3>';
		echo '<div>';
			// Join groups at registration
			echo '<p><label>' . elgg_echo('esope:settings:register:joingroups') . ' ' . elgg_view('input/dropdown', array('name' => 'params[register_joingroups]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->register_joingroups)) . '</label></p>';
			echo '<p><label>' . elgg_echo('adf_platform:settings:groupjoin_enablenotif') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groupjoin_enablenotif]', 'options_values' => $group_groupjoin_enablenotif_opt, 'value' => $vars['entity']->groupjoin_enablenotif)) . '</label></p>';
			// Group creation disclaimer
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups_disclaimer');
				echo elgg_view('input/longtext', array('name' => 'params[groups_disclaimer]', 'value' => $vars['entity']->groups_disclaimer)) . '</label>';
			echo '</p>';
			echo '<br />';
			// Set default tools status
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:tools_default') . ' ' . elgg_view('input/dropdown', array('name' => 'params[group_tools_default]', 'options_values' => $group_tools_default_opt, 'value' => $vars['entity']->group_tools_default)) . '</label></p>';
			// Default group content access
			echo '<p><label>' . elgg_echo('adf_platform:settings:opengroups:defaultaccess') . ' ' . elgg_view('input/dropdown', array('name' => 'params[opengroups_defaultaccess]', 'options_values' => $group_defaultaccess_opt, 'value' => $vars['entity']->opengroups_defaultaccess)) . '</label></p>';
			echo '<p><label>' . elgg_echo('adf_platform:settings:closedgroups:defaultaccess') . ' ' . elgg_view('input/dropdown', array('name' => 'params[closedgroups_defaultaccess]', 'options_values' => $group_defaultaccess_opt, 'value' => $vars['entity']->closedgroups_defaultaccess)) . '</label></p>';
			// Group layout
			// Enable group top tab menu
			// Usage: $group->customtab1 to 8 with URL::LinkTitle::TitleProperty syntax
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:topmenu') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_topmenu]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->groups_topmenu)) . '</label></p>';
			// Remove group widgets
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:disable_widgets') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_disable_widgets]', 'options_values' => $groups_disable_widgets_opt, 'value' => $vars['entity']->groups_disable_widgets)) . '</label></p>';
			// Add group activity
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:add_activity') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_add_activity]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->groups_add_activity)) . '</label></p>';
			// Add group Wire
			if (elgg_is_active_plugin('thewire')) {
				echo '<p><label>' . elgg_echo('adf_platform:settings:groups:add_wire') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_add_wire]', 'options_values' => $no_yes_groupoption_opt, 'value' => $vars['entity']->groups_add_wire)) . '</label></p>';
			}
			// Add group tools publication homepage shortcuts
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:add_publish_tools') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_add_publish_tools]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->groups_add_publish_tools)) . '</label></p>';
			// Discussion auto-refresh (using parameter ?autorefresh=auto)
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:discussion_autorefresh') . ' ' . elgg_view('input/dropdown', array('name' => 'params[discussion_autorefresh]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->discussion_autorefresh)) . '</label></p>';
			echo '<br />';
			
			echo '<h4>' . elgg_echo('adf_platform:config:groupinvites') . '</h4>';
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:inviteanyone') . ' ' . elgg_view('input/dropdown', array('name' => 'params[invite_anyone]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->invite_anyone)) . '</label></p>';
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:invite_picker') . ' ' . elgg_view('input/dropdown', array('name' => 'params[invite_picker]', 'options_values' => $invite_picker_opt, 'value' => $vars['entity']->invite_picker)) . '</label><br /><em>' . elgg_echo('adf_platform:settings:groups:invite_picker:details') . '</em></p>';
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:allowregister') . ' ' . elgg_view('input/dropdown', array('name' => 'params[allowregister]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->allowregister)) . '</label></p>';
			echo '<br />';
			
			echo '<h4>' . elgg_echo('adf_platform:config:grouptabs') . '</h4>';
			// Default to alpha sort
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:alpha') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_alpha]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->groups_alpha)) . '</label></p>';
			// Allow to remove newest
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:newest') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_newest]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->groups_newest)) . '</label></p>';
			// Allow to remove popular
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:popular') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_popular]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->groups_popular)) . '</label></p>';
			// Allow to add featured
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:featured') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_featured]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->groups_featured)) . '</label></p>';
			// Allow to add a new group tab search
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:searchtab') . ' (BETA) ' . elgg_view('input/dropdown', array('name' => 'params[groups_searchtab]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->groups_searchtab)) . '</label></p>';
			// Advanced group search tool (alpha version, structure changes may happen)
			$esope_groupsearch_url = $url . 'groups/groupsearch';
			echo '<p><label>' . elgg_echo('esope:groupsearch:setting:metadata') . ' ' . elgg_view('input/text', array('name' => 'params[metadata_groupsearch_fields]', 'value' => $vars['entity']->metadata_groupsearch_fields)) . '</label><br /><a href="'.$esope_groupsearch_url.'" target="_new">'.$esope_groupsearch_url.'</a></p>';
			
			// Allow to add a new friends groups tab
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:friends') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_friendstab]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->groups_friendstab)) . '</label></p>';
			// Add groups tags below search (or replaces search if search tab enabled)
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:tags') . ' (BETA) ' . elgg_view('input/dropdown', array('name' => 'params[groups_tags]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->groups_tags)) . '</label></p>';
			// Allow to remove discussion OR add it at page bottom
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:discussion') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_discussion]', 'options_values' => $groups_discussion_opt, 'value' => $vars['entity']->groups_discussion)) . '</label></p>';
			
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:invite_metadata') . elgg_view('input/text', array('name' => 'params[groups_invite_metadata]', 'value' => $vars['entity']->groups_invite_metadata)) . '</label><br /><em>' . elgg_echo('adf_platform:settings:groups:invite_metadata:details') . '</em></p>';
			
			// Suppression de l'affichage de certains champs de profil des groupes (car utilisés pour configurer et non afficher)
		echo '<p><label>' . elgg_echo('adf_platform:settings:group_hide_profile_field') . ' ' . elgg_view('input/text', array('name' => 'params[group_hide_profile_field]', 'value' => $vars['entity']->group_hide_profile_field)) . '</label></p>';
			
			// Display "old group" banner
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:old_display') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_old_display]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->groups_old_display)) . '</label></p>';
			// Set "old group" timeframe (in seconds)
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:old_timeframe') . ' ' . elgg_view('input/text', array('name' => 'params[groups_old_timeframe]', 'value' => $vars['entity']->groups_old_timeframe)) . '</label></p>';
			// Enable group archive (using ->status == 'archive' metadata)
			echo '<p><label>' . elgg_echo('adf_platform:settings:groups:archive') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_archive]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->groups_archive)) . '</label></p>';
			
			?>
		</div>
	<?php } ?>


<!-- MEMBRES //-->
	<h3><i class="fa fa-user"></i> <?php echo elgg_echo('adf_platform:config:members'); ?></h3>
	<div>
		<p>
			<label><?php echo elgg_echo('adf_platform:home:public_profiles'); ?>
			<?php echo elgg_view('input/dropdown', array('name' => 'params[public_profiles]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->public_profiles)); ?></label>
		</p>
		<p><em><?php echo elgg_echo('adf_platform:home:public_profiles:help'); ?></em></p>
		<p>
			<label><?php echo elgg_echo('adf_platform:home:public_profiles_default'); ?>
			<?php echo elgg_view('input/dropdown', array('name' => 'params[public_profiles_default]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->public_profiles_default)); ?></label>
		</p>
		
		<p>
			<label><?php echo elgg_echo('adf_platform:members:hide_directory'); ?>
			<?php echo elgg_view('input/dropdown', array('name' => 'params[hide_directory]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->hide_directory)); ?></label>
		</p>
		
		<h4><?php echo elgg_echo('adf_platform:profile:settings'); ?></h4>
		<p><label><?php echo elgg_echo('adf_platform:profile:add_profile_activity'); ?>
			<?php echo elgg_view('input/dropdown', array('name' => 'params[add_profile_activity]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->add_profile_activity)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:profile:remove_profile_widgets'); ?>
			<?php echo elgg_view('input/dropdown', array('name' => 'params[remove_profile_widgets]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->remove_profile_widgets)); ?></label>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:profile:custom_profile_layout'); ?>
			<?php echo elgg_view('input/dropdown', array('name' => 'params[custom_profile_layout]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->custom_profile_layout)); ?></label>
		</p>
		<br />
		<?php
		echo '<h4>' . elgg_echo('adf_platform:config:memberssearch') . '</h4>';
		if (elgg_is_active_plugin('members')) {
			// Allow to add alpha sort
			echo '<p><label>' . elgg_echo('adf_platform:settings:members:alpha') . ' ' . elgg_view('input/dropdown', array('name' => 'params[members_alpha]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->members_alpha)) . '</label></p>';
			// Allow to remove newest
			echo '<p><label>' . elgg_echo('adf_platform:settings:members:newest') . ' ' . elgg_view('input/dropdown', array('name' => 'params[members_newest]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->members_newest)) . '</label></p>';
			// Allow to remove popular
			echo '<p><label>' . elgg_echo('adf_platform:settings:members:popular') . ' ' . elgg_view('input/dropdown', array('name' => 'params[members_popular]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->members_popular)) . '</label></p>';
			// Allow to remove online
			echo '<p><label>' . elgg_echo('adf_platform:settings:members:onlinetab') . ' ' . elgg_view('input/dropdown', array('name' => 'params[members_onlinetab]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->members_onlinetab)) . '</label></p>';
			// Allow to add profile types tabs
			echo '<p><label>' . elgg_echo('adf_platform:settings:members:profiletypes') . ' ' . elgg_view('input/dropdown', array('name' => 'params[members_profiletypes]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->members_profiletypes)) . '</label></p>';
			// Allow to add a new tab search
			echo '<p><label>' . elgg_echo('adf_platform:settings:members:searchtab') . ' ' . elgg_view('input/dropdown', array('name' => 'params[members_searchtab]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->members_searchtab)) . '</label></p>';
		
			// Advanced search tool (alpha version, structure changes may happen)
			$esope_membersearch_url = $url . 'members/search';
			echo '<p><label>' . elgg_echo('esope:membersearch:setting:metadata') . ' ' . elgg_view('input/rawtext', array('name' => 'params[metadata_membersearch_fields]', 'value' => $vars['entity']->metadata_membersearch_fields, 'style' => "width:100%; height:5ex;")) . '</label><br /><em>' . elgg_echo('esope:membersearch:setting:metadata:details') . '</em><br /><a href="'.$esope_membersearch_url.'" target="_new"><i class="fa fa-external-link"></i> '.$esope_membersearch_url.'</a></p>';
		
			// Replace search by main search (more efficient)
			echo '<p><label>' . elgg_echo('adf_platform:settings:members:onesearch') . ' ' . elgg_view('input/dropdown', array('name' => 'params[members_onesearch]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->members_onesearch)) . '</label></p>';
			// Add online members
			echo '<p><label>' . elgg_echo('adf_platform:settings:members:online') . ' ' . elgg_view('input/dropdown', array('name' => 'params[members_online]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->members_online)) . '</label></p>';
		}
		
		
		// Remove friends collections
		echo '<p><label>' . elgg_echo('adf_platform:settings:remove_collections') . ' ' . elgg_view('input/dropdown', array('name' => 'params[remove_collections]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->remove_collections)) . '</label></p>';
		
		// Suppression des menus de l'utilisateur
		echo '<p><label>' . elgg_echo('adf_platform:settings:removeusermenutools') . ' ' . elgg_view('input/text', array('name' => 'params[remove_user_menutools]', 'value' => $vars['entity']->remove_user_menutools)) . '</label><br /><em>' . elgg_echo('adf_platform:settings:removeusermenutools:details') . '</em></p>';
	
		// Suppression des outils personnels (lien de création) de l'utilisateur
		echo '<p><label>' . elgg_echo('adf_platform:settings:removeusertools') . ' ' . elgg_view('input/text', array('name' => 'params[remove_user_tools]', 'value' => $vars['entity']->remove_user_tools)) . '</label><br /><em>' . elgg_echo('adf_platform:settings:removeusertools:details') . '<br />' . implode(',', $registered_objects) . '</em></p>';
		// Note : la suppression de filtres dans les listings est un réglage général à part, 
		// car pas forcément pertinent si on liste aussi les contenus créés dans les groupes par un membre
	
		// Suppression des niveaux d'accès pour les membres
		echo '<p><label>' . elgg_echo('adf_platform:settings:user_exclude_access') . ' ' . elgg_view('input/text', array('name' => 'params[user_exclude_access]', 'value' => $vars['entity']->user_exclude_access)) . '</label></p>';
	
		// Suppression des niveaux d'accès pour les admins (franchement déconseillé)
		echo '<p><label>' . elgg_echo('adf_platform:settings:admin_exclude_access') . ' ' . elgg_view('input/text', array('name' => 'params[admin_exclude_access]', 'value' => $vars['entity']->admin_exclude_access)) . '</label></p>';
		
		?>
	</div>



<!-- WIDGETS //-->
	<h3><i class="fa fa-puzzle-piece"></i> <?php echo elgg_echo('adf_platform:config:widgets'); ?></h3>
	<div>
		<?php
		if (elgg_is_active_plugin('blog')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:blog') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_blog]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_blog)) . '</label></p>';
		}
		if (elgg_is_active_plugin('bookmarks')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:bookmarks') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_bookmarks]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_bookmarks)) . '</label></p>';
		}
		if (elgg_is_active_plugin('brainstorm')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:brainstorm') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_brainstorm]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_brainstorm)) . '</label></p>';
		}
		if (elgg_is_active_plugin('event_calendar')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:event_calendar') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_event_calendar]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_event_calendar)) . '</label></p>';
		}
		if (elgg_is_active_plugin('file')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:file') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_file]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_file)) . '</label></p>';
		}
		if (elgg_is_active_plugin('file_tools')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:file_folder') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_file_folder]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_file_folder)) . '</label></p>';
		}
		if (elgg_is_active_plugin('groups')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:groups') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_groups]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_groups)) . '</label></p>';
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:group_activity') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_group_activity]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_group_activity)) . '</label></p>';
		}
		if (elgg_is_active_plugin('pages')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:pages') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_pages]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_pages)) . '</label></p>';
		}
		echo '<p><label>' . elgg_echo('adf_platform:settings:widget:friends') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_friends]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_friends)) . '</label></p>';
		if (elgg_is_active_plugin('messages')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:messages') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_messages]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_messages)) . '</label></p>';
		}
		echo '<p><label>' . elgg_echo('adf_platform:settings:widget:river_widget') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_river_widget]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_river_widget)) . '</label></p>';
		if (elgg_is_active_plugin('twitter')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:twitter') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_twitter]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_twitter)) . '</label></p>';
		}
		if (elgg_is_active_plugin('thewire')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:thewire') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_thewire]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_thewire)) . '</label></p>';
		}
		if (elgg_is_active_plugin('tagcloud')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:tagcloud') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_tagcloud]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_tagcloud)) . '</label></p>';
		}
		if (elgg_is_active_plugin('videos')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:videos') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_videos]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_videos)) . '</label></p>';
		}
		if (elgg_is_active_plugin('profile_manager')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:profile_completeness') . ' ' . elgg_echo('adf_platform:settings:widget:profile_completeness:help') . '</label></p>';
		}
		if (elgg_is_active_plugin('webprofiles')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:webprofiles') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_webprofiles]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_webprofiles)) . '</label></p>';
		}
		if (elgg_is_active_plugin('export_embed')) {
			echo '<p><label>' . elgg_echo('adf_platform:settings:widget:export_embed') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_export_embed]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_export_embed)) . '</label></p>';
		}
		echo '<p><label>' . elgg_echo('adf_platform:settings:widget:freehtml') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_freehtml]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_freehtml)) . '</label></p>';
		echo '<p><label>' . elgg_echo('adf_platform:settings:widget:searchresults') . ' ' . elgg_view('input/dropdown', array('name' => 'params[widget_searchresults]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_searchresults)) . '</label></p>';
		?>
	</div>



<!-- CONTACTS //-->
	<h3><i class="fa fa-phone"></i> <?php echo elgg_echo('adf_platform:config:contacts'); ?></h3>
	<div>
		<p><em><?php echo elgg_echo('adf_platform:config:contacts'); ?></em></p>
		<?php
		// Note : use view page/elements/social_presence for rendering
		// Important : update tools list in view if updated here !
		// @TODO : could also make this list a setting and let people update it live..
		$tools = array('contactemail', 'rss', 'twitter', 'facebook', 'googleplus', 'linkedin', 'netvibes', 'flickr', 'youtube', 'vimeo', 'dailymotion', 'vine', 'instagram', 'github', 'delicious', 'pinterest', 'tumblr', 'slideshare');
		foreach ($tools as $tool) {
			echo '<p><label>' . elgg_echo("esope:settings:$tool:icon") . ' &nbsp; ' . elgg_echo("esope:settings:$tool") . '' . elgg_view('input/text', array('name' => "params[$tool]", 'value' => $vars['entity']->$tool, 'js' => 'style="width:50%;"')) . '</label><br /><em>' . elgg_echo("esope:settings:$tool:help") . '</em></p>';
		}
		?>
	</div>



<!-- SECURITE //-->
	<h3><i class="fa fa-shield"></i> <?php echo elgg_echo('adf_platform:config:security'); ?></h3>
	<div>
		<?php
		echo elgg_echo('adf_platform:config:security:notice');
		echo '<br />';
		echo '<p><label>' . elgg_echo('adf_platform:config:framekiller') . ' ' . elgg_view('input/dropdown', array('name' => 'params[framekiller]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->framekiller)) . '</label><br /><em>' . elgg_echo('adf_platform:config:framekiller:details') . '</em></p>';
		?>
	</div>



<!-- REGLAGES EXPERTS //-->
	<h3><i class="fa fa-cogs"></i> <?php echo elgg_echo('adf_platform:config:expert'); ?></h3>
	<div>
		<?php
		// Advanced search tool (alpha version, structure changes may happen)
		$esope_search_url = $url . 'esearch';
		echo '<p><label>' . elgg_echo('esope:search:setting:metadata') . ' ' . elgg_view('input/text', array('name' => 'params[metadata_search_fields]', 'value' => $vars['entity']->metadata_search_fields)) . '</label><br /><a href="'.$esope_search_url.'" target="_new">'.$esope_search_url.'</a></p>';
		?>
	</div>


	<!-- SAUVEGARDE ET RESTAURATION //-->
	<h3><i class="fa fa-archive"></i> <?php echo elgg_echo('adf_platform:config:saverestore'); ?></h3>
	<div>
		<p><?php echo elgg_echo('adf_platform:config:saverestore:details'); ?></p>

		<p><label><?php echo elgg_echo('adf_platform:config:import'); ?>
			<?php
			// Saisie des données à restaurer
			echo elgg_view('input/plaintext', array('name' => 'params[import_settings]', 'value' => $vars['entity']->import_settings));
			?>
			</label>
			<em><?php echo elgg_echo('adf_platform:config:import:details'); ?></em>
		</p><br />

		<p><label><?php echo elgg_echo('adf_platform:config:export'); ?></label>
			<?php
			$plugin_settings = $vars['entity']->getAllSettings();
			$plugin_settings = serialize($plugin_settings);
			$plugin_settings = mb_encode_numericentity($plugin_settings, array (0x0, 0xffff, 0, 0xffff), 'UTF-8');
			$plugin_settings = htmlentities($plugin_settings, ENT_QUOTES, 'UTF-8');
			echo '<textarea readonly="readonly" onclick="this.select()">' . $plugin_settings . '</textarea>';
			?>
			<em><?php echo elgg_echo('adf_platform:config:export:details'); ?></em>
		</p><br />
	</div>
	<br />
	<br />
	
</div>

<?php
/* Tests : Pour une réduction des données de sauvegarde, une forme de compression ?
echo "Données de sauvegarde : " . strlen($plugin_settings) . '<br />';
$compressed_settings = str_replace(';&amp;#', '.', $plugin_settings);
echo "Données compressées : " . strlen($compressed_settings) . '<br />';
*/



