<?php
if (isset($vars['class'])) $class = $vars['class'];
if (!$class) $class = "elgg-input-percentage";

if (!array_key_exists('value', $vars) || $vars['value'] == ACCESS_DEFAULT) $vars['value'] = 0;

// Génération du sélecteur
/*
if ((!isset($vars['options'])) || (!is_array($vars['options']))) {
  $vars['options'] = array(0 => "0%", 10 => "10%", 20 => "20%", 30 => "30%", 40 => "40%", 50 => "50%", 60 => "60%", 70 => "70%", 80 => "80%", 90 => "90%", 100 => "100%");
}
*/
$vars['options'] = array();
if (isset($vars['interval'])) $k = $vars['interval']; else $k = 10;
for ($i = 0; $i <= 100; $i = $i + $k) { $vars['options'][$i] = "$i%"; }

if (is_array($vars['options']) && sizeof($vars['options']) > 0) {
  ?>
  <select <?php if (isset($vars['internalid'])) echo "id=\"{$vars['internalid']}\""; ?> name="<?php echo $vars['internalname']; ?>" <?php if (isset($vars['js'])) echo $vars['js']; ?> <?php if ((isset($vars['disabled'])) && ($vars['disabled'])) echo ' disabled="yes" '; ?> class="<?php echo $class; ?>">
  <?php
  foreach($vars['options'] as $key => $option) {
    if ($key != $vars['value']) {
      echo "<option value=\"{$key}\">". htmlentities($option, ENT_QUOTES, 'UTF-8') ."</option>";
    } else {
      echo "<option value=\"{$key}\" selected=\"selected\">". htmlentities($option, ENT_QUOTES, 'UTF-8') ."</option>";
    }
  }
  ?> 
  </select>
  <?php
}		

