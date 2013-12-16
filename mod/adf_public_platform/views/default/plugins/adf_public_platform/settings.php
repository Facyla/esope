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
global $CONFIG;

$url = $vars['url'];

$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );
$no_yes_force_opt = $no_yes_opt;
$no_yes_force_opt['force'] = elgg_echo('option:force');
$replace_public_homepage_opt = array( 'default' => elgg_echo('adf_platform:replacehome:default'), 'cmspages' => elgg_echo('adf_platform:replacehome:cmspages'), 'no' => elgg_echo('adf_platform:replacehome:no') );
$groups_discussion_opt = $yes_no_opt;
$groups_discussion_opt['always'] = elgg_echo('adf_platform:settings:groups:discussion:always');
$group_tools_default_opt['auto'] = elgg_echo('adf_platform:settings:groups:tools_default:auto');
$registered_objects = get_registered_entity_types('object');
$group_defaultaccess_opt = array('default' => elgg_echo('adf_platform:groupdefaultaccess:default'), 'groupvis' => elgg_echo('adf_platform:groupdefaultaccess:groupvis'), 'group' => elgg_echo('adf_platform:groupdefaultaccess:group'), 'members' => elgg_echo('adf_platform:groupdefaultaccess:members'), 'public' => elgg_echo('adf_platform:groupdefaultaccess:public'));
$group_groupjoin_enablenotif_opt = array(
		'email' => elgg_echo('option:notify:email'),
		'site' => elgg_echo('option:notify:site'),
		'all' => elgg_echo('option:notify:all'),
		'no' => elgg_echo('option:notify:no'),
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
if (empty($vars['entity']->headerimg)) { $vars['entity']->headerimg = 'mod/adf_public_platform/img/theme/departement.png'; }
if (empty($vars['entity']->backgroundcolor)) { $vars['entity']->backgroundcolor = '#efeeea'; }
if (empty($vars['entity']->backgroundimg)) { $vars['entity']->backgroundimg = 'mod/adf_public_platform/img/theme/motif_fond.jpg'; }

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
				<li><a href="#">Accessibilité</a></li>
				<li><a href="#">Contact</a></li>
			</ul>
			<a href="#" target="_blank"><img src="' . $url . 'mod/theme_yourtheme/graphics/logo.png" alt="Logo" /></a>';
}

