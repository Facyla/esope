<?php
/**
 * Iris v2 layout for groups, members and content search
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['content'] Content HTML for the main column
 * @uses $vars['sidebar'] Optional content that is added to the sidebar
 * @uses $vars['nav']     Optional override of the page nav (default: breadcrumbs)
 * @uses $vars['header']  Optional override for the header
 * @uses $vars['footer']  Optional footer
 * @uses $vars['class']   Additional class to apply to layout
 */

$class = 'elgg-layout elgg-layout-one-sidebar clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// ESOPE : Add context class, for page differenciation
global $CONFIG;
if ($CONFIG->context) foreach ($CONFIG->context as $context) {
	$class .= ' elgg-context-' . $context;
}

// navigation defaults to breadcrumbs
$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));

$q = elgg_extract('q', $vars, '');

// Change layout for groups - but only show if group can be seen
$owner = elgg_get_page_owner_entity();
if (elgg_instanceof($owner, 'group') && has_access_to_entity($owner)) {
	$topmenu = elgg_view('group/topmenu', array('entity' => $owner));
}
?>

<?php
// Inria : show nav and topmenu together here, and not above
if ($topmenu) {
	echo $nav . '<br >';
	echo $topmenu;
}

/* Notes structure : 1 seul form contenant header + nav, et les résultats dans un autre bloc - car recherche séparée des filtres
 * ou alors synchronise le champ avec le "vrai" formulaire
*/

?>

<div class="iris-search">
	
	<div class="iris-search-header">
		<div class="iris-search-image"><i class="fa fa-search"></i></div>
		<div class="iris-search-quickform">
			<h2>Recherche</h2>
			<?php if (!empty($q)) { echo 'Résultats pour "' . $q . '"'; } ?>
			<?php
			//echo elgg_view_form('search', $vars);
			?>
		</div>
		<div class="iris-search-menu">
			<?php
			if (elgg_in_context('groups')) {
				echo '<a href="' . elgg_get_site_url() . 'groups" class="elgg-state-selected">Groupes</a>';
			} else {
				echo '<a href="' . elgg_get_site_url() . 'groups" class="">Groupes</a>';
			}
			if (elgg_in_context('members')) {
				echo '<a href="' . elgg_get_site_url() . 'members" class="elgg-state-selected">Membres</a>';
			} else {
				echo '<a href="' . elgg_get_site_url() . 'groups" class="">Groupes</a>';
			}
			if (elgg_in_context('objects')) {
				echo '<a href="' . elgg_get_site_url() . 'search" class="elgg-state-selected">Publications</a>';
			} else {
				echo '<a href="' . elgg_get_site_url() . 'groups" class="">Groupes</a>';
			}
			?>
		</div>
	</div>
	
	<div class="<?php echo $class; ?>">
		<div class="menu-sidebar-toggle"><i class="fa fa-th-large"></i> <?php echo elgg_echo('esope:menu:sidebar'); ?></div>
		<div class="elgg-sidebar iris-search-sidebar">
			<h2 class="hidden"><?php echo elgg_echo('accessibility:sidebar:title'); ?></h2>
			<?php
				echo $vars['sidebar'];
			?>
		</div>

		<div class="elgg-main elgg-body">
			<?php
				if (!$topmenu) { echo $nav; }
			
				echo elgg_view('page/layouts/elements/header', $vars);
			
				// @todo deprecated so remove in Elgg 2.0
				if (isset($vars['area1'])) {
					echo $vars['area1'];
				}
				if (isset($vars['content'])) {
					echo $vars['content'];
				}
				echo elgg_view('page/layouts/elements/footer', $vars);
			?>
		</div>
	</div>
	
</div>

