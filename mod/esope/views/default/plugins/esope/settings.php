<?php
/**
 * ESOPE plugin settings
 * Ces réglages permettent d'ajuster le comportement et l'apparence de la plateforme et du thème.
 *
*/

$url = elgg_get_site_url();
$plugin = $vars['entity'];
$settings_version = '1.12';


// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );

$no_yes_force_opt = $no_yes_opt;
$no_yes_force_opt['force'] = elgg_echo('option:force');

$no_yes_groupoption_opt = $no_yes_opt;
$no_yes_groupoption_opt['groupoption'] = elgg_echo('option:groupoption');

$replace_homepage_opt = $no_yes_opt;
$replace_public_homepage_opt = array('default' => elgg_echo('esope:replacehome:default'), 'cmspages' => elgg_echo('esope:replacehome:cmspages'), 'no' => elgg_echo('esope:replacehome:no') );

$groups_discussion_opt = $yes_no_opt;
$groups_discussion_opt['always'] = elgg_echo('esope:settings:groups:discussion:always');

$group_tools_default_opt = $no_yes_opt;
$group_tools_default_opt['auto'] = elgg_echo('esope:settings:groups:tools_default:auto');

$groups_disable_widgets_opt = $no_yes_opt;
$groups_disable_widgets_opt['public'] = elgg_echo('esope:groups:disable_widgets:public');
$groups_disable_widgets_opt['loggedin'] = elgg_echo('esope:groups:disable_widgets:loggedin');

$pages_list_subpages_opt = $no_yes_opt;
$pages_list_subpages_opt['user'] = elgg_echo('esope:settings:pages_list_subpages:user');
$pages_list_subpages_opt['group'] = elgg_echo('esope:settings:pages_list_subpages:group');
//$pages_list_subpages_opt['all'] = elgg_echo('esope:settings:pages_list_subpages:all');

$registered_objects = get_registered_entity_types('object');

$group_defaultaccess_opt = array('default' => elgg_echo('esope:groupdefaultaccess:default'), 'groupvis' => elgg_echo('esope:groupdefaultaccess:groupvis'), 'group' => elgg_echo('esope:groupdefaultaccess:group'), 'members' => elgg_echo('esope:groupdefaultaccess:members'), 'public' => elgg_echo('esope:groupdefaultaccess:public'));

$group_groupjoin_enablenotif_opt = array(
		'email' => elgg_echo('option:notify:email'),
		'site' => elgg_echo('option:notify:site'),
		'all' => elgg_echo('option:notify:all'),
		'no' => elgg_echo('option:notify:no'),
	);

$invite_picker_opt = array(
		'friendspicker' => elgg_echo('esope:invite_picker:friendspicker'),
		'userpicker' => elgg_echo('esope:invite_picker:userpicker'),
	);



// Restore previous values from Elgg 1.8 adf_public_platform plugin
// 1.8 => 1.9 : always apply if settings_version is not set
if (empty($plugin->settings_version)) {
	$ia = elgg_set_ignore_access(true);
	$ih = access_show_hidden_entities(true);
	
	$restore_18_settings = array('add_profile_activity', 'admin_exclude_access', 'advanced_pagination', 'advancedsearch', 'allowregister', 'analytics', 'awesomefont', 'backgroundcolor', 'backgroundimg', 'blog_user_listall', 'bookmarks_user_listall', 'brainstorm_user_listall', 'closedgroups_defaultaccess', 'color1', 'color2', 'color3', 'color4', 'color5', 'color6', 'color7', 'color8', 'color9', 'color10', 'color11', 'color12', 'color13', 'color14', 'color15', 'css', 'custom_profile_layout', 'dashboardheader', 'disable_all', 'disable_friends', 'disable_mine', 'faviconurl', 'file_user_listall', 'firststeps_guid', 'fixedwidth', 'font1', 'font2', 'font3', 'font4', 'font5', 'font6', 'footer', 'framekiller', 'group_hide_profile_field', 'groupjoin_enablenotif', 'groups_add_activity', 'groups_add_publish_tools', 'groups_alpha', 'groups_disable_widgets', 'groups_disclaimer', 'groups_discussion', 'groups_featured', 'groups_friendstab', 'groups_newest', 'groups_popular', 'groups_searchtab', 'groups_tags', 'groups_topmenu', 'group_tools_default', 'headerimg', 'headertitle', 'helplink', 'hide_directory', 'homegroup_autojoin', 'homegroup_guid', 'homegroup_index', 'homeintro', 'homesite_index', 'import_settings', 'index_groups', 'index_members', 'index_recent_members', 'index_wire', 'invite_anyone', 'linkcolor', 'linkhovercolor', 'members_alpha', 'members_newest', 'members_onesearch', 'members_online', 'members_onlinetab', 'members_popular', 'members_profiletypes', 'members_searchtab', 'metadata_groupsearch_fields', 'metadata_membersearch_fields', 'metadata_search_fields', 'notification_css', 'opengroups_defaultaccess', 'pages_list_subpages', 'pages_reorder', 'pages_user_listall', 'publicpages', 'public_profiles', 'public_profiles_default', 'redirect', 'register_joingroups', 'remove_collections', 'remove_profile_widgets', 'remove_user_menutools', 'remove_user_tools', 'replace_home', 'replace_public_homepage', 'semanticui', 'textcolor', 'titlecolor', 'contactemail', 'rss', 'twitter', 'facebook', 'googleplus', 'linkedin', 'netvibes', 'flickr', 'youtube', 'vimeo', 'dailymotion', 'vine', 'instagram', 'github', 'delicious', 'pinterest', 'tumblr', 'slideshare', 'user_exclude_access', 'widget_blog', 'widget_bookmarks', 'widget_brainstorm', 'widget_event_calendar', 'widget_export_embed', 'widget_file', 'widget_file_folder', 'widget_freehtml', 'widget_friends', 'widget_group_activity', 'widget_groups', 'widget_messages', 'widget_pages', 'widget_river_widget', 'widget_searchresults', 'widget_tagcloud', 'widget_thewire', 'widget_twitter', 'widget_videos', 'widget_webprofiles');
	foreach ($restore_18_settings as $setting) {
		//echo "<b>$setting :</b> $value<hr />";
		$value = elgg_get_plugin_setting($setting, 'adf_public_platform');
		$plugin->setSetting($setting, $value);
	}
	// Update marker
	$plugin->settings_version = '1.12';
	elgg_set_ignore_access($ia);
	access_show_hidden_entities($ih);
	echo elgg_echo('esope:restore:previousversion:success');
}

// Further updates (since 1.9)
if ($plugin->settings_version != $settings_version) {}



// SET DEFAULT VALUES

/* Unused since new theme w/ Urbilog
// Banner content
if (!isset($plugin->header) || ($plugin->header == 'RAZ')) { $plugin->header = elgg_echo('esope:header:default'); }
// header background URL
if (strlen($plugin->headbackground) == 0) { $plugin->headbackground = $url . 'mod/esope/img/headimg.jpg'; }
// header background height
if (strlen($plugin->headheight) == 0) { $plugin->headheight = 330; }
// Footer content
if (strlen($plugin->footer) == 0) { $plugin->footer = elgg_echo('esope:footer:default'); }
*/

// Homepage replacement
if (empty($plugin->replace_public_homepage)) { $plugin->replace_public_homepage == 'default'; }

// Header image
//if (empty($plugin->headerimg)) { $plugin->headerimg = 'mod/esope/img/theme/departement.png'; }
if (empty($plugin->backgroundcolor)) { $plugin->backgroundcolor = '#efeeea'; }
//if (empty($plugin->backgroundimg)) { $plugin->backgroundimg = 'mod/esope/img/theme/motif_fond.jpg'; }