if (empty($vars['entity']->opengroups_defaultaccess)) { $vars['entity']->opengroups_defaultaccess = 'groupvis'; }
if (empty($vars['entity']->closedgroups_defaultaccess)) { $vars['entity']->closedgroups_defaultaccess = 'group'; }
if (empty($vars['entity']->awesomefont)) $vars['entity']->awesomefont = 'yes';
if (empty($vars['entity']->fixedwidth)) $vars['entity']->fixedwidth = 'no';


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
	* Widgets
	* Styles
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


	<h3><?php echo elgg_echo('adf_platform:config:publichomepage'); ?></h3>
	<div>
		<p><label><?php echo elgg_echo('adf_platform:settings:replace_public_homepage'); ?></label>
			<?php echo elgg_view('input/dropdown', array( 'name' => 'params[replace_public_homepage]', 'options_values' => $replace_public_homepage_opt, 'value' => $vars['entity']->replace_public_homepage )); ?>
		</p>
		<?php
		// Note : les réglages s'appliquent sur la page d'accueil par défaut en mode walled garden, qui peut être gérée par cmspages
		if (empty($vars['entity']->replace_public_homepage) || ($vars['entity']->replace_public_homepage == 'default')) { ?>
			<p><label><?php echo elgg_echo('adf_platform:homeintro'); ?></label>
				<?php echo elgg_view('input/longtext', array( 'name' => 'params[homeintro]', 'value' => $vars['entity']->homeintro, 'class' => 'elgg-input-rawtext' )); ?>
			</p><br />
			<p><label><?php echo elgg_echo('adf_platform:home:displaystats'); ?></label>
				<?php echo elgg_view('input/dropdown', array( 'name' => 'params[displaystats]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->displaystats )); ?>
			</p>
			<?php
		} else if ($vars['entity']->replace_public_homepage == 'cmspages') {
			if (!elgg_is_active_plugin('cmspages')) { register_error(elgg_echo('adf_platform:cmspages:notactivated')); }
			echo '<a href="' . $CONFIG->url . 'cmspages/?pagetype=homepage-public" target="_new">' . elgg_echo('adf_platform:homepage:cmspages:editlink') . '</a>';
		}
		?>
	</div>


	<h3><?php echo elgg_echo('adf_platform:config:loggedhomepage'); ?></h3>
	<div>
		<?php
		echo '<p><label>' . elgg_echo('adf_platform:settings:replace_home') . '</label>';
			echo elgg_view('input/dropdown', array( 'name' => 'params[replace_home]', 'options_values' => array( '' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') ), 'value' => $vars['entity']->replace_home ));
		echo '</p><br />';
		
		// Remplacement de la Home (activité) par un tableau de bord configurable
		if ($vars['entity']->replace_home == 'yes') {
			// Premiers pas (page à afficher/masquer)
			echo '<p><label>' . elgg_echo('adf_platform:settings:firststeps') . '</label><br />';
			echo elgg_echo('adf_platform:settings:firststeps:help');
				echo elgg_view('input/text', array( 'name' => 'params[firststeps_guid]', 'value' => $vars['entity']->firststeps_guid ));
			echo '</p><br />';
			// Entête configurable
			echo '<p><label>' . elgg_echo('adf_platform:dashboardheader') . '</label>'; ?>
				<?php echo elgg_view('input/longtext', array( 'name' => 'params[dashboardheader]', 'value' => $vars['entity']->dashboardheader ));
			echo '</p><br />';
			// Colonne centrale
			if (elgg_is_active_plugin('thewire')) {
				echo '<p><label>' . elgg_echo('adf_platform:index_wire') . '</label>';
					echo elgg_view('input/dropdown', array( 'name' => 'params[index_wire]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->index_wire));
			echo '</p><br />';
			}
			// Colonne gauche
			if (elgg_is_active_plugin('groups')) {
				echo '<p><label>' . elgg_echo('adf_platform:index_groups') . '</label>'; ?>
					<?php echo elgg_view('input/dropdown', array( 'name' => 'params[index_groups]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->index_groups));
				echo '</p><br />';
			}
			if (elgg_is_active_plugin('members')) {
				echo '<p><label>' . elgg_echo('adf_platform:index_members') . '</label>';
					echo elgg_view('input/dropdown', array( 'name' => 'params[index_members]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->index_members));
				echo '</p><br />';
				echo '<p><label>' . elgg_echo('adf_platform:index_recent_members') . '</label>';
					echo elgg_view('input/dropdown', array( 'name' => 'params[index_recent_members]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->index_recent_members));
				echo '</p><br />';
			}
			// Colonne droite
			if (elgg_is_active_plugin('groups')) {
				echo '<p><label>' . elgg_echo('adf_platform:homegroup_guid') . '</label>';
					echo elgg_view('input/groups_select', array( 'name' => 'params[homegroup_guid]', 'value' => $vars['entity']->homegroup_guid, 'empty_value' => true));
				echo '</p><br />';
				echo '<p><label>' . elgg_echo('adf_platform:homegroup_autojoin') . '</label>';
					echo elgg_view('input/dropdown', array( 'name' => 'params[homegroup_autojoin]', 'options_values' => $no_yes_force_opt, 'value' => $vars['entity']->homegroup_autojoin));
				echo '</p><br />';
				echo '<p><label>' . elgg_echo('adf_platform:homegroup_index') . '</label>';
					echo elgg_view('input/dropdown', array( 'name' => 'params[homegroup_index]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->homegroup_index));
				echo '</p><br />';
				echo '<p><label>' . elgg_echo('adf_platform:homesite_index') . '</label>';
					echo elgg_view('input/dropdown', array( 'name' => 'params[homesite_index]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->homesite_index));
				echo '</p><br />';
			}
			
		} ?>
	</div>


	<h3><?php echo elgg_echo('adf_platform:config:interface'); ?></h3>
	<div>
		<br />
		<img src="<?php echo $url . $vars['entity']->faviconurl; ?>" style="float:right; max-height:64px; max-width:64px; background:black;" />
		<p><label><?php echo elgg_echo('adf_platform:faviconurl'); ?></label><br />
			<?php echo elgg_echo('adf_platform:faviconurl:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[faviconurl]', 'value' => $vars['entity']->faviconurl, 'js' => 'style="width:50%;"' )); ?>
		</p><br />

		<p><label><?php echo elgg_echo('adf_platform:headertitle'); ?></label><br />
			<?php echo elgg_echo('adf_platform:headertitle:help'); ?>
			<?php echo elgg_view('input/text', array( 'name' => 'params[headertitle]', 'value' => $vars['entity']->headertitle )); ?>
		</p><br />

		<img src="<?php echo $url . $vars['entity']->headerimg; ?>" style="float:right; max-height:50px; max-width:600px; background:black;" />
		<p><label><?php echo elgg_echo('adf_platform:settings:headerimg'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:headerimg:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[headerimg]', 'value' => $vars['entity']->headerimg, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		
		<p><label><?php echo elgg_echo('adf_platform:settings:helplink'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:helplink:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[helplink]', 'value' => $vars['entity']->helplink, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		
		<p><label><?php echo elgg_echo('adf_platform:settings:backgroundcolor'); ?></label> 
			<?php echo elgg_view('input/color', array( 'name' => 'params[backgroundcolor]', 'value' => $vars['entity']->backgroundcolor, 'js' => 'style="width:12ex;"' )); ?>
		</p><br />
		
		<img src="<?php echo $url . $vars['entity']->backgroundimg; ?>" style="float:right; max-height:100px; max-width:200px; background:black;" />
		<p><label><?php echo elgg_echo('adf_platform:settings:backgroundimg'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:backgroundimg:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[backgroundimg]', 'value' => $vars['entity']->backgroundimg, 'js' => 'style="width:50%;"' )); ?>
		</p><br />

		<p><label><?php echo elgg_echo('adf_platform:settings:groups_disclaimer'); ?></label>
			<?php echo elgg_view('input/longtext', array( 'name' => 'params[groups_disclaimer]', 'value' => $vars['entity']->groups_disclaimer )); ?>
		</p><br />

		<p><label><?php echo elgg_echo('adf_platform:settings:footer'); ?></label>
			<?php echo elgg_view('input/longtext', array( 'name' => 'params[footer]', 'value' => $vars['entity']->footer )); ?>
		</p><br />

		<p><label><?php echo elgg_echo('adf_platform:settings:publicpages'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:publicpages:help'); ?>
			<?php // un nom de pages par ligne demandé (plus clair), mais on acceptera aussi séparé par virgules et point-virgule en pratique
			echo elgg_view('input/plaintext', array( 'name' => 'params[publicpages]', 'value' => $vars['entity']->publicpages ));
			?>
		</p>
	</div>


	<h3><?php echo elgg_echo('adf_platform:config:behaviour'); ?></h3>
	<div>
		<p><label><?php echo elgg_echo('adf_platform:settings:redirect'); ?></label><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[redirect]', 'value' => $vars['entity']->redirect, 'js' => 'style="width:50%;"' )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:home:public_profiles'); ?></label>
			<?php echo elgg_view('input/dropdown', array( 'name' => 'params[public_profiles]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->public_profiles )); ?>
		</p>
		
		<h4><?php echo elgg_echo('adf_platform:profile:settings'); ?></h4>
		<p><label><?php echo elgg_echo('adf_platform:profile:add_profile_activity'); ?></label>
			<?php echo elgg_view('input/dropdown', array( 'name' => 'params[add_profile_activity]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->add_profile_activity )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:profile:remove_profile_widgets'); ?></label>
			<?php echo elgg_view('input/dropdown', array( 'name' => 'params[remove_profile_widgets]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->remove_profile_widgets )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:profile:custom_profile_layout'); ?></label>
			<?php echo elgg_view('input/dropdown', array( 'name' => 'params[custom_profile_layout]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->custom_profile_layout )); ?>
		</p>
		
		<br />
		<h4><?php echo elgg_echo('adf_platform:config:toolslistings'); ?></h4>
		<p><?php echo elgg_echo('adf_platform:config:toolslistings:details'); ?></p>
		<?php
		if (elgg_is_active_plugin('blog')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:blog_user_listall') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[blog_user_listall]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->blog_user_listall )) . '</p>';
		}
		if (elgg_is_active_plugin('bookmarks')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:bookmarks_user_listall') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[bookmarks_user_listall]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->bookmarks_user_listall )) . '</p>';
		}
		/*
		if (elgg_is_active_plugin('brainstorm')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:brainstorm_user_listall') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[brainstorm_user_listall]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->brainstorm_user_listall )) . '</p>';
		}
		*/
		if (elgg_is_active_plugin('file')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:file_user_listall') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[file_user_listall]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->file_user_listall )) . '</p>';
		}
		if (elgg_is_active_plugin('pages')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:pages_user_listall') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[pages_user_listall]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->pages_user_listall )) . '</p>';
		}
		?>
		
		<br />
		<h4><?php echo elgg_echo('adf_platform:config:filters'); ?></h4>
		<?php
		echo ' <p><label>' . elgg_echo('adf_platform:settings:filters:friends') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[disable_friends]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->disable_friends )) . '</p>';
		echo ' <p><label>' . elgg_echo('adf_platform:settings:filters:mine') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[disable_mine]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->disable_mine )) . '</p>';
		echo ' <p><label>' . elgg_echo('adf_platform:settings:filters:all') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[disable_all]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->disable_all )) . '</p>';
		?>
		
		<br />
		<h4><?php echo elgg_echo('adf_platform:config:groupinvites'); ?></h4>
		<?php
		if (elgg_is_active_plugin('groups')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:groups:inviteanyone') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[invite_anyone]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->invite_anyone )) . '</p>';
			echo ' <p><label>' . elgg_echo('adf_platform:settings:groups:allowregister') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[allowregister]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->allowregister )) . '</p>';
			echo ' <p><label>' . elgg_echo('adf_platform:settings:opengroups:defaultaccess') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[opengroups_defaultaccess]', 'options_values' => $group_defaultaccess_opt, 'value' => $vars['entity']->opengroups_defaultaccess )) . '</p>';
			echo ' <p><label>' . elgg_echo('adf_platform:settings:closedgroups:defaultaccess') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[closedgroups_defaultaccess]', 'options_values' => $group_defaultaccess_opt, 'value' => $vars['entity']->closedgroups_defaultaccess )) . '</p>';
			echo ' <p><label>' . elgg_echo('adf_platform:settings:groupjoin_enablenotif') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[groupjoin_enablenotif]', 'options_values' => $group_groupjoin_enablenotif_opt, 'value' => $vars['entity']->groupjoin_enablenotif )) . '</p>';
		}
		?>
		<br />
		<h4><?php echo elgg_echo('adf_platform:config:grouptabs'); ?></h4>
		<?php
		if (elgg_is_active_plugin('groups')) {
			// Default to alpha sort
			echo ' <p><label>' . elgg_echo('adf_platform:settings:groups:alpha') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[groups_alpha]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->groups_alpha )) . '</p>';
			// Allow to remove newest
			echo ' <p><label>' . elgg_echo('adf_platform:settings:groups:newest') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[groups_newest]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->groups_newest )) . '</p>';
			// Allow to remove popular
			echo ' <p><label>' . elgg_echo('adf_platform:settings:groups:popular') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[groups_popular]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->groups_popular )) . '</p>';
			// Allow to remove discussion OR add it at page bottom
			echo ' <p><label>' . elgg_echo('adf_platform:settings:groups:discussion') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[groups_discussion]', 'options_values' => $groups_discussion_opt, 'value' => $vars['entity']->groups_discussion )) . '</p>';
			// Set default tools status
			echo ' <p><label>' . elgg_echo('adf_platform:settings:groups:tools_default') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[group_tools_default]', 'options_values' => $group_tools_default_opt, 'value' => $vars['entity']->group_tools_default )) . '</p>';
		}
		?>
		
		<br />
		<h4><?php echo elgg_echo('adf_platform:config:memberssearch'); ?></h4>
		<?php
		if (elgg_is_active_plugin('members')) {
			// Allow to add alpha sort
			echo ' <p><label>' . elgg_echo('adf_platform:settings:members:alpha') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[members_alpha]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->members_alpha )) . '</p>';
			// Allow to remove newest
			echo ' <p><label>' . elgg_echo('adf_platform:settings:members:newest') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[members_newest]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->members_newest )) . '</p>';
			// Allow to remove popular
			echo ' <p><label>' . elgg_echo('adf_platform:settings:members:popular') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[members_popular]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->members_popular )) . '</p>';
			// Allow to remove online
			echo ' <p><label>' . elgg_echo('adf_platform:settings:members:onlinetab') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[members_onlinetab]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->members_onlinetab )) . '</p>';
			// Allow to add a new tab search
			echo ' <p><label>' . elgg_echo('adf_platform:settings:members:searchtab') . ' (ALPHA)</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[members_searchtab]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->members_searchtab )) . '</p>';
			// Replace search by main search (more efficient)
			echo ' <p><label>' . elgg_echo('adf_platform:settings:members:onesearch') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[members_onesearch]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->members_onesearch )) . '</p>';
			// Add online members
			echo ' <p><label>' . elgg_echo('adf_platform:settings:members:online') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[members_online]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->members_online )) . '</p>';
		}
		
		echo ' <p><label>' . elgg_echo('adf_platform:settings:remove_collections') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[remove_collections]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->remove_collections )) . '</p>';
		
		?>
		
	</div>
	
	
	<h3><?php echo elgg_echo('adf_platform:config:widgets'); ?></h3>
	<div>
		<?php
		if (elgg_is_active_plugin('blog')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:blog') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_blog]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_blog )) . '</p>';
		}
		if (elgg_is_active_plugin('bookmarks')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:bookmarks') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_bookmarks]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_bookmarks )) . '</p>';
		}
		if (elgg_is_active_plugin('brainstorm')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:brainstorm') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_brainstorm]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_brainstorm )) . '</p>';
		}
		if (elgg_is_active_plugin('event_calendar')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:event_calendar') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_event_calendar]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_event_calendar )) . '</p>';
		}
		if (elgg_is_active_plugin('file')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:file') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_file]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_file )) . '</p>';
		}
		if (elgg_is_active_plugin('groups')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:groups') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_groups]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_groups )) . '</p>';
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:group_activity') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_group_activity]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_group_activity )) . '</p>';
		}
		if (elgg_is_active_plugin('pages')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:pages') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_pages]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_pages )) . '</p>';
		}
		echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:friends') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_friends]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_friends )) . '</p>';
		if (elgg_is_active_plugin('messages')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:messages') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_messages]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_messages )) . '</p>';
		}
		echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:river_widget') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_river_widget]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_river_widget )) . '</p>';
		if (elgg_is_active_plugin('twitter')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:twitter') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_twitter]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_twitter )) . '</p>';
		}
		if (elgg_is_active_plugin('tagcloud')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:tagcloud') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_tagcloud]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_tagcloud )) . '</p>';
		}
		if (elgg_is_active_plugin('videos')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:videos') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_videos]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_videos )) . '</p>';
		}
		if (elgg_is_active_plugin('profile_manager')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:profile_completeness') . '</label> ' . elgg_echo('adf_platform:settings:widget:profile_completeness:help') . '</p>';
		}
		if (elgg_is_active_plugin('webprofiles')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:widget:webprofiles') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[widget_webprofiles]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->widget_webprofiles )) . '</p>';
		}
		?>
	</div>


	<h3><?php echo elgg_echo('adf_platform:config:contacts'); ?></h3>
	<div>
		<br />
		<blockquote><?php echo elgg_echo('adf_platform:config:contacts'); ?></blockquote>
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:contactemail'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[contactemail]', 'value' => $vars['entity']->contactemail, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:contactemail:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:rss'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[rss]', 'value' => $vars['entity']->rss, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:rss:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:twitter'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[twitter]', 'value' => $vars['entity']->twitter, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:twitter:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:facebook'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[facebook]', 'value' => $vars['entity']->facebook, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:facebook:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:googleplus'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[googleplus]', 'value' => $vars['entity']->googleplus, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:googleplus:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:linkedin'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[linkedin]', 'value' => $vars['entity']->linkedin, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:linkedin:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:netvibes'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[netvibes]', 'value' => $vars['entity']->netvibes, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:netvibes:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:flickr'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[flickr]', 'value' => $vars['entity']->flickr, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:flickr:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:youtube'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[youtube]', 'value' => $vars['entity']->youtube, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:youtube:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:dailymotion'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[dailymotion]', 'value' => $vars['entity']->dailymotion, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:dailymotion:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:pinterest'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[pinterest]', 'value' => $vars['entity']->pinterest, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:pinterest:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:tumblr'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[tumblr]', 'value' => $vars['entity']->tumblr, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:tumblr:help'); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:slideshare'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[slideshare]', 'value' => $vars['entity']->slideshare, 'js' => 'style="width:50%;"' )); ?><br />
			<?php echo elgg_echo('adf_platform:settings:slideshare:help'); ?>
		</p><br />
	</div>


	<h3><?php echo elgg_echo('adf_platform:config:styles'); ?></h3>
	<div>
		
		<?php
		echo ' <p><label>Semantic UI</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[semanticui]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->semanticui )) . '</p><p>Attention : despite its promising functionnalities, using Semantic UI can have unexpected effects on various jQuery elements, such as accordion and other existing JS tools. Please test carefully before using on a production site.</p>';
		echo ' <p><label>Awesome Font</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[awesomefont]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->awesomefont )) . '</p>';
		echo ' <p><label>Fixed width</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[fixedwidth]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->fixedwidth )) . '</p>';
		?>
		
		<?php echo '<h4>' . elgg_echo('adf_platform:fonts') . '</h4>'; ?>
		<?php echo '<p><em>' . elgg_echo('adf_platform:fonts:details') . '</em></p>'; ?>
		<p><label><?php echo elgg_echo('adf_platform:font1'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[font1]', 'value' => $vars['entity']->font1 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:font2'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[font2]', 'value' => $vars['entity']->font2 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:font3'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[font3]', 'value' => $vars['entity']->font3 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:font4'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[font4]', 'value' => $vars['entity']->font4 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:font5'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[font5]', 'value' => $vars['entity']->font5 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:font6'); ?></label>
			<?php echo elgg_view('input/text', array( 'name' => 'params[font6]', 'value' => $vars['entity']->font6 )); ?>
		</p>
		
		<?php echo '<h4>' . elgg_echo('adf_platform:colors') . '</h4>'; ?>
		<?php echo '<p><em>' . elgg_echo('adf_platform:colors:details') . '</em></p>'; ?>
		<p><label><?php echo elgg_echo('adf_platform:title:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[titlecolor]', 'value' => $vars['entity']->titlecolor )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:text:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[textcolor]', 'value' => $vars['entity']->textcolor )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:link:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[linkcolor]', 'value' => $vars['entity']->linkcolor )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:link:hovercolor'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[linkhovercolor]', 'value' => $vars['entity']->linkhovercolor )); ?>
		</p>

		<h4><?php echo elgg_echo('adf_platform:config:styles:headerfooter'); ?></h4>
		<p><label><?php echo elgg_echo('adf_platform:color1:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color1]', 'value' => $vars['entity']->color1 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color4:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color4]', 'value' => $vars['entity']->color4 )); ?>
		</p>

		<h4><?php echo elgg_echo('adf_platform:config:styles:groupmodules'); ?></h4>
		<p><label><?php echo elgg_echo('adf_platform:color2:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color2]', 'value' => $vars['entity']->color2 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color3:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color3]', 'value' => $vars['entity']->color3 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color14:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color14]', 'value' => $vars['entity']->color14 )); ?>
		</p>

		<h4><?php echo elgg_echo('adf_platform:config:styles:buttons'); ?></h4>
		<p><label><?php echo elgg_echo('adf_platform:color5:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color5]', 'value' => $vars['entity']->color5 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color6:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color6]', 'value' => $vars['entity']->color6 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color7:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color7]', 'value' => $vars['entity']->color7 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color8:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color8]', 'value' => $vars['entity']->color8 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color15:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color15]', 'value' => $vars['entity']->color15 )); ?>
		</p>

		<!--
		<p><label><?php echo elgg_echo('adf_platform:color9:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color9]', 'value' => $vars['entity']->color9 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color10:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color10]', 'value' => $vars['entity']->color10 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color11:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color11]', 'value' => $vars['entity']->color11 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color12:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color12]', 'value' => $vars['entity']->color12 )); ?>
		</p>
		//-->
		<p><label><?php echo elgg_echo('adf_platform:color13:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color13]', 'value' => $vars['entity']->color13 )); ?>
		</p>

		<p><label><?php echo elgg_echo('adf_platform:css'); ?></label><br />
			<?php echo elgg_echo('adf_platform:css:help'); ?>
			<?php echo elgg_view('input/plaintext', array( 'name' => 'params[css]', 'value' => $vars['entity']->css, 'js' => ' style="min-height:500px;"' )); ?>
		</p>
	</div>


	<h3>EXPERT</h3>
	<div>
		<?php
		// Advanced search tool (alpha version, structure changes may happen)
		$esope_search_url = $CONFIG->url . 'esearch';
		echo ' <p><label>' . elgg_echo('esope:search:setting:metadata') . '</label> ' . elgg_view('input/text', array( 'name' => 'params[metadata_search_fields]', 'value' => $vars['entity']->metadata_search_fields)) . '<a href="'.$esope_search_url.'" target="_new">'.$esope_search_url.'</a></p>';
		
		// Suppression des menus de l'utilisateur
		echo ' <p><label>' . elgg_echo('adf_platform:settings:removeusermenutools') . '</label> ' . elgg_view('input/text', array( 'name' => 'params[remove_user_menutools]', 'value' => $vars['entity']->remove_user_menutools )) . '</p>';
		
		// Suppression des outils personnels (lien de création) de l'utilisateur
		echo ' <p><label>' . elgg_echo('adf_platform:settings:removeusertools') . '</label> ' . elgg_view('input/text', array( 'name' => 'params[remove_user_tools]', 'value' => $vars['entity']->remove_user_tools )) . '<em>' . implode(',', $registered_objects) . '</em></p>';
		// Note : la suppression de filtres dans les listings est un réglage général à part, 
		// car pas forcément pertinent si on liste aussi les contenus créés dans les groupes par un membre
		
		// Suppression des niveaux d'accès pour les membres
		echo ' <p><label>' . elgg_echo('adf_platform:settings:user_exclude_access') . '</label> ' . elgg_view('input/text', array( 'name' => 'params[user_exclude_access]', 'value' => $vars['entity']->user_exclude_access )) . '</p>';
		
		// Suppression des niveaux d'accès pour les admins (franchement déconseillé)
		echo ' <p><label>' . elgg_echo('adf_platform:settings:admin_exclude_access') . '</label> ' . elgg_view('input/text', array( 'name' => 'params[admin_exclude_access]', 'value' => $vars['entity']->admin_exclude_access )) . '</p>';
		?>
	</div>


	<h3><?php echo elgg_echo('adf_platform:config:saverestore'); ?></h3>
	<div>
		<p><?php echo elgg_echo('adf_platform:config:saverestore:details'); ?></p>

		<h4><?php echo elgg_echo('adf_platform:config:import'); ?></h4>
		<p><?php echo elgg_echo('adf_platform:config:import:details'); ?></p>
		<?php
		// Saisie des données à restaurer
		echo elgg_view('input/plaintext', array( 'name' => 'params[import_settings]', 'value' => $vars['entity']->import_settings));
		?>

		<h4><?php echo elgg_echo('adf_platform:config:export'); ?></h4>
		<p><?php echo elgg_echo('adf_platform:config:export:details'); ?></p>
		<?php
		$plugin_settings = $vars['entity']->getAllSettings();
		$plugin_settings = serialize($plugin_settings);
		$plugin_settings = mb_encode_numericentity($plugin_settings, array (0x0, 0xffff, 0, 0xffff), 'UTF-8');
		$plugin_settings = htmlentities($plugin_settings, ENT_QUOTES, 'UTF-8');
		echo '<textarea readonly="readonly" onclick="this.select()">' . $plugin_settings . '</textarea>';
		?>
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



