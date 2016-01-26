<?php
/** Simple project_manager search */
global $CONFIG;
$search = (isset($vars['search'])) ? $vars['search'] : "Rechercher un projet";
?>
<br />
<div class="sidebarBox">
  <form id="memberssearchform" action="<?php echo $CONFIG->url; ?>project_manager/references" method="get">
    <label for="project_manager-search">Chercher un projet</label>
    <input type="text" id="project_manager-search" name="search" onclick="if (this.value=='Rechercher un projet') { this.value='' }" class="search_input" value="<?php echo $search; ?>" />
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('Chercher un projet'))); ?>
  </form>
</div>
