<?php

$profiletype = dossierdepreuve_get_user_profile_type($vars['entity']->owner_guid);

if ($profiletype == 'learner') {
	echo elgg_view('dossierdepreuve/owner', array('entity' => $vars['entity']->owner_guid, 'typedossier' => 'b2iadultes'));
} else {
	echo elgg_view('theme_compnum/modules/mylearners_list', array('entity' => $vars['entity']->getOwnerEntity(), 'group_guid' => $vars['entity']->group_guid));
}

