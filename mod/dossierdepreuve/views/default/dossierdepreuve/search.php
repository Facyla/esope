<?php
/** Simple dossierdepreuve search */
global $CONFIG;
$search = (!empty($vars['search'])) ? $vars['search'] : "Nom ou mot du dossier";
?>
<br />
<div class="sidebarBox">
  <form id="memberssearchform" action="<?php echo $CONFIG->url; ?>search" method="get">
    <label for="dossierdepreuve-search">Chercher un dossier</label>
    <input type="text" id="dossierdepreuve-search" name="q" onclick="if (this.value=='Nom ou mot du dossier') { this.value='' }" class="search_input" value="<?php echo $search; ?>" />
    <input type="hidden" name="entity_subtype" value="dossierdepreuve" />
    <input type="hidden" name="entity_type" value="object" />
    <input type="hidden" name="search_type" value="entities" />
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('Chercher un dossier'), 'js' => 'style="margin-top:3px;"')); ?>
  </form>
</div>
