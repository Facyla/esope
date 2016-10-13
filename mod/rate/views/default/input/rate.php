<?php
/**
 *	5 STAR AJAX RATE PLUGIN
 *	@package rate
 *	@author Team Webgalli
 *	@license GNU General Public License (GPL) version 2
 *	@link http://www.webgalli.com/
 *	@Adapted from the rate plugin for Elgg 1.7 
 *	 from Miguel Montes http://community.elgg.org/profile/mmontesp
 *	 http://community.elgg.org/pg/plugins/mmontesp/read/384429/rate-plugin 
 **/
 
	$class = $vars['class'];
	if (!$class) {
		$class = "input-radio";
	}	
    foreach($vars['options'] as $label => $option) {
        if ($option != $vars['value']) {
            $selected = "";
        } else {
            $selected = "checked = \"checked\"";
        }
        $labelint = (int) $label;
        if ("{$label}" == "{$labelint}") {
        	$label = $option;
        }
        
        if ($vars['disabled']) {
			$disabled = ' disabled="yes" '; 
		}	
        echo "<div class='float mrm'><input type=\"radio\" $disabled {$vars['js']} name=\"{$vars['name']}\" value=\"".htmlentities($option, null, 'UTF-8')."\" {$selected} class=\"$class\" />{$label}</div>";
    }
	echo "<div class='clearfloat'></div>";
?> 