// STYLES : see css/elgg view for style load & use
// Set default colors - theme esope
// Titles
if (empty($plugin->titlecolor)) { $plugin->titlecolor = '#0A2C83'; }
if (empty($plugin->textcolor)) { $plugin->textcolor = '#333333'; }
// Links
if (empty($plugin->linkcolor)) { $plugin->linkcolor = '#002E6E'; }
if (empty($plugin->linkhovercolor)) { $plugin->linkhovercolor = '#0A2C83'; }
// Header-footer color + various other use (menu + input borders and focus...)
if (empty($plugin->color1)) { $plugin->color1 = '#0050BF'; }
if (empty($plugin->color4)) { $plugin->color4 = '#002E6E'; }
// Widget + Group modules
if (empty($plugin->color2)) { $plugin->color2 = '#F75C5C'; }
if (empty($plugin->color3)) { $plugin->color3 = '#C61B15'; }
// Buttons
if (empty($plugin->color5)) { $plugin->color5 = '#014FBC'; }
if (empty($plugin->color6)) { $plugin->color6 = '#033074'; }
if (empty($plugin->color7)) { $plugin->color7 = '#FF0000'; }
if (empty($plugin->color8)) { $plugin->color8 = '#990000'; }
// Module title
if (empty($plugin->color14)) { $plugin->color14 = '#FFFFFF'; }
// Button title
if (empty($plugin->color15)) { $plugin->color15 = '#FFFFFF'; }
// Divers Gris - utilisés dans interface essentiellement (mieux vaut ne pas modifier)
if (empty($plugin->color9)) { $plugin->color9 = '#CCCCCC'; }
if (empty($plugin->color10)) { $plugin->color10 = '#999999'; }
if (empty($plugin->color11)) { $plugin->color11 = '#333333'; }
if (empty($plugin->color12)) { $plugin->color12 = '#DEDEDE'; }
// Sub-menu
if (empty($plugin->color13)) { $plugin->color13 = '#FFFFFF'; }
// Fonts
if (empty($plugin->font1)) { $plugin->font1 = 'Lato, sans-serif'; }
if (empty($plugin->font2)) { $plugin->font2 = 'Lato-bold, sans-serif'; }
if (empty($plugin->font3)) { $plugin->font3 = 'Puritan, sans-serif'; }
if (empty($plugin->font4)) { $plugin->font4 = 'Puritan, Arial, sans-serif'; }
if (empty($plugin->font5)) { $plugin->font5 = 'Monaco, "Courier New", Courier, monospace'; }
if (empty($plugin->font6)) { $plugin->font6 = 'Georgia, times, serif'; }

// Footer background color
//if (empty($plugin->footercolor)) { $plugin->footercolor = '#555555'; }
// Additionnal CSS content - loaded at the end
if (strlen($plugin->css) == 0) { $plugin->css = elgg_echo('esope:css:default'); }

// Footer
if (!isset($plugin->footer) || ($plugin->footer == 'RAZ')) {
	$plugin->footer = '<ul>
				<li><a href="#">Charte</a></li>
				<li><a href="#">Mentions légales</a></li>
				<li><a href="#">A propos</a></li>
				<li><a href="#">Contact</a></li>
			</ul>
			<a href="#" target="_blank"><img src="' . $url . 'mod/theme_yourtheme/graphics/logo.png" alt="Logo" /></a>';
}

if (empty($plugin->opengroups_defaultaccess)) { $plugin->opengroups_defaultaccess = 'groupvis'; }
if (empty($plugin->closedgroups_defaultaccess)) { $plugin->closedgroups_defaultaccess = 'group'; }
if (empty($plugin->awesomefont)) { $plugin->awesomefont = 'yes'; }
if (empty($plugin->fixedwidth)) { $plugin->fixedwidth = 'no'; }

// Hide by default some profile fields that are known to be used for configuration but should not be displayed
if (!isset($plugin->group_hide_profile_field)) { $plugin->group_hide_profile_field = 'customcss, cmisfolder, feed_url, customtab1, customtab2, customtab3, customtab4, customtab5, customtab6, customtab7, customtab8'; }

//Set archive and old group marker
if (empty($plugin->groups_archive)) { $plugin->groups_archive = 'yes'; }
if (empty($plugin->groups_old_display)) { $plugin->groups_old_display = 'yes'; }
if (empty($plugin->groups_old_timeframe)) { $plugin->groups_old_timeframe = 15552000; } // 3600 * 24 * 30 * 6 (about 6 months)

// Auto-join groups : init with alternate plugin config if exists
if (!isset($plugin->groups_autojoin)) {
	$plugin->groups_autojoin = elgg_get_plugin_setting('systemgroups', 'autosubscribegroup');
}


// CORRECT BAD-FORMATTED VALUES
// Remove spaces
if (!empty($plugin->remove_user_tools) && (strpos($plugin->remove_user_tools, ' ') != false)) $plugin->remove_user_tools = str_replace(' ', '', $plugin->remove_user_tools);



// Restauration d'une sauvegarde précédente :
if (!empty($plugin->import_settings)) {
	$import_settings = $plugin->import_settings;
	echo '<h3>' . elgg_echo('esope:restore:title') . '</h3>';
	/*
	$import_settings = mb_encode_numericentity($import_settings, array (0x0, 0xffff, 0, 0xffff), 'UTF-8');
	$import_settings = htmlentities($import_settings, ENT_QUOTES, 'UTF-8');
	*/
	$import_settings = html_entity_decode($import_settings, ENT_QUOTES, 'UTF-8');
	$import_settings = str_replace('-',';&#',$import_settings);
	$import_settings = str_replace('&amp;','&',$import_settings);
	$import_settings = mb_decode_numericentity($import_settings, array (0x0, 0xffff, 0, 0xffff), 'UTF-8');
	//$import_settings = convert_uudecode($import_settings);
	if ($import_settings = unserialize($import_settings)) {
		echo elgg_echo('esope:restore:readok') . '<br />';
		// Pas besoin de tout supprimer : on peut se contenter de mettre à jour ce qui est spécifié, et uniquement ça (évite de virer de nouveaux champs par exemple)
		//$plugin->unsetAllSettings();
		//echo "Suppression anciens paramètres...OK<br />";
		$restore_count = 0;
		$restore_same = 0;
		$restore_updated = 0;
		foreach ($import_settings as $name => $value) {
			$restore_count++;
			if ($name == 'import_settings') { continue; }
			$old = htmlentities($plugin->$name, ENT_QUOTES, 'UTF-8');
			$new = htmlentities($value, ENT_QUOTES, 'UTF-8');
			if ($old == $new) {
				//echo "<strong>$name : <strong>non modifié</strong> => $new";
				$restore_same++;
			} else {
				echo elgg_echo('esope:restore:settingvalue', array($name, $old, $new));
				$plugin->setSetting($name, $value);
				$restore_updated++;
			}
		}
		$plugin->import_settings = '';
		$restore_report = elgg_echo('esope:restore:report', array($restore_count, $restore_updated, $restore_same));
		system_message($restore_report);
		echo $restore_report;
	} else {
		register_error(elgg_echo('esope:restore:error:invalidata'));
	}
}



