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

$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );
$no_yes_force_opt = $no_yes_opt;
$no_yes_force_opt['force'] = elgg_echo('option:force');

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

// No stats on homepage
if (strlen($vars['entity']->displaystats) == 0) { $vars['entity']->displaystats = 'no'; }

// Header image
if (empty($vars['entity']->headerimg)) { $vars['entity']->headerimg = 'mod/adf_public_platform/img/theme/departement.png'; }
if (empty($vars['entity']->backgroundcolor)) { $vars['entity']->backgroundcolor = '#efeeea'; }
if (empty($vars['entity']->backgroundimg)) { $vars['entity']->backgroundimg = 'mod/adf_public_platform/img/theme/motif_fond.jpg'; }
// Set default colors - theme ADF
// Titles
if (empty($vars['entity']->titlecolor)) { $vars['entity']->titlecolor = '#0A2C83'; }
if (empty($vars['entity']->textcolor)) { $vars['entity']->textcolor = '#333333'; }
// Links
if (empty($vars['entity']->linkcolor)) { $vars['entity']->linkcolor = '#002E6E'; }
if (empty($vars['entity']->linkhovercolor)) { $vars['entity']->linkhovercolor = '#0A2C83'; }
// Other colors
if (empty($vars['entity']->color1)) { $vars['entity']->color1 = '#0050BF'; }
if (empty($vars['entity']->color4)) { $vars['entity']->color4 = '#002E6E'; }
if (empty($vars['entity']->color2)) { $vars['entity']->color2 = '#F75C5C'; }
if (empty($vars['entity']->color3)) { $vars['entity']->color3 = '#C61B15'; }
// Buttons
if (empty($vars['entity']->color5)) { $vars['entity']->color5 = '#014FBC'; }
if (empty($vars['entity']->color6)) { $vars['entity']->color6 = '#033074'; }
if (empty($vars['entity']->color7)) { $vars['entity']->color7 = '#FF0000'; }
if (empty($vars['entity']->color8)) { $vars['entity']->color8 = '#990000'; }
// Divers Gris
if (empty($vars['entity']->color9)) { $vars['entity']->color9 = '#CCCCCC'; }
if (empty($vars['entity']->color10)) { $vars['entity']->color10 = '#999999'; }
if (empty($vars['entity']->color11)) { $vars['entity']->color11 = '#333333'; }
if (empty($vars['entity']->color12)) { $vars['entity']->color12 = '#DEDEDE'; }
// Sub-menu
if (empty($vars['entity']->color13)) { $vars['entity']->color13 = '#CCCCCC'; }


// Footer background color
//if (empty($vars['entity']->footercolor)) { $vars['entity']->footercolor = '#555555'; }
// Additionnal CSS content - loaded at the end
if (strlen($vars['entity']->css) == 0) { $vars['entity']->css = elgg_echo('adf_platform:css:default'); }

