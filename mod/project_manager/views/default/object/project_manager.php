<?php
/**
 * Elgg project_manager browser.
 * project_manager renderer.
 * 
 * @package Elggproject_manager
 * @author Facyla @ ITEMS
 * @copyright ITEMS International 2013
 * @link http://items.fr/
 */

// Access rights and roles
project_manager_gatekeeper();

$project = $vars['entity'];
if (!elgg_instanceof($project, 'object')) {
	register_error(elgg_echo('project_manager:invalidentity'));
	forward();
}

/* Champs d'un projet
title : intitulé
date : date de début
enddate : date de fin
clients : liste des clients
status : état du workflow
project_managertype : état de la project_manager (prospect, fini, etc.)
sector : secteur d'activité du client
clienttype : type de client

Vue propriétaire du projet (owner) et chef de projet(relation project_manager)
Vue membre de base du projet (relation project_member)
Autres : rien
*/

// Generic object data
$project_guid = $project->guid;
$owner = $project->getOwnerEntity();
$container_guid = $project->container_guid;
if ($container_guid > 0) { $container = get_entity($container_guid); }
$tags = $project->tags;
$startyear = $project->startyear;
$clientshort = $project->clientshort;
$title = "";
if (!empty($startyear)) $title .= $startyear . ' - ';
if (!empty($startyear)) $title .= $clientshort . ' - ';
$title .= $project->title;
$description = $project->description;
$friendlytime = elgg_view_friendly_time($project->time_created);
$project_code = $project->project_code;

// Warn if missing project code
if (empty($project_code)) {
	//register_error(elgg_echo('project_manager:error:noproject_code') . " : $title");
	$project_code = elgg_echo('project_manager:empty:project_code');
}

// Prepare dates and period
$date = $project->date;
$enddate = $project->enddate;
$clients = $project->clients;
$clienttype = $project->clienttype;
$budget = $project->budget;
$totaldays = $project->totaldays;
$globalpercentage = $project->globalpercentage;
$status = $project->status;
$projecttype = $project->project_managertype;
$clientcontact = $project->clientcontact;
$projectmanager_guid = $project->projectmanager;
if (!empty($projectmanager_guid)) $projectmanager = get_entity($projectmanager_guid);
else {
	//register_error("Chef de projet non renseigné");
	$projectmanager = $owner;
}
$team = $project->team;
$fullteam = $project->fullteam;
$profiles = $project->profiles;
$otherhuman = $project->otherhuman;
$other = $project->other;
$extranet = $project->extranet;
$ispublic = $project->ispublic;
$sector = $project->sector;
$notes = $project->notes;

// Files pickers arrays
$offer_files = explode(" ", trim( strtr($project->offer_file, ",", " ") ) );
if (is_array($offer_files)) foreach($offer_files as $offer_file) { $offer_file = trim($offer_file); if(!empty($offer_file)) $offers_files[] = get_entity($offer_file); }
$market_files = explode(" ", trim( strtr($project->market_file, ",", " ") ) );
if (is_array($market_files)) foreach($market_files as $market_file) { $market_file = trim($market_file); if(!empty($market_file)) $markets_files[] = get_entity($market_file); }
$finalreport_files = explode(" ", trim( strtr($project->finalreport_file, ",", " ") ) );
if (is_array($finalreport_files)) foreach($finalreport_files as $finalreport_file) { $finalreport_file = trim($finalreport_file); if(!empty($finalreport_file)) $finalreports_files[] = get_entity($finalreport_file); }
// Objects picker array
if(is_array($project->reports_file)) {
	foreach($project->reports_file as $report_file) { $reports_files[] = get_entity($report_file); }
} else { $reports_files[] = get_entity($reports_file); }