/*
// Tests avec tabs : non finalisés // en fait c'est mieux avec des onglets en accordéon..
$class = "esope-settings";
$tabs[] = array('title' => "Config générale", 'url' => "#general", 'id' => "esope-settings-general", 'class' => $class);
$tabs[] = array('title' => "Interface", 'url' => "#interface", 'id' => "esope-settings-interface", 'class' => $class);
$tab_content = '<div id="esope-settings-general" class="esope-settings">Config générale</div>
<div id="esope-settings-interface" class="esope-settings">Config interface</div>';
echo '<div id="esope-settings-tabs">
	<?php echo elgg_view('navigation/tabs', array('tabs' => $tabs)); ?>
</div>
<div id="esope-settings-wrapper">
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
	$('#esope-settings-accordion').accordion({ header: 'h3', autoHeight: false, heightStyle: 'content' });
});
</script>

<div id="esope-settings-accordion">
	<p><?php echo elgg_echo('esope:homeintro'); ?></p>



	<!-- ACCUEIL PUBLIC //-->
	<h3><i class="fa fa-home"></i> <?php echo elgg_echo('esope:config:publichomepage'); ?></h3>
	<div>
		<?php echo '<p><label>' . elgg_echo('esope:settings:replace_public_homepage'); ?> 
			<?php echo elgg_view('input/select', array('name' => 'params[replace_public_homepage]', 'options_values' => $replace_public_homepage_opt, 'value' => $plugin->replace_public_homepage)) . '</label>'; ?>
		</p>
		<?php
		// Note : les réglages s'appliquent sur la page d'accueil par défaut en mode walled garden, qui peut être gérée par cmspages
		if (empty($plugin->replace_public_homepage) || ($plugin->replace_public_homepage == 'default')) { 
			 echo '<p><label>' . elgg_echo('esope:homeintro');
				echo elgg_view('input/longtext', array('name' => 'params[homeintro]', 'value' => $plugin->homeintro, 'class' => 'elgg-input-rawtext')) . '</label></p>';
		} else if ($plugin->replace_public_homepage == 'cmspages') {
			if (!elgg_is_active_plugin('cmspages')) { register_error(elgg_echo('esope:cmspages:notactivated')); }
			echo '<a href="' . elgg_get_site_url() . 'cmspages/?pagetype=homepage-public" target="_new">' . elgg_echo('esope:homepage:cmspages:editlink') . '</a>';
		}
		?>
	</div>


	<!-- ACCUEIL CONNECTE //-->
	<h3><i class="fa fa-home"></i> <?php echo elgg_echo('esope:config:loggedhomepage'); ?></h3>
	<div>
		<?php
		echo '<p><label>' . elgg_echo('esope:settings:replace_home') . '</label>';
			echo elgg_view('input/select', array('name' => 'params[replace_home]', 'options_values' => $no_yes_opt, 'value' => $plugin->replace_home));
		echo '</p>';
		
		// Remplacement de la Home (activité) par un tableau de bord configurable
		if ($plugin->replace_home == 'yes') {
			// Premiers pas (page à afficher/masquer)
			echo '<p><label>' . elgg_echo('esope:settings:firststeps') . '</label><br />';
			echo elgg_echo('esope:settings:firststeps:help');
				echo elgg_view('input/text', array('name' => 'params[firststeps_guid]', 'value' => $plugin->firststeps_guid));
			echo '</p>';
			// Entête configurable
			echo '<p><label>' . elgg_echo('esope:dashboardheader') . '</label>'; ?>
				<?php echo elgg_view('input/longtext', array('name' => 'params[dashboardheader]', 'value' => $plugin->dashboardheader));
			echo '</p>';
			// Colonne centrale
			if (elgg_is_active_plugin('thewire')) {
				echo '<p><label>' . elgg_echo('esope:index_wire') . '</label>';
					echo elgg_view('input/select', array('name' => 'params[index_wire]', 'options_values' => $no_yes_opt, 'value' => $plugin->index_wire));
			echo '</p>';
			}
			
			// Colonne gauche
			echo '<fieldset>';
			if (elgg_is_active_plugin('groups')) {
				echo '<p><label>' . elgg_echo('esope:index_groups') . '</label>'; ?>
					<?php echo elgg_view('input/select', array('name' => 'params[index_groups]', 'options_values' => $no_yes_opt, 'value' => $plugin->index_groups));
				echo '</p>';
			}
			if (elgg_is_active_plugin('members')) {
				echo '<p><label>' . elgg_echo('esope:index_members') . '</label>';
					echo elgg_view('input/select', array('name' => 'params[index_members]', 'options_values' => $no_yes_opt, 'value' => $plugin->index_members));
				echo '</p>';
				echo '<p><label>' . elgg_echo('esope:index_recent_members') . '</label>';
					echo elgg_view('input/select', array('name' => 'params[index_recent_members]', 'options_values' => $no_yes_opt, 'value' => $plugin->index_recent_members));
				echo '</p>';
			}
			// Colonne droite
			if (elgg_is_active_plugin('groups')) {
				echo '<p><label>' . elgg_echo('esope:homegroup_guid') . '</label>';
					echo elgg_view('input/groups_select', array('name' => 'params[homegroup_guid]', 'value' => $plugin->homegroup_guid, 'empty_value' => true));
				echo '</p>';
				echo '<p><label>' . elgg_echo('esope:homegroup_autojoin') . '</label>';
					echo elgg_view('input/select', array('name' => 'params[homegroup_autojoin]', 'options_values' => $no_yes_force_opt, 'value' => $plugin->homegroup_autojoin));
				echo '</p>';
				echo '<p><label>' . elgg_echo('esope:homegroup_index') . '</label>';
					echo elgg_view('input/select', array('name' => 'params[homegroup_index]', 'options_values' => $no_yes_opt, 'value' => $plugin->homegroup_index));
				echo '</p>';
				echo '<p><label>' . elgg_echo('esope:homesite_index') . '</label>';
					echo elgg_view('input/select', array('name' => 'params[homesite_index]', 'options_values' => $no_yes_opt, 'value' => $plugin->homesite_index));
				echo '</p>';
			}
			echo '</fieldset>';
			
		} ?>
	</div>



<!-- INTERFACE //-->
	<h3><i class="fa fa-picture-o"></i> <?php echo elgg_echo('esope:config:interface'); ?></h3>
	<div>
		<?php
		if (!empty($plugin->faviconurl)) {
			echo '<img src="' . $url . $plugin->faviconurl . '" style="float:right; max-height:64px; max-width:64px; background:black;" />';
		}
		
		echo '<p><label>' . elgg_echo('esope:faviconurl') . '</label><br />'; 
			 echo elgg_echo('esope:faviconurl:help') . '<br />';
			echo $url . elgg_view('input/text', array('name' => 'params[faviconurl]', 'value' => $plugin->faviconurl, 'style' => 'width:50%;')); ?>
		</p>

		<?php echo '<p><label>' . elgg_echo('esope:headertitle') . '</label><br />'; 
			 echo elgg_echo('esope:headertitle:help'); 
			 echo elgg_view('input/text', array('name' => 'params[headertitle]', 'value' => $plugin->headertitle)); ?>
		</p>

		<?php
		if (!empty($plugin->headerimg)) {
			echo '<img src="' . $url . $plugin->headerimg . '" style="float:right; max-height:50px; max-width:600px; background:black;" />';
		}
		echo '<p><label>' . elgg_echo('esope:settings:headerimg') . '</label><br />';
			echo elgg_echo('esope:settings:headerimg:help') . '<br />';
			echo $url . elgg_view('input/text', array('name' => 'params[headerimg]', 'value' => $plugin->headerimg, 'style' => 'width:50%;')); ?>
		</p>
		
		<?php echo '<p><label>' . elgg_echo('esope:settings:helplink') . '</label><br />'; 
			 echo elgg_echo('esope:settings:helplink:help') . '<br />';
			echo $url . elgg_view('input/text', array('name' => 'params[helplink]', 'value' => $plugin->helplink, 'style' => 'width:50%;')); ?>
		</p>
		
		<?php
		if (!empty($plugin->faviconurl)) {
			echo '<img src="'. $url . $plugin->backgroundimg . '" style="float:right; max-height:100px; max-width:200px; background:black;" />';
		}
		echo '<p><label>' . elgg_echo('esope:settings:backgroundimg') . '</label><br />'; 
			 echo elgg_echo('esope:settings:backgroundimg:help') . '<br />';
			echo $url . elgg_view('input/text', array('name' => 'params[backgroundimg]', 'value' => $plugin->backgroundimg, 'style' => 'width:50%;')); ?>
		</p>

		<?php echo '<p><label>' . elgg_echo('esope:settings:footer') . '</label>';
			echo elgg_view('input/longtext', array('name' => 'params[footer]', 'value' => $plugin->footer)); ?>
		</p>

		<?php echo '<p><label>' . elgg_echo('esope:settings:analytics') . '</label>';
			echo elgg_view('input/plaintext', array('name' => 'params[analytics]', 'value' => $plugin->analytics)); ?>
		</p>

		<?php echo '<p><label>' . elgg_echo('esope:settings:publicpages') . '</label><br />'; 
			 echo elgg_echo('esope:settings:publicpages:help'); 
			 // un nom de pages par ligne demandé (plus clair), mais on acceptera aussi séparé par virgules et point-virgule en pratique
			echo elgg_view('input/plaintext', array('name' => 'params[publicpages]', 'value' => $plugin->publicpages));
			?>
		</p>
	</div>



<!-- STYLES //-->
	<h3><i class="fa fa-paint-brush"></i> <?php echo elgg_echo('esope:config:styles'); ?></h3>
	<div>
		<?php
		echo '<p><label>Font Awesome</label> ' . elgg_view('input/select', array('name' => 'params[awesomefont]', 'options_values' => $yes_no_opt, 'value' => $plugin->awesomefont)) . '</p>';
		echo '<p><label>Fixed width</label> ' . elgg_view('input/select', array('name' => 'params[fixedwidth]', 'options_values' => $no_yes_opt, 'value' => $plugin->fixedwidth)) . '</p>';
		echo '<p><label>(alpha) Semantic UI</label> ' . elgg_view('input/select', array('name' => 'params[semanticui]', 'options_values' => $no_yes_opt, 'value' => $plugin->semanticui)) . '</p><p>Attention : despite its promising functionnalities, using Semantic UI can have unexpected effects on various jQuery elements, such as accordion and other existing JS tools. Please test carefully before using on a production site.</p>';
		
		echo '<h4>' . elgg_echo('esope:fonts') . '</h4>';
		echo '<p><em>' . elgg_echo('esope:fonts:details') . '</em></p>';
		
		echo '<p><label>' . elgg_echo('esope:font1') . '</label>';
			echo elgg_view('input/text', array('name' => 'params[font1]', 'value' => $plugin->font1)); ?>
		</p>
		<?php echo '<p><label>' . elgg_echo('esope:font2') . '</label>';
			echo elgg_view('input/text', array('name' => 'params[font2]', 'value' => $plugin->font2)); ?>
		</p>
		<?php echo '<p><label>' . elgg_echo('esope:font3') . '</label>';
			echo elgg_view('input/text', array('name' => 'params[font3]', 'value' => $plugin->font3)); ?>
		</p>
		<?php echo '<p><label>' . elgg_echo('esope:font4') . '</label>';
			echo elgg_view('input/text', array('name' => 'params[font4]', 'value' => $plugin->font4)); ?>
		</p>
		<?php echo '<p><label>' . elgg_echo('esope:font5') . '</label>';
			echo elgg_view('input/text', array('name' => 'params[font5]', 'value' => $plugin->font5)); ?>
		</p>
		<?php echo '<p><label>' . elgg_echo('esope:font6') . '</label>';
			echo elgg_view('input/text', array('name' => 'params[font6]', 'value' => $plugin->font6)); ?>
		</p>
		
		<?php echo '<h4>' . elgg_echo('esope:colors') . '</h4>'; 
		echo '<p><em>' . elgg_echo('esope:colors:details') . '</em></p>'; 
		echo '<p><label>' . elgg_echo('esope:settings:backgroundcolor') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[backgroundcolor]', 'value' => $plugin->backgroundcolor));
		echo '</p>'; ?>
		
		<?php echo '<p><label>' . elgg_echo('esope:title:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[titlecolor]', 'value' => $plugin->titlecolor));
		echo '</p>'; ?>
		
		<?php echo '<p><label>' . elgg_echo('esope:text:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[textcolor]', 'value' => $plugin->textcolor));
		echo '</p>'; ?>

		<?php echo '<p><label>' . elgg_echo('esope:link:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[linkcolor]', 'value' => $plugin->linkcolor));
		echo '</p>'; ?>
		
		<?php echo '<p><label>' . elgg_echo('esope:link:hovercolor') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[linkhovercolor]', 'value' => $plugin->linkhovercolor));
		echo '</p>'; ?>

		<?php echo '<h4>' . elgg_echo('esope:config:styles:headerfooter') . '</h4>'; ?>
		<?php echo '<p><label>' . elgg_echo('esope:color1:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color1]', 'value' => $plugin->color1));
		echo '</p>'; ?>
		
		<?php echo '<p><label>' . elgg_echo('esope:color4:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color4]', 'value' => $plugin->color4));
		echo '</p>'; ?>

		<?php echo '<h4>' . elgg_echo('esope:config:styles:groupmodules') . '</h4>'; ?>
		<?php echo '<p><label>' . elgg_echo('esope:color2:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color2]', 'value' => $plugin->color2));
		echo '</p>';
		echo '<p><label>' . elgg_echo('esope:color3:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color3]', 'value' => $plugin->color3));
		echo '</p>';
		echo '<p><label>' . elgg_echo('esope:color14:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color14]', 'value' => $plugin->color14));
		echo '</p>'; ?>

		<?php echo '<h4>' . elgg_echo('esope:config:styles:buttons') . '</h4>'; ?>
		<?php echo '<p><label>' . elgg_echo('esope:color5:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color5]', 'value' => $plugin->color5));
		echo '</p>';
		echo '<p><label>' . elgg_echo('esope:color6:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color6]', 'value' => $plugin->color6));
		echo '</p>';
		echo '<p><label>' . elgg_echo('esope:color7:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color7]', 'value' => $plugin->color7));
		echo '</p>';
		echo '<p><label>' . elgg_echo('esope:color8:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color8]', 'value' => $plugin->color8));
		echo '</p>';
		echo '<p><label>' . elgg_echo('esope:color15:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color15]', 'value' => $plugin->color15));
		echo '</p>';
		?>

		<!--
		<?php echo '<p><label>' . elgg_echo('esope:color9:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color9]', 'value' => $plugin->color9)); ?>
		</p>
		<?php echo '<p><label>' . elgg_echo('esope:color10:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color10]', 'value' => $plugin->color10)); ?>
		</p>
		<?php echo '<p><label>' . elgg_echo('esope:color11:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color11]', 'value' => $plugin->color11)); ?>
		</p>
		<?php echo '<p><label>' . elgg_echo('esope:color12:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color12]', 'value' => $plugin->color12)); ?>
		</p>
		//-->
		<?php echo '<p><label>' . elgg_echo('esope:color13:color') . '</label>';
			echo elgg_view('input/color', array('name' => 'params[color13]', 'value' => $plugin->color13)); ?>
		</p>

		<?php echo '<p><label>' . elgg_echo('esope:css') . '</label><br />'; 
			 echo elgg_echo('esope:css:help'); 
			 echo elgg_view('input/plaintext', array('name' => 'params[css]', 'value' => $plugin->css, 'style' => 'min-height:500px;')); ?>
		</p>
		
		<?php
		// @TODO Notifications, Digest and Newsletter default wrappers
		if (elgg_is_active_plugin('html_email_handler')) {
			echo '<p><label>';
			echo elgg_echo('esope:html_email_handler:css');
			echo '</label><br />';
			echo elgg_echo('esope:html_email_handler:css:help');
			echo elgg_view('input/plaintext', array('name' => 'params[notification_css]', 'value' => $plugin->notification_css, 'style' => 'min-height:500px;'));
			echo '</p>';
			echo '<p>' . elgg_echo('esope:html_email_handler:wrapper:help') . '</p>';
		}
		if (elgg_is_active_plugin('digest')) {
			echo '<p>' . elgg_echo('esope:digest:css:help') . '</p>';
			echo '<p>' . elgg_echo('esope:digest:wrapper:help') . '</p>';
		}
		if (elgg_is_active_plugin('newsletter')) {
			echo '<p>' . elgg_echo('esope:newsletter:css:help') . '</p>';
			echo '<p>' . elgg_echo('esope:newsletter:wrapper:help') . '</p>';
		}
		?>
	</div>



<!-- COMPORTEMENT //-->
	<h3><i class="fa fa-cog"></i> <?php echo elgg_echo('esope:config:behaviour'); ?></h3>
	<div>
		<?php echo '<p><label>' . elgg_echo('esope:settings:redirect') . '</label><br />'; 
			 echo $url . elgg_view('input/text', array('name' => 'params[redirect]', 'value' => $plugin->redirect, 'style' => 'width:50%;')); ?>
		</p>
		
		<br />
		<?php echo '<h4>' . elgg_echo('esope:config:toolslistings') . '</h4>'; ?>
		<p><?php echo elgg_echo('esope:config:toolslistings:details'); ?></p>
		<?php
		if (elgg_is_active_plugin('blog')) {
			echo '<p><label>' . elgg_echo('esope:settings:blog_user_listall') . '</label> ' . elgg_view('input/select', array('name' => 'params[blog_user_listall]', 'options_values' => $no_yes_opt, 'value' => $plugin->blog_user_listall)) . '</p>';
		}
		if (elgg_is_active_plugin('bookmarks')) {
			echo '<p><label>' . elgg_echo('esope:settings:bookmarks_user_listall') . '</label> ' . elgg_view('input/select', array('name' => 'params[bookmarks_user_listall]', 'options_values' => $no_yes_opt, 'value' => $plugin->bookmarks_user_listall)) . '</p>';
		}
		/*
		if (elgg_is_active_plugin('brainstorm')) {
			echo '<p><label>' . elgg_echo('esope:settings:brainstorm_user_listall') . '</label> ' . elgg_view('input/select', array('name' => 'params[brainstorm_user_listall]', 'options_values' => $no_yes_opt, 'value' => $plugin->brainstorm_user_listall)) . '</p>';
		}
		*/
		if (elgg_is_active_plugin('file')) {
			echo '<p><label>' . elgg_echo('esope:settings:file_user_listall') . '</label> ' . elgg_view('input/select', array('name' => 'params[file_user_listall]', 'options_values' => $no_yes_opt, 'value' => $plugin->file_user_listall)) . '</p>';
		}
		if (elgg_is_active_plugin('pages')) {
			echo '<p><label>' . elgg_echo('esope:settings:pages_user_listall') . '</label> ' . elgg_view('input/select', array('name' => 'params[pages_user_listall]', 'options_values' => $no_yes_opt, 'value' => $plugin->pages_user_listall)) . '</p>';
			echo '<p><label>' . elgg_echo('esope:settings:pages_list_subpages') . '</label> ' . elgg_view('input/select', array('name' => 'params[pages_list_subpages]', 'options_values' => $pages_list_subpages_opt, 'value' => $plugin->pages_list_subpages)) . '</p>';
			echo '<p><label>' . elgg_echo('esope:settings:pages_reorder') . '</label> ' . elgg_view('input/select', array('name' => 'params[pages_reorder]', 'options_values' => $no_yes_opt, 'value' => $plugin->pages_reorder)) . '</p>';
		}
		
		if (elgg_is_active_plugin('thewire')) {
			echo '<p><label>' . elgg_echo('esope:settings:thewire_default_access') . ' ' . elgg_view('input/text', array('name' => 'params[thewire_default_access]', 'value' => $plugin->thewire_default_access)) . '</label><br /><em>' . elgg_echo('esope:settings:thewire_default_access:details') . '</em></p>';
		}
		
		// Add limit links to navigation
			echo '<p><label>' . elgg_echo('esope:settings:advanced_pagination') . '</label> ' . elgg_view('input/select', array('name' => 'params[advanced_pagination]', 'options_values' => $no_yes_opt, 'value' => $plugin->advanced_pagination)) . '</p>';
		?>
		
		<br />
		<?php echo '<h4>' . elgg_echo('esope:config:filters') . '</h4>'; ?>
		<?php
		echo '<p><label>' . elgg_echo('esope:settings:filters:friends') . '</label> ' . elgg_view('input/select', array('name' => 'params[disable_friends]', 'options_values' => $no_yes_opt, 'value' => $plugin->disable_friends)) . '</p>';
		echo '<p><label>' . elgg_echo('esope:settings:filters:mine') . '</label> ' . elgg_view('input/select', array('name' => 'params[disable_mine]', 'options_values' => $no_yes_opt, 'value' => $plugin->disable_mine)) . '</p>';
		echo '<p><label>' . elgg_echo('esope:settings:filters:all') . '</label> ' . elgg_view('input/select', array('name' => 'params[disable_all]', 'options_values' => $no_yes_opt, 'value' => $plugin->disable_all)) . '</p>';
		echo '<br />';
		echo '<p><label>' . elgg_echo('esope:settings:advancedsearch') . '</label> ' . elgg_view('input/select', array('name' => 'params[advancedsearch]', 'options_values' => $no_yes_opt, 'value' => $plugin->advancedsearch)) . '</p>';
		?>
	</div>



