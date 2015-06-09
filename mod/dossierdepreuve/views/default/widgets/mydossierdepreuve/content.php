<?php

//$profiletype = dossierdepreuve_get_user_profile_type($vars['entity']->owner_guid);

echo elgg_view('dossierdepreuve/owner', array('entity' => $vars['entity']->owner_guid, 'typedossier' => 'b2iadultes'));

