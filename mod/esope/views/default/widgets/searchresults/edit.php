<?php 

$widget = $vars["entity"];

$count = sanitise_int($widget->content_count, false);
if(empty($count)){
	$count = 5;
}

$content_type = $widget->content_type;

$content_options_values = array();
if(elgg_is_active_plugin("blog")){
	$content_options_values["blog"] = elgg_echo("item:object:blog");
}
if(elgg_is_active_plugin("file")){
	$content_options_values["file"] = elgg_echo("item:object:file");
}
if(elgg_is_active_plugin("pages")){
	$content_options_values["page"] = elgg_echo("item:object:page");
}

$tags = $widget->tags;
$tags_option = $widget->tags_option;

if(empty($tags_option)){
	$tags_option = "and";
}

$yesno_options = array(
	"yes" => elgg_echo("option:yes"),
	"no" => elgg_echo("option:no")
);

$tags_options_values = array(
	"and" => elgg_echo("esope:widgets:searchresults:tags_option:and"),
	"or" => elgg_echo("esope:widgets:searchresults:tags_option:or")
);

$display_option_options_values = array(
	"normal" => elgg_echo("esope:widgets:searchresults:display_option:normal"),
	"simple" => elgg_echo("esope:widgets:searchresults:display_option:simple"),
	"slim" => elgg_echo("esope:widgets:searchresults:display_option:slim")
);

if(elgg_view_exists("input/user_autocomplete")){
	echo "<div>". elgg_echo("esope:widgets:searchresults:owner_guids") . "</div>";
	
	echo elgg_view("input/user_autocomplete", array("name" => "owner_guids", "value" => string_to_tag_array($widget->owner_guids), "include_self" => true));		
	echo elgg_view("input/hidden", array("name" => "params[owner_guids]", "value" => $widget->owner_guids));
} else {
	if($user = elgg_get_logged_in_user_entity()){
		$options_values = array(
						"" => elgg_echo("all"),
						$user->getGUID() => $user->name
					);
		if($friends = $user->getFriends(array('limit' => 0))){
			foreach($friends as $friend){
				$options_values[$friend->guid] = $friend->name;
			}
		}
		
		if($owner_guid = $widget->owner_guids){
			if(!array_key_exists($owner_guid, $options_values)){
				if($configured_user = get_user($owner_guid)){
					$options_values[$owner_guid] = $configured_user->name; 
				}
			}
		}
		
		natcasesort($options_values);
		
		echo "<div>";
		echo elgg_echo("esope:widgets:searchresults:owner_guids") . "<br />";
		echo elgg_view("input/select", array("name" => "params[owner_guids]", "options_values" => $options_values, "value" => $widget->owner_guids));
		echo "</div>";
	}
}

if($widget->context == "groups"){
	echo "<div>";
	echo elgg_echo("esope:widgets:searchresults:group_only") . "<br />";
	echo elgg_view("input/select", array("name" => "params[group_only]", "options_values" => array("yes" => elgg_echo("option:yes"), "no" => elgg_echo("option:no")), "value" => $widget->group_only));
	echo "</div>";
}

?>

<p>
	<label><?php echo elgg_echo("widget:numbertodisplay"); ?> 
	<?php echo elgg_view("input/text", array("name" => "params[content_count]", "value" => $count, "size" => "4", "maxlength" => "4"));?></label>
</p>

<p>
	<label><?php echo elgg_echo("esope:widgets:searchresults:entities"); ?> 
	<?php echo elgg_view("input/select", array("name" => "params[content_type]", "options_values" => $content_options_values, "value" => $content_type)); ?></label>
</p>

<p>
	<label><?php echo elgg_echo("esope:widgets:searchresults:tags"); ?> 
	<?php echo elgg_view("input/text", array("name" => "params[tags]", "value" => $tags)); ?></label>
</p>

<p>
	<label><?php echo elgg_echo("esope:widgets:searchresults:tags_option"); ?> 
	<?php echo elgg_view("input/select", array("name" => "params[tags_option]", "options_values" => $tags_options_values, "value" => $tags_option)); ?></label>
</p>

<?php if (elgg_view_exists("input/user_autocomplete")) { ?>
	<script type="text/javascript">
		$("#widgetform<?php echo $widget->getGUID(); ?>").submit(function(){
			var newVal = "";
			$(this).find("input[name='owner_guids[]']").each(function(index, elem){
				newVal += $(elem).val() + ",";
			});
			newVal = newVal.substr(0, (newVal.length - 1));
			$(this).find("input[name='params[owner_guids]']").val(newVal);
		});
	</script>
<?php } ?>

<p>
	<label><?php echo elgg_echo("esope:widgets:searchresults:display_option"); ?> 
	<?php echo elgg_view("input/select", array("name" => "params[display_option]", "options_values" => $display_option_options_values, "value" => $widget->display_option)); ?></label>
</p>

<p>
	<label><?php echo elgg_echo("esope:widgets:searchresults:highlight_first"); ?> 
	<?php echo elgg_view("input/text", array("name" => "params[highlight_first]", "value" => $widget->highlight_first)); ?>
</label>
</p>