<!-- GROUPES //-->
	<?php if (elgg_is_active_plugin('groups')) {
		echo '<h3><i class="fa fa-users"></i> ' . elgg_echo('esope:config:groups') . '</h3>';
		echo '<div>';
			// Auto join groups at registration
			// Note : this setting replaces autosubscribegroup plugin
			echo '<p><label>' . elgg_echo('esope:settings:groups:autojoin') . '</label> ' . elgg_view('input/text', array('name' => 'params[groups_autojoin]', 'value' => $plugin->groups_autojoin)) . '</p>';
			// display autojoin groups list
			if (!empty($plugin->groups_autojoin)) {
				$groups_autojoin_guids = esope_get_input_array($plugin->groups_autojoin);
				if ($groups_autojoin_guids) {
					//echo elgg_view_entity_list(array('guids' => $groups_autojoin_guids));
					echo elgg_list_entities(array('guids' => $groups_autojoin_guids));
				}
			}
			// Join groups at registration
			echo '<p><label>' . elgg_echo('esope:settings:register:joingroups') . '</label> ' . elgg_view('input/select', array('name' => 'params[register_joingroups]', 'options_values' => $no_yes_opt, 'value' => $plugin->register_joingroups)) . '</p>';
			echo '<p><label>' . elgg_echo('esope:settings:groupjoin_enablenotif') . '</label> ' . elgg_view('input/select', array('name' => 'params[groupjoin_enablenotif]', 'options_values' => $group_groupjoin_enablenotif_opt, 'value' => $plugin->groupjoin_enablenotif)) . '</p>';
			// Group creation disclaimer
			echo '<p><label>' . elgg_echo('esope:settings:groups_disclaimer') . '</label>';
				echo elgg_view('input/longtext', array('name' => 'params[groups_disclaimer]', 'value' => $plugin->groups_disclaimer));
			echo '</p>';
			echo '<br />';
			// Set default tools status
			echo '<p><label>' . elgg_echo('esope:settings:groups:tools_default') . '</label> ' . elgg_view('input/select', array('name' => 'params[group_tools_default]', 'options_values' => $group_tools_default_opt, 'value' => $plugin->group_tools_default)) . '</p>';
			// Default group content access
			echo '<p><label>' . elgg_echo('esope:settings:opengroups:defaultaccess') . '</label> ' . elgg_view('input/select', array('name' => 'params[opengroups_defaultaccess]', 'options_values' => $group_defaultaccess_opt, 'value' => $plugin->opengroups_defaultaccess)) . '</p>';
			echo '<p><label>' . elgg_echo('esope:settings:closedgroups:defaultaccess') . '</label> ' . elgg_view('input/select', array('name' => 'params[closedgroups_defaultaccess]', 'options_values' => $group_defaultaccess_opt, 'value' => $plugin->closedgroups_defaultaccess)) . '</p>';
			// Group layout
			// Enable group top tab menu
			// Usage: $group->customtab1 to 8 with URL::LinkTitle::TitleProperty syntax
			echo '<p><label>' . elgg_echo('esope:settings:groups:topmenu') . ' </label> ' . elgg_view('input/select', array('name' => 'params[groups_topmenu]', 'options_values' => $no_yes_opt, 'value' => $plugin->groups_topmenu)) . '</p>';
			// Remove group widgets
			echo '<p><label>' . elgg_echo('esope:settings:groups:disable_widgets') . ' </label> ' . elgg_view('input/select', array('name' => 'params[groups_disable_widgets]', 'options_values' => $groups_disable_widgets_opt, 'value' => $plugin->groups_disable_widgets)) . '</p>';
			// Add group activity
			echo '<p><label>' . elgg_echo('esope:settings:groups:add_activity') . ' </label> ' . elgg_view('input/select', array('name' => 'params[groups_add_activity]', 'options_values' => $no_yes_opt, 'value' => $plugin->groups_add_activity)) . '</p>';
			// Add group tools publication homepage shortcuts
			echo '<p><label>' . elgg_echo('esope:settings:groups:add_publish_tools') . ' </label> ' . elgg_view('input/select', array('name' => 'params[groups_add_publish_tools]', 'options_values' => $no_yes_opt, 'value' => $plugin->groups_add_publish_tools)) . '</p>';
			echo '<br />';
			
			echo '<h4>' . elgg_echo('esope:config:groupinvites') . '</h4>';
			echo '<p><label>' . elgg_echo('esope:settings:groups:inviteanyone') . '</label> ' . elgg_view('input/select', array('name' => 'params[invite_anyone]', 'options_values' => $no_yes_opt, 'value' => $plugin->invite_anyone)) . '</p>';
			echo '<p><label>' . elgg_echo('esope:settings:groups:invite_picker') . ' ' . elgg_view('input/dropdown', array('name' => 'params[invite_picker]', 'options_values' => $invite_picker_opt, 'value' => $plugin->invite_picker)) . '</label><br /><em>' . elgg_echo('esope:settings:groups:invite_picker:details') . '</em></p>';
			echo '<p><label>' . elgg_echo('esope:settings:groups:allowregister') . '</label> ' . elgg_view('input/select', array('name' => 'params[allowregister]', 'options_values' => $no_yes_opt, 'value' => $plugin->allowregister)) . '</p>';
			echo '<br />';
			
			echo '<h4>' . elgg_echo('esope:config:grouptabs') . '</h4>';
			// Default to alpha sort
			echo '<p><label>' . elgg_echo('esope:settings:groups:alpha') . '</label> ' . elgg_view('input/select', array('name' => 'params[groups_alpha]', 'options_values' => $no_yes_opt, 'value' => $plugin->groups_alpha)) . '</p>';
			// Allow to remove newest
			echo '<p><label>' . elgg_echo('esope:settings:groups:newest') . '</label> ' . elgg_view('input/select', array('name' => 'params[groups_newest]', 'options_values' => $yes_no_opt, 'value' => $plugin->groups_newest)) . '</p>';
			// Allow to remove popular
			echo '<p><label>' . elgg_echo('esope:settings:groups:popular') . '</label> ' . elgg_view('input/select', array('name' => 'params[groups_popular]', 'options_values' => $yes_no_opt, 'value' => $plugin->groups_popular)) . '</p>';
			// Allow to add featured
			echo '<p><label>' . elgg_echo('esope:settings:groups:featured') . '</label> ' . elgg_view('input/select', array('name' => 'params[groups_featured]', 'options_values' => $no_yes_opt, 'value' => $plugin->groups_featured)) . '</p>';
			// Allow to add a new group tab search
			echo '<p><label>' . elgg_echo('esope:settings:groups:searchtab') . ' (ALPHA)</label> ' . elgg_view('input/select', array('name' => 'params[groups_searchtab]', 'options_values' => $no_yes_opt, 'value' => $plugin->groups_searchtab)) . '</p>';
		// Advanced group search tool (alpha version, structure changes may happen)
		$esope_groupsearch_url = elgg_get_site_url() . 'groups/groupsearch';
		echo '<p><label>' . elgg_echo('esope:groupsearch:setting:metadata') . '</label> ' . elgg_view('input/text', array('name' => 'params[metadata_groupsearch_fields]', 'value' => $plugin->metadata_groupsearch_fields)) . '<a href="'.$esope_groupsearch_url.'" target="_new">'.$esope_groupsearch_url.'</a></p>';

			// Allow to add a new friends groups tab
			echo '<p><label>' . elgg_echo('esope:settings:groups:friends') . '</label> ' . elgg_view('input/select', array('name' => 'params[groups_friendstab]', 'options_values' => $no_yes_opt, 'value' => $plugin->groups_friendstab)) . '</p>';
			// Add groups tags below search (or replaces search if search tab enabled)
			echo '<p><label>' . elgg_echo('esope:settings:groups:tags') . ' (ALPHA)</label> ' . elgg_view('input/select', array('name' => 'params[groups_tags]', 'options_values' => $no_yes_opt, 'value' => $plugin->groups_tags)) . '</p>';
			// Allow to remove discussion OR add it at page bottom
			echo '<p><label>' . elgg_echo('esope:settings:groups:discussion') . '</label> ' . elgg_view('input/select', array('name' => 'params[groups_discussion]', 'options_values' => $groups_discussion_opt, 'value' => $plugin->groups_discussion)) . '</p>';

			echo '<p><label>' . elgg_echo('esope:settings:groups:invite_metadata') . elgg_view('input/text', array('name' => 'params[groups_invite_metadata]', 'value' => $plugin->groups_invite_metadata)) . '</label><br /><em>' . elgg_echo('esope:settings:groups:invite_metadata:details') . '</em></p>';
			
			// Suppression de l'affichage de certains champs de profil des groupes (car utilisés pour configurer et non afficher)
			echo '<p><label>' . elgg_echo('esope:settings:group_hide_profile_field') . '</label> ' . elgg_view('input/text', array('name' => 'params[group_hide_profile_field]', 'value' => $plugin->group_hide_profile_field)) . '</p>';
		
			// Display "old group" banner
			echo '<p><label>' . elgg_echo('esope:settings:groups:old_display') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_old_display]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->groups_old_display)) . '</label></p>';
			// Set "old group" timeframe (in seconds)
			echo '<p><label>' . elgg_echo('esope:settings:groups:old_timeframe') . ' ' . elgg_view('input/text', array('name' => 'params[groups_old_timeframe]', 'value' => $vars['entity']->groups_old_timeframe)) . '</label></p>';
			// Enable group archive (using ->status == 'archive' metadata)
			echo '<p><label>' . elgg_echo('esope:settings:groups:archive') . ' ' . elgg_view('input/dropdown', array('name' => 'params[groups_archive]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->groups_archive)) . '</label></p>';
		
			?>
		</div>
	<?php } ?>


<!-- MEMBRES //-->
	<h3><i class="fa fa-user"></i> <?php echo elgg_echo('esope:config:members'); ?></h3>
	<div>
		<p>
			<label><?php echo elgg_echo('esope:home:public_profiles'); 
			 echo elgg_view('input/select', array('name' => 'params[public_profiles]', 'options_values' => $no_yes_opt, 'value' => $plugin->public_profiles)); ?>
		</label>
		</p>
		<p><em><?php echo elgg_echo('esope:home:public_profiles:help'); ?></em></p>
		<p>
			<label><?php echo elgg_echo('esope:home:public_profiles_default'); 
			 echo elgg_view('input/select', array('name' => 'params[public_profiles_default]', 'options_values' => $no_yes_opt, 'value' => $plugin->public_profiles_default)) . '</label>'; ?>
		</p>
		
		<p>
			<label><?php echo elgg_echo('esope:members:hide_directory'); 
			 echo elgg_view('input/select', array('name' => 'params[hide_directory]', 'options_values' => $no_yes_opt, 'value' => $plugin->hide_directory)) . '</label>'; ?>
		</p>
		
		<?php echo '<h4>' . elgg_echo('esope:profile:settings') . '</h4>'; ?>
		<?php echo '<p><label>' . elgg_echo('esope:profile:add_profile_activity') . '</label>';
			echo elgg_view('input/select', array('name' => 'params[add_profile_activity]', 'options_values' => $no_yes_opt, 'value' => $plugin->add_profile_activity)); ?>
		</p>
		<?php echo '<p><label>' . elgg_echo('esope:profile:remove_profile_widgets') . '</label>';
			echo elgg_view('input/select', array('name' => 'params[remove_profile_widgets]', 'options_values' => $no_yes_opt, 'value' => $plugin->remove_profile_widgets)); ?>
		</p>
		<?php echo '<p><label>' . elgg_echo('esope:profile:custom_profile_layout') . '</label>';
			echo elgg_view('input/select', array('name' => 'params[custom_profile_layout]', 'options_values' => $no_yes_opt, 'value' => $plugin->custom_profile_layout)); ?>
		</p>
		<br />
		<?php echo '<h4>' . elgg_echo('esope:config:memberssearch') . '</h4>';
		if (elgg_is_active_plugin('members')) {
			// Allow to add alpha sort
			echo '<p><label>' . elgg_echo('esope:settings:members:alpha') . '</label> ' . elgg_view('input/select', array('name' => 'params[members_alpha]', 'options_values' => $no_yes_opt, 'value' => $plugin->members_alpha)) . '</p>';
			// Allow to remove newest
			echo '<p><label>' . elgg_echo('esope:settings:members:newest') . '</label> ' . elgg_view('input/select', array('name' => 'params[members_newest]', 'options_values' => $yes_no_opt, 'value' => $plugin->members_newest)) . '</p>';
			// Allow to remove popular
			echo '<p><label>' . elgg_echo('esope:settings:members:popular') . '</label> ' . elgg_view('input/select', array('name' => 'params[members_popular]', 'options_values' => $yes_no_opt, 'value' => $plugin->members_popular)) . '</p>';
			// Allow to remove online
			echo '<p><label>' . elgg_echo('esope:settings:members:onlinetab') . '</label> ' . elgg_view('input/select', array('name' => 'params[members_onlinetab]', 'options_values' => $yes_no_opt, 'value' => $plugin->members_onlinetab)) . '</p>';
			// Allow to add profile types tabs
			echo '<p><label>' . elgg_echo('esope:settings:members:profiletypes') . '</label> ' . elgg_view('input/select', array('name' => 'params[members_profiletypes]', 'options_values' => $no_yes_opt, 'value' => $plugin->members_profiletypes)) . '</p>';
			// Allow to add a new tab search
			echo '<p><label>' . elgg_echo('esope:settings:members:searchtab') . ' (ALPHA)</label> ' . elgg_view('input/select', array('name' => 'params[members_searchtab]', 'options_values' => $no_yes_opt, 'value' => $plugin->members_searchtab)) . '</p>';
		// Advanced search tool (alpha version, structure changes may happen)
		$esope_membersearch_url = elgg_get_site_url() . 'members/search';
		echo '<p><label>' . elgg_echo('esope:membersearch:setting:metadata') . '</label> ' . elgg_view('input/text', array('name' => 'params[metadata_membersearch_fields]', 'value' => $plugin->metadata_membersearch_fields)) . '<a href="'.$esope_membersearch_url.'" target="_new">'.$esope_membersearch_url.'</a></p>';
		
			// Replace search by main search (more efficient)
			echo '<p><label>' . elgg_echo('esope:settings:members:onesearch') . '</label> ' . elgg_view('input/select', array('name' => 'params[members_onesearch]', 'options_values' => $no_yes_opt, 'value' => $plugin->members_onesearch)) . '</p>';
			// Add online members
			echo '<p><label>' . elgg_echo('esope:settings:members:online') . '</label> ' . elgg_view('input/select', array('name' => 'params[members_online]', 'options_values' => $no_yes_opt, 'value' => $plugin->members_online)) . '</p>';
		}
		
		echo '<p><label>' . elgg_echo('esope:settings:remove_collections') . '</label> ' . elgg_view('input/select', array('name' => 'params[remove_collections]', 'options_values' => $no_yes_opt, 'value' => $plugin->remove_collections)) . '</p>';
		
		// Suppression des menus de l'utilisateur
		echo '<p><label>' . elgg_echo('esope:settings:removeusermenutools') . '</label> ' . elgg_view('input/text', array('name' => 'params[remove_user_menutools]', 'value' => $plugin->remove_user_menutools)) . '</p>';
		
		// Suppression des outils personnels (lien de création) de l'utilisateur
		echo '<p><label>' . elgg_echo('esope:settings:removeusertools') . '</label> ' . elgg_view('input/text', array('name' => 'params[remove_user_tools]', 'value' => $plugin->remove_user_tools)) . '<em>' . implode(',', $registered_objects) . '</em></p>';
		// Note : la suppression de filtres dans les listings est un réglage général à part, 
		// car pas forcément pertinent si on liste aussi les contenus créés dans les groupes par un membre
		
		// Suppression des niveaux d'accès pour les membres
		echo '<p><label>' . elgg_echo('esope:settings:user_exclude_access') . '</label> ' . elgg_view('input/text', array('name' => 'params[user_exclude_access]', 'value' => $plugin->user_exclude_access)) . '</p>';
		
		// Suppression des niveaux d'accès pour les admins (franchement déconseillé)
		echo '<p><label>' . elgg_echo('esope:settings:admin_exclude_access') . '</label> ' . elgg_view('input/text', array('name' => 'params[admin_exclude_access]', 'value' => $plugin->admin_exclude_access)) . '</p>';

		?>
	</div>



<!-- WIDGETS //-->
	<h3><i class="fa fa-puzzle-piece"></i> <?php echo elgg_echo('esope:config:widgets'); ?></h3>
	<div>
		<?php
		if (elgg_is_active_plugin('blog')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:blog') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_blog]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_blog)) . '</p>';
		}
		if (elgg_is_active_plugin('bookmarks')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:bookmarks') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_bookmarks]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_bookmarks)) . '</p>';
		}
		if (elgg_is_active_plugin('brainstorm')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:brainstorm') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_brainstorm]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_brainstorm)) . '</p>';
		}
		if (elgg_is_active_plugin('event_calendar')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:event_calendar') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_event_calendar]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_event_calendar)) . '</p>';
		}
		if (elgg_is_active_plugin('file')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:file') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_file]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_file)) . '</p>';
		}
		if (elgg_is_active_plugin('file_tools')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:file_folder') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_file_folder]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_file_folder)) . '</p>';
		}
		if (elgg_is_active_plugin('groups')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:groups') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_groups]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_groups)) . '</p>';
			echo '<p><label>' . elgg_echo('esope:settings:widget:group_activity') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_group_activity]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_group_activity)) . '</p>';
		}
		if (elgg_is_active_plugin('pages')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:pages') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_pages]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_pages)) . '</p>';
		}
		echo '<p><label>' . elgg_echo('esope:settings:widget:friends') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_friends]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_friends)) . '</p>';
		if (elgg_is_active_plugin('messages')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:messages') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_messages]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_messages)) . '</p>';
		}
		echo '<p><label>' . elgg_echo('esope:settings:widget:river_widget') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_river_widget]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_river_widget)) . '</p>';
		if (elgg_is_active_plugin('twitter')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:twitter') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_twitter]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_twitter)) . '</p>';
		}
		if (elgg_is_active_plugin('thewire')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:thewire') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_thewire]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_thewire)) . '</p>';
		}
		if (elgg_is_active_plugin('tagcloud')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:tagcloud') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_tagcloud]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_tagcloud)) . '</p>';
		}
		if (elgg_is_active_plugin('videos')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:videos') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_videos]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_videos)) . '</p>';
		}
		if (elgg_is_active_plugin('profile_manager')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:profile_completeness') . '</label> ' . elgg_echo('esope:settings:widget:profile_completeness:help') . '</p>';
		}
		if (elgg_is_active_plugin('webprofiles')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:webprofiles') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_webprofiles]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_webprofiles)) . '</p>';
		}
		if (elgg_is_active_plugin('export_embed')) {
			echo '<p><label>' . elgg_echo('esope:settings:widget:export_embed') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_export_embed]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_export_embed)) . '</p>';
		}
		echo '<p><label>' . elgg_echo('esope:settings:widget:freehtml') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_freehtml]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_freehtml)) . '</p>';
		echo '<p><label>' . elgg_echo('esope:settings:widget:searchresults') . '</label> ' . elgg_view('input/select', array('name' => 'params[widget_searchresults]', 'options_values' => $yes_no_opt, 'value' => $plugin->widget_searchresults)) . '</p>';
		?>
	</div>