// Footer
if (!isset($vars['entity']->footer) || ($vars['entity']->footer == 'RAZ')) {
	$vars['entity']->footer = '<ul>
				<li><a href="' . $url . 'pages/view/3792/charte-de-departements-en-reseaux">Charte</a></li>
				<li><a href="' . $url . 'pages/view/3819/mentions-legales">Mentions légales</a></li>
				<li><a href="' . $url . 'pages/view/3827/a-propos-de-departements-en-reseaux">A propos</a></li>
				<li><a href="' . $url . 'pages/view/4701/departements-en-reseaux-et-accessibilite">Accessibilité</a></li>
				<li><a href="mailto:secretariat@departementsenreseaux.fr&subject=&body=Contact%20%depuis%20la%20page%20' . rawurlencode(full_url()) . '">Contact</a></li>
			</ul>
			<a href="http://www.departement.org/" target="_blank"><img src="' . $url . 'mod/adf_public_platform/img/theme/logo-adf.png" alt="Assemblée des Départements de France" /></a>';
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

?>
<script type="text/javascript">
$(function() {
	$('#adf-settings-accordion').accordion({ header: 'h3', autoHeight: false });
});
</script>

<div id="adf-settings-accordion">
	<p><?php echo elgg_echo('adf_platform:homeintro'); ?></p>

	<h3>PAGE D'ACCUEIL PUBLIQUE</h3>
	<div>
		<p><label><?php echo elgg_echo('adf_platform:homeintro'); ?></label>
			<?php echo elgg_view('input/longtext', array( 'name' => 'params[homeintro]', 'value' => $vars['entity']->homeintro, 'class' => 'elgg-input-rawtext' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:home:displaystats'); ?></label>
			<?php echo elgg_view('input/dropdown', array( 'name' => 'params[displaystats]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->displaystats )); ?>
		</p>
	</div>


	<h3>PAGE D'ACCUEIL CONNECTEE</h3>
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

	<h3>COMPORTEMENTS ET REGLAGES</h3>
	<div>
		<p><label><?php echo elgg_echo('adf_platform:settings:redirect'); ?></label><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[redirect]', 'value' => $vars['entity']->redirect, 'js' => 'style="width:50%;"' )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:home:public_profiles'); ?></label>
			<?php echo elgg_view('input/dropdown', array( 'name' => 'params[public_profiles]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->public_profiles )); ?>
		</p>
		
		<br />
		<h4>PAGES DE LISTING DES OUTILS</h4>
		<p>Ce réglage permet de modifier le comportement par défaut des pages de listing des blogs, fichiers, etc. Par défaut seuls les publicaitons <em>personnelles</em> du membre sont listées (pas celles dans ses groupes). Vous pouvez choisir ici de les lister toutes.</p>
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
		<h4>FILTRES</h4>
		<?php
		echo ' <p><label>' . elgg_echo('adf_platform:settings:filters:friends') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[disable_friends]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->disable_friends )) . '</p>';
		echo ' <p><label>' . elgg_echo('adf_platform:settings:filters:mine') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[disable_mine]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->disable_mine )) . '</p>';
		echo ' <p><label>' . elgg_echo('adf_platform:settings:filters:all') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[disable_all]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->disable_all )) . '</p>';
		?>
		
		<br />
		<h4>INVITATIONS DANS LES GROUPES</h4>
		<?php
		if (elgg_is_active_plugin('groups')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:groups:inviteanyone') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[invite_anyone]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->invite_anyone )) . '</p>';
		}
		?>
		
		<br />
		<h4>PAGE DE RECHERCHE DE MEMBRES</h4>
		<?php
		if (elgg_is_active_plugin('members')) {
			echo ' <p><label>' . elgg_echo('adf_platform:settings:members:onesearch') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[members_onesearch]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->members_onesearch )) . '</p>';
			echo ' <p><label>' . elgg_echo('adf_platform:settings:members:online') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[members_online]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->members_online )) . '</p>';
		}
		?>
		
	</div>
	
	<h3>WIDGETS</h3>
	<div>
		<h4>WIDGETS</h4>
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
		
		?>
	</div>

	<h3>ELEMENTS DE L'INTERFACE</h3>
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

	<h3>CONTACTS ET COORDONNEES</h3>
	<div>
		<br />
		<blockquote>Note : ces coordonnées ne sont pas utilisées par tous les thèmes (actuellement : seulement compétences numériques)</blockquote>
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:contactemail'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:contactemail:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[contactemail]', 'value' => $vars['entity']->contactemail, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:rss'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:rss:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[rss]', 'value' => $vars['entity']->rss, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:twitter'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:twitter:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[twitter]', 'value' => $vars['entity']->twitter, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:facebook'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:facebook:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[facebook]', 'value' => $vars['entity']->facebook, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:googleplus'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:googleplus:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[googleplus]', 'value' => $vars['entity']->googleplus, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:linkedin'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:linkedin:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[linkedin]', 'value' => $vars['entity']->linkedin, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:netvibes'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:netvibes:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[netvibes]', 'value' => $vars['entity']->netvibes, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:flickr'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:flickr:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[flickr]', 'value' => $vars['entity']->flickr, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:youtube'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:youtube:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[youtube]', 'value' => $vars['entity']->youtube, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:dailymotion'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:dailymotion:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[dailymotion]', 'value' => $vars['entity']->dailymotion, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:pinterest'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:pinterest:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[pinterest]', 'value' => $vars['entity']->pinterest, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
		<p><label><?php echo elgg_echo('adf_platform:settings:contact:tumblr'); ?></label><br />
			<?php echo elgg_echo('adf_platform:settings:netvibes:help'); ?><br />
			<?php echo $url . elgg_view('input/text', array( 'name' => 'params[tumblr]', 'value' => $vars['entity']->tumblr, 'js' => 'style="width:50%;"' )); ?>
		</p><br />
	</div>


	<h3>COULEURS & STYLE</h3>
	<div>
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

		<h4>Dégradé du header et du pied de page</h4>
		<p><label><?php echo elgg_echo('adf_platform:color1:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color1]', 'value' => $vars['entity']->color1 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color4:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color4]', 'value' => $vars['entity']->color4 )); ?>
		</p>

		<h4>Dégradé des widgets et modules des groupes</h4>
		<p><label><?php echo elgg_echo('adf_platform:color2:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color2]', 'value' => $vars['entity']->color2 )); ?>
		</p>
		<p><label><?php echo elgg_echo('adf_platform:color3:color'); ?></label>
			<?php echo elgg_view('input/color', array( 'name' => 'params[color3]', 'value' => $vars['entity']->color3 )); ?>
		</p>

		<h4>Dégradé des boutons (normal puis :hover)</h4>
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

	<br />
	<br />
	
</div>

