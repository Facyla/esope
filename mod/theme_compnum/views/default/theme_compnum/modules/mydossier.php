<?php
$user = $vars['entity'];

echo '<h3>Mon dossiers de preuve</h3>';

echo elgg_view('dossierdepreuve/owner', array('entity' => $user, 'typedossier' => 'b2iadultes'));

echo '<a href="' . $vars['url'] . 'blog/owner/' . $user->username . '">Mes articles</a><br /><br />';
echo '<a href="' . $vars['url'] . 'file/owner/' . $user->username . '">Mes images et fichiers</a><br /><br />';

// @TODO : à activer seulement quand on a plusieurs types de dossiers (Pass'Num, etc.)
//echo '<hr /><a href="' . $url . 'dossierdepreuve/owner/' . $user->username . '">Mes dossiers</a><br />';
//echo '<hr /><a href="' . $url . 'dossierdepreuve/all">Tous les dossiers</a><br />';

// @TODO Dossiers de preuve du groupe