<!-- CONTACTS //-->
	<h3><i class="fa fa-phone"></i> <?php echo elgg_echo('esope:config:contacts'); ?></h3>
	<div>
		<p><em><?php echo elgg_echo('esope:config:contacts:details'); ?></em></p>
		<?php
		// Note : use view page/elements/social_presence for rendering
		// Important : update tools list in view if updated here !
		// @TODO : could also make this list a setting and let people update it live..
		$tools = array('contactemail', 'rss', 'twitter', 'facebook', 'googleplus', 'linkedin', 'netvibes', 'flickr', 'youtube', 'vimeo', 'dailymotion', 'vine', 'instagram', 'github', 'delicious', 'pinterest', 'tumblr', 'slideshare');
		foreach ($tools as $tool) {
			echo '<p><label>' . elgg_echo("esope:settings:$tool:icon") . ' &nbsp; ' . elgg_echo("esope:settings:$tool") . ' ' . elgg_view('input/text', array('name' => "params[$tool]", 'value' => $plugin->$tool, 'style' => 'width:50%;')) . '</label><br />' . elgg_echo("esope:settings:$tool:help") . '</p>';
		}
		?>
	</div>



<!-- SECURITE //-->
	<h3><i class="fa fa-shield"></i> <?php echo elgg_echo('esope:config:security'); ?></h3>
	<div>
		<?php
		echo elgg_echo('esope:config:security:notice');
		echo '<br />';
		echo '<p><label>' . elgg_echo('esope:config:framekiller') . '</label> ' . elgg_view('input/select', array('name' => 'params[framekiller]', 'options_values' => $no_yes_opt, 'value' => $plugin->framekiller)) . '<br />' . elgg_echo('esope:config:framekiller:details') . '</p>';
		?>
	</div>



