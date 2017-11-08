<?php
/**
 * Elgg file browser uploader
 * 
 * @package ElggFile
 */

// Adds prevent_notification form field
// Add tags and category support
// Note: synced with file_tools release 2.0

$page_owner = elgg_get_page_owner_entity();
$container_guid = $page_owner->getGUID();
$site_url = elgg_get_site_url();

if (elgg_instanceof($page_owner, "group", null, "ElggGroup")) {
	$return_url = $site_url . "file/group/" . $page_owner->getGUID() . "/all";
} else {
	$return_url = $site_url . "file/owner/" . $page_owner->username;
}

// load JS
elgg_load_js("jquery.uploadify");
elgg_load_css("jquery.uploadify");
?>
<script type="text/javascript">
	var file_tools_uploadify_return_url = "<?php echo $return_url; ?>";
</script>

<fieldset>
	<div>
		<label><?php echo elgg_echo("file:file"); ?></label>
						
		<div id="uploadify-queue-wrapper" class="mbm">
			<span><?php echo elgg_echo("file_tools:upload:form:info"); ?></span>
		</div>
		
		<div>
			<?php 
				echo elgg_view("input/file", array("id" => "uploadify-button-wrapper", "name" => "upload"));
				echo elgg_view("input/button", array("value" => elgg_echo('file_tools:forms:empty_queue'), "class" => "elgg-button-action hidden", "id" => "file-tools-uploadify-cancel")); 
			?>
		</div>
	</div>
	
	<div>
		<label><?php echo elgg_echo('tags'); ?></label>
		<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => ' ')); ?>
	</div>
	
	<?php if(file_tools_use_folder_structure()){ ?>
	<div>
		<label><?php echo elgg_echo("file_tools:forms:edit:parent"); ?><br />
		<?php
			echo elgg_view("input/folder_select", array("name" => "folder_guid", "value" => get_input('parent_guid'), "id" => "file_tools_file_parent_guid"));
		?>
		</label>
	</div>
	<?php }

	// Add categories support
	$categories = elgg_view('input/categories', $vars);
	if ($categories) {
		echo $categories;
	}
	?>
	
	<div>
		<label>
			<?php echo elgg_echo('access'); ?><br />
			<?php echo elgg_view('input/access', array('name' => 'access_id', 'id' => 'file_tools_file_access_id')); ?>
		</label>
	</div>
	
	<?php
	// Prevent multiple notifications => setting pre-set to no
	echo elgg_view('prevent_notifications/prevent_form_extend', array('value' => 'no'));
	?>
	
	<div class="elgg-foot">
		<?php 
			echo elgg_view('input/securitytoken');
			echo elgg_view("input/hidden", array("name" => "container_guid", "value" => $container_guid));
			echo elgg_view("input/hidden", array("name" => "PHPSESSID", "value" => session_id()));
							
			echo elgg_view("input/submit", array("value" => elgg_echo("save")));
		?>
	</div>
</fieldset>
