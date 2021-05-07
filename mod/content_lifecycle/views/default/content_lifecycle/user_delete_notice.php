<?php
$user = elgg_extract('user', $vars);
$content = '';

// Informations générales
$content .= '<h3>Options de transfert</h3>';
$content .= '<p>' . "Entité à supprimer : " . '<a href="' . $user->getURL() . '">' . $user->name . '</a></p>';
$content .= '<p><em>Sont considérées comme données personnelles : les attributs, métadonnées, ACL, paramètres et relations du compte.</em></p>';
$content .= '<p><em>Sont considérées comme données non-personnelles : les groupes et les contenus. Les contenus publiés hors des groupes peuvent poser question (par ex. le Fil, discussions globales, et autres publications globales).</em></p>';

echo $content;

