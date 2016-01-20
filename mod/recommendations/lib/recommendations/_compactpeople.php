<?php
/**
* people_from_the_neighborhood
*
* @author emdagon
* @link http://community.elgg.org/pg/profile/emdagon
* @copyright (c) Condiminds 2011
* @link http://www.condiminds.com/
* @license GNU General Public License (GPL) version 2
*/

$people = $vars['people'];

if (is_array($people) && sizeof($people) > 0) {
  
	foreach ($people as $person) {
		$info = '<span style="font-size:11px;"><b><a href="' . $person['entity']->getUrl() . '">' . $person['entity']->name . '</a></b><br />';
      
      // Compteurs
      $mutuals = count($person['mutuals']);
      $shared_groups = count($person['groups']);
      
      // Début bloc pliable (le pourquoi? des suggestions)
      $info .= '<a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#pftn_suggestion'.$person['entity']->guid.'\').toggle();">'.sprintf(elgg_echo('pftn:suggestion:togglelink'), $mutuals, $shared_groups).'</a></small><span id="pftn_suggestion'.$person['entity']->guid.'" style="display: none; font-size:11px;">';
        
        // Contacts communs
        if ($mutuals == 1) {
          $friend = $person['mutuals'][0];
          $info .= '<p>' . sprintf(elgg_echo('pftn:is:friend:of'), '<a href="' . $friend->getURL() . '">' . $friend->name . '</a>') . '</p>';
        } else if ($mutuals > 1) {
          $friends = array();
          foreach ($person['mutuals'] as $friend){
            $friends[] = '<a href="' . $friend->getURL() . '">' . $friend->name . '</a>';
          }
          $info .= '<p>' . sprintf(elgg_echo('pftn:mutual:friends'), $mutuals, implode(', ', $friends)) . '</p>';
        }

        // Groupes communs
        if ($shared_groups == 1) {
          $group = $person['groups'][0];
          $info .= '<p>' . sprintf(elgg_echo('pftn:is:member:of'), '<a href="' . $group->getURL() . '">' . $group->name . '</a>') . '</p>';
        } else if ($shared_groups > 1) {
          $groups = array();
          foreach ($person['groups'] as $group){
            $groups[] = '<a href="' . $group->getURL() . '">' . $group->name . '</a>';
          }
          $info .= '<p>' . sprintf(elgg_echo('pftn:shared:groups'), $shared_groups, implode(', ', $groups)) . '</p>';
        }
        
      // Fin bloc pliable
      $info .= '</span>';
    // Fin bloc d'info
    $info .= '</span>';
		
/* Facyla : Elgg >= 1.7
		echo elgg_view('entities/entity_listing', array(
			'icon' => elgg_view('profile/icon', array('entity' => $person['entity'])),
			'info' => $info
		));
*/
    
    //echo elgg_view_listing(elgg_view('profile/icon', array('entity' => $person['entity'], 'size' => 'tiny')), $info);
    echo '<div class="recentMember" style="margin-bottom:5px;"><img src="'.get_entity_icon_url($person['entity'],'tiny').'" style="float:left; margin:1px 1px 1px 5px; padding:1px;" />' . $info . '</div><div class="clearfloat"></div>';
    
	}
	
} else {
	echo elgg_echo('pftn:people:not:found');
}