<!-- REGLAGES EXPERTS //-->
	<h3><i class="fa fa-cogs"></i> <?php echo elgg_echo('esope:config:expert'); ?></h3>
	<div>
		<?php
		// Advanced search tool (alpha version, structure changes may happen)
		$esope_search_url = elgg_get_site_url() . 'esearch';
		echo '<p><label>' . elgg_echo('esope:search:setting:metadata') . '</label> ' . elgg_view('input/text', array('name' => 'params[metadata_search_fields]', 'value' => $plugin->metadata_search_fields)) . '<a href="'.$esope_search_url.'" target="_new">'.$esope_search_url.'</a></p>';
		
		?>
	</div>


	<!-- SAUVEGARDE ET RESTAURATION //-->
	<h3><i class="fa fa-archive"></i> <?php echo elgg_echo('esope:config:saverestore'); ?></h3>
	<div>
		<p><?php echo elgg_echo('esope:config:saverestore:details'); ?></p>

		<?php echo '<h4>' . elgg_echo('esope:config:import') . '</h4>'; ?>
		<p><?php echo elgg_echo('esope:config:import:details'); ?></p>
		<?php
		// Saisie des données à restaurer
		echo elgg_view('input/plaintext', array('name' => 'params[import_settings]', 'value' => $plugin->import_settings));
		?>
			</label>
			<em><?php echo elgg_echo('esope:config:import:details'); ?></em>
		</p><br />

		<?php echo '<h4>' . elgg_echo('esope:config:export') . '</h4>'; ?>
		<p><?php echo elgg_echo('esope:config:export:details'); ?></p>
		<?php
		$plugin_settings = $plugin->getAllSettings();
		$plugin_settings = serialize($plugin_settings);
		$plugin_settings = mb_encode_numericentity($plugin_settings, array (0x0, 0xffff, 0, 0xffff), 'UTF-8');
		$plugin_settings = str_replace(';&#','-',$plugin_settings);
		$plugin_settings = htmlentities($plugin_settings, ENT_QUOTES, 'UTF-8');
		echo '<textarea readonly="readonly" onclick="this.select()">' . $plugin_settings . '</textarea>';
		?>
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



