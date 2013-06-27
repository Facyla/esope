<?php
$user = $vars['entity'];

echo '<h3>Dossiers de preuve du groupe</h3>';

/*
echo '<a href="' . $vars['url'] . 'blog/owner/' . $user->username . '">Mes articles de blog</a><br /><br />';
echo '<a href="' . $vars['url'] . 'file/owner/' . $user->username . '">Mes images et fichiers</a><br /><br />';
*/
echo elgg_view('dossierdepreuve/owner', array('entity' => $user, 'typedossier' => 'b2iadultes'));
// @TODO : à activer seulement quand on a plusieurs types de dossiers (Pass'Num, etc.)
//echo '<hr /><a href="' . $url . 'dossierdepreuve/owner/' . $user->username . '">Mes dossiers</a><br />';
//echo '<hr /><a href="' . $url . 'dossierdepreuve/all">Tous les dossiers</a><br />';

// @TODO Dossiers de preuve du groupe