if(!empty($enddate) && !empty($date)) {
	$project_period = '<span class="elgg-icon elgg-icon-calendar"></span> du <span class="date">' . elgg_view('output/date', array('value' => $date)) . '</span> au <span class="enddate">' . elgg_view('output/date', array('value' => $enddate)) . '</span>';
} else if(!empty($date)) {
	$project_period = '<span class="elgg-icon elgg-icon-calendar"></span> le <span class="date">' . elgg_view('output/date', array('value' => $date)) . '</span>';
}
if(!empty($status)) $project_period .= ' &nbsp; (<span class="status">' . elgg_view('output/text', array('value' => elgg_echo('project_manager:status:' . $status))) . '</span>)';

$month_table = time_tracker_get_date_table('months');
$edit_links = '';

// Note : un projet terminé ne peut plus être réouvert ni supprimé, sauf par un admin ou un manager
$is_manager = project_manager_manager_gatekeeper(false, true, false);
if ($project->canEdit() || $is_manager) {
	if (!in_array($projecttype, array('closed', 'rejected')) || elgg_is_admin_logged_in() || $is_manager) {
		$edit_links .= '<div class="elgg-menu-entity">';
		$edit_links .= '<span class="elgg-menu-item-edit"><a href="' . elgg_get_site_url() . 'project_manager/edit/' . $project->getGUID() . '">' . elgg_echo('edit') . '</span></a>&nbsp; ';
		$edit_links .= '<span class="elgg-menu-item-delete">' . elgg_view('output/confirmlink',array(
				'href' => elgg_get_site_url() . "action/project_manager/delete?project_manager=" . $project->getGUID(),
				'text' => elgg_echo("delete"), 
				'confirm' => elgg_echo("project_manager:delete:confirm"),
			)) . '</span>';
		$edit_links .= '</div>';
	}
}




