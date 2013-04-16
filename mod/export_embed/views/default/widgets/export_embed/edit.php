<?php
// Full url
$widget_url = elgg_view('input/text',  array('name' => 'params[url]', 'value' => $vars['entity']->url));

// Or finer config
$site_url = elgg_view('input/text',  array('name' => 'params[site_url]', 'value' => $vars['entity']->site_url));
$widget_type = elgg_view('input/dropdown',  array('name' => 'params[widget_type]', 'value' => $vars['entity']->widget_type, 'option_values' => array('site_activity' => 'Activité du site', 'groups_list' => 'Liste des groupes publics', 'group_activity' => "activité d'un groupe", 'agenda' => 'Agenda', )));
// @TODO : ajouter le choix du groupe ?
?>
<div>
  Pour afficher des informations de ce site sur un aurte site, veuillez utiliser les adresses suivantes :
  <ul>
    <li><strong><?php echo $CONFIG->url; ?>embed/?embed=site_activity</strong> pour l'activité générale du site</li>
    <li><strong><?php echo $CONFIG->url; ?>embed/?embed=groups_list</strong> pour la liste des groupes</li>
    <li><strong><?php echo $CONFIG->url; ?>embed/?embed=agenda</strong> pour l'agenda</li>
    <li><strong><?php echo $CONFIG->url; ?>embed/?embed=group_activity&guid=XXXXX</strong> pour l'activité d'un groupe en particulier. Attention : remplacer XXXXX par le numéro du groupe à afficher, que vous trouverez dans l'adresse de la page d'accueil du groupe : <em>groups/profile/<strong>XXXXX</strong>/nom-du-groupe</em></li>
  </ul>
  <br />
  <br />
  Pour utiliser ce widget, vous devez coller ci-dessous l'adresse d'un widget exportable depuis un autre site. Celle-ci ressemble à <em><?php echo $CONFIG->url; ?>embed/?embed=</em><strong>group_activity</strong><span style="color:blue">&guid=112</span> où :
  <ul>
    <li><em><?php echo $CONFIG->url; ?>embed/?embed=</em> est l'adresse du site depuis lequel vous voulez récupérer des informations</li>
    <li><strong>group_activity</strong> permet de choisir le type d'informations à récupérer ; au choix : site_activity, groups_list, agenda, et group_activity (+ paramètres)</li>
    <li><span style="color:blue">&guid=112</span> permet de configurer certains widgets (group_activity)</li>
  </ul>
  <br />
  <label>Adresse du widget 
  <?php echo $widget_url; ?>
  </label>
</div>