// LISTING - Version abrégée pour listing de recherche
if (elgg_get_context() == "search") {

	//if (get_input('search_viewtype') == "gallery") {} else {}
		$icon = '<a href="' . $project->getURL() . '"><img src="' . elgg_get_site_url() . 'mod/project_manager/graphics/mission_64.png" /></a>';
		$icon = '<div class="project_managertype_'.$projecttype.'">' . $icon . '</div>';
		
		$info = '';
		$info .= '<span style="float:right; max-width:60%; padding-top:4px;">';
		$info .= $edit_links;
		$info .= '<div class="clearfloat"></div>';
		$info .= $project_period;
		$info .= '<div class="clearfloat"></div>';
		$info .= '<span>' . elgg_view("output/percentagebar", array("value" => $globalpercentage, 'width' => '220px')) . '</span>';
		$info .= '<span>Temps passé&nbsp;: ' . time_tracker_project_total_time($project->guid) . ' j/h</span>';
		$info .= '</span>';
		
		$info .= '<span class="entity_title"><a href="' . $project->getURL() . '">' . $title . ' (' . $project_code . ')</a></span><br />';
		//$info .= "<p class=\"owner_timestamp\"><a href=\"{elgg_get_site_url()}pg/project_manager/{$owner->username}\">{$owner->name}</a>";
		/*
		$numcomments = $project->countComments();
		if ($numcomments) $info .= ", <a href=\"{$project->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
		*/
		if (elgg_instanceof($container, 'group')) { $info .= "<em>Groupe lié&nbsp;: <a href=\"{$container->getURL()}\">{$container->name}</a></em><br />"; }
		if ($project->canEdit() || $is_manager) {
			$info .= '<a href="' . elgg_get_site_url() . 'project_manager/production/project/' . $project->getGUID() . '">&raquo;&nbsp;' . elgg_echo('project_manager:menu:production') . '</a><br />';
			$info .= '<a href="' . elgg_get_site_url() . 'time_tracker/project/' . $project->guid . '">&raquo;&nbsp;' . elgg_echo('project_manager:menu:project:time_tracker') . '</a>';
		}
		echo elgg_view_image_block($icon, $info);

// Version complète
} else {
	?>
	<div class="contentWrapper project_manager project_managertype_<?php echo $projecttype; ?>" style="padding-left:12px;">
		
		<?php echo $edit_links . elgg_view_title($project->title); ?>
		
		<?php echo elgg_view('output/tags',array('value' => $tags)); ?>
		
		<!-- PROJECT SIDEBOX INFORMATION //-->
		<div class="infobox_encart" style="width:300px; float:right; margin:0 0 6px 12px; padding:6px; border:1px solid black; background-color:#EEFFEE;">
			
			<div>
				<h3><?php echo elgg_echo('project_manager:maininfo'); ?></h3>
				<?php
				echo '<p><strong>' . elgg_view('output/text', array('value' => elgg_echo('project_manager:project_managertype:' . $projecttype))) . '</strong><br />' . $project_period . '</p>';
				echo '<p><strong>' . elgg_echo('project_manager:project_code') . ' :</strong> ' . elgg_view('output/text', array('value' => $project_code)) . '</p>';
				echo '<p><strong>' . elgg_echo('project_manager:budget') . ' :</strong> ' . elgg_view('output/text', array('value' => $budget)) . ' € HT</p>';
				echo parse_urls(elgg_view('output/longtext', array('value' => $notes)));
				echo '<strong>' . elgg_echo('project_manager:globalpercentage') . '</strong>';
				echo '<span>' . elgg_view("output/percentagebar", array("value" => $globalpercentage)) . '</span>';
				echo parse_urls(elgg_view('output/longtext', array('value' => $description)));
				?>
				<div class="clearfloat"></div>
			</div>
			
			<div>
				<h3><?php echo elgg_echo('project_manager:client'); ?></h3>
				<?php
				//echo '<p><strong>' . elgg_echo('project_manager:clients') . '&nbsp;: ' . elgg_view('output/tags', array('value' => $clients)) . '</strong></p>';
				echo elgg_view('output/tags', array('value' => $clients)) . '<br />';
				if(!empty($clientcontact)) echo '<strong>' . elgg_echo('project_manager:clientcontacts') . '&nbsp;:</strong> ' . parse_urls($clientcontact);
				?>
				<div class="clearfloat"></div>
			</div>
			
		</div>
		
		
		<!-- PROJECT MAIN CONTENT //-->
		<div class="project_manager_maincontent">
			<br />
			<div>
				<h3><?php echo elgg_echo('project_manager:people'); ?></h3>
				<p><?php echo elgg_echo('project_manager:people:details'); ?></p>
				<?php
				echo '<strong>' . elgg_echo('project_manager:owner') . '&nbsp;: </strong> ' . elgg_view('output/members_list', array('value' => $owner->guid));
				echo '<strong>' . elgg_echo('project_manager:projectmanager') . '&nbsp;: </strong> ' . elgg_view('output/members_list', array('value' => $projectmanager->guid));
				echo '<strong>' . elgg_echo('project_manager:team') . '&nbsp;: </strong> ' . elgg_view('output/members_list', array('value' => $team));
				echo '<strong>' . elgg_echo('project_manager:fullteam') . '&nbsp;: </strong> ' . elgg_view('output/members_list', array('value' => $fullteam));
				// Infos financières : affiché ssi owner, ou chef de projet, ou manager
					if (project_manager_projectdata_gatekeeper($project, elgg_get_logged_in_user_guid())) {
					echo '<strong>' . elgg_echo('project_manager:profiles') . '&nbsp;: </strong><br />';
					$profiles = str_replace("\r", '\n', $profiles);
					$profiles = str_replace('\n\n', '\n', $profiles);
					$profiles = explode('\n', $profiles);
					foreach ($profiles as $profile) {
						$profile = trim($profile);
						if (empty($profile)) continue;
						$profile = explode(':', $profile);
						echo trim($profile[0]) . '&nbsp;: ' . trim($profile[1]) . '&nbsp;€ HT / jour, ' . trim($profile[2]) . ' jours<br />';
					}
					echo '<br />';
					echo '<strong>' . elgg_echo('project_manager:production:otherhuman') . '&nbsp;: </strong> ' . $otherhuman . '<br /><br />';
					echo '<strong>' . elgg_echo('project_manager:production:other') . '&nbsp;: </strong> ' . $other . '<br /><br />';
				}
				echo '<strong>' . elgg_echo('project_manager:extranet') . '&nbsp;: </strong> ' . elgg_view('output/members_list', array('value' => $extranet));
				?>
			</div>
			<br />
			<br />
			
			<?php
			// Infos temps et production : affiché ssi owner, ou chef de projet, ou manager
			if (project_manager_projectdata_gatekeeper($project, elgg_get_logged_in_user_guid())) {
				$p_url = elgg_get_site_url() . 'project_manager/production/project/';
				$edit_url = elgg_get_site_url() . 'project_manager/edit/';
				?>
				<div>
					<h3><?php echo elgg_echo('project_manager:menu:group:production'); ?></h3>
					<p><strong><a class="elgg-button elgg-button-action" href="<?php echo elgg_get_site_url() . 'project_manager/production/project/' . $project->guid; ?>">&rarr;&nbsp;<?php echo elgg_echo('project_manager:menu:project:production:edit'); ?></a></strong></p>
					<br />
					<h3><?php echo elgg_echo('time_tracker:group'); ?></h3>
					<p><strong><a class="elgg-button elgg-button-action" href="<?php echo elgg_get_site_url() . 'time_tracker'; ?>">&rarr;&nbsp;<?php echo elgg_echo('project_manager:menu:project:time_tracker:edit'); ?></a></strong></p>
					<?php echo time_tracker_project_times($project->guid); ?>
					<p><strong><a href="<?php echo elgg_get_site_url() . 'time_tracker/project/' . $project->guid; ?>">&rarr;&nbsp;<?php echo elgg_echo('project_manager:menu:project:time_tracker'); ?></a></strong></p>
				</div>
				<br />
				<br />
				<?php
			}
			?>
			
			
			<div>
				<h3><?php echo elgg_echo('tasks:project_tasks'); ?></h3>
				<p><?php echo elgg_echo('tasks:project_tasks:details'); ?></p>
				<?php
				if ($container instanceof ElggGroup) {
					$options = array(
							'type' => 'object', 'subtype' => 'task_top', 'container_guid' => $container_guid,
							'limit' => false, 'full_view' => false, 'pagination' => true,
						);
					$phases = elgg_get_entities($options);
					foreach($phases as $phase) {
						echo elgg_view_entity($phase);
					}
					echo '<a target="_new" href="' . elgg_get_site_url() . 'tasks/add/' . $container_guid . '">&raquo;&nbsp;Ajouter une autre phase</a>';
				}
				
				
				/* Ici on n'affiche que les liens vers les docs (on ne stocke que leur GUID), sauf les fichiers, téléchargeables en direct */
				/*
				echo '<br /><strong>' . elgg_echo('project_manager:file:reports') . ' :</strong> ';
				if(count($reports_files)>0) {
					foreach($reports_files as $report_file) {
						if($report_file instanceof ElggFile)	echo '<span class="offer_file"><a href="' . elgg_get_site_url() . 'action/file/download?file_guid=' . $report_file->guid . '" title="Télécharger le document">' . $report_file->title . '</a></span> &nbsp; ';
						else if($report_file instanceof ElggObject) echo '<span class="report_file"><a href="' . $report_file->getURL() . '">' . $report_file->title . '</a></span> &nbsp; ';
					}
					echo '<br />';
				}
				*/
				?>
				
			</div>
			
		</div>
		<div class="clearfloat"></div>
		
		<?php echo elgg_view_comments($project); ?>
		
	</div>
	<?php
	
}

