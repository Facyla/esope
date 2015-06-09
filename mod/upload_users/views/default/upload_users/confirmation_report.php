<?php
/**
 * Upload users creation report view. Prints a nice table of all the created users.
 *
 * @package upload_users
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jaakko Naakka / Mediamaisteri Group
 * @copyright Mediamaisteri Group 2009
 * @link http://www.mediamaisteri.com/
 */
$headers = $vars['headers'];
$report = $vars['report'];

if (elgg_is_active_plugin('profile_manager')) {
	$options = array(
		'type' => 'object',
		'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
		'limit' => 0,
		'count' => false
	);

	$custom_fields = elgg_get_entities($options);

	if ($custom_fields) {
		$mapping_options = array(
			'custom' => elgg_echo('upload_users:mapping:custom')
		);
		foreach ($custom_fields as $field) {
			$option = $field->getTitle();
			if ($category_guid = $field->category_guid) {
				$category = get_entity($category_guid);
				$option = "$option ({$category->getTitle()})";
			}
			$mapping_options[$field->metadata_name] = $option;
		}
	}
}

if (elgg_is_active_plugin('roles')) {
	$roles = roles_get_all_selectable_roles();
	if ($roles) {
		$role_options = array();
		foreach ($roles as $role) {
			$role_options["$role->name"] = elgg_echo($role->title);
		}
	}
}
?>


<div class="upload_users_container">
	<ul>
		<li><?php echo elgg_echo('upload_users:number_of_accounts'); ?>: <?php echo count($report); ?></li>
		<li><?php echo elgg_echo('upload_users:number_of_errors'); ?>: <?php echo $vars['num_of_failed']; ?></li>
	</ul>
</div>

<input type="hidden" id="num_of_users" name="num_of_users" value="<?php echo count($report) - $vars['num_of_failed']; ?>">
<input type="hidden" name="confirm" id="confirm" value="1">
<input type="hidden" name="notification" id="notificaiton" value="<?php echo $vars['notification']; ?>">
<input type="hidden" name="encoding" id="encoding" value="<?php echo $vars['encoding']; ?>">
<input type="hidden" name="delimiter" id="delimiter" value="<?php echo $vars['delimiter']; ?>">

<div class="creation_report_wrapper">
	<table id="creation_report">
		<thead>
			<?php
			if (is_array($role_options)) {
				echo '<td>';
				echo elgg_echo('role');
				echo elgg_view('input/hidden', array(
					'name' => 'header[user_upload_role][mapping]',
					'value' => 'role'
				));
				echo '</td>';
			}
			/// Print the headers
			foreach ($headers as $header) {
				echo '<td>';
				if ($header == 'status') {
					echo elgg_view('input/hidden', array(
					'name' => 'header[status][mapping]',
					'value' => 'status'
					));
					continue;
				}
				if (is_array($mapping_options)) {
					if (array_key_exists($header, $mapping_options)) {
						$mapping_value = $header;
						$custom_input_class = 'hidden';
					} else {
						$mapping_value = null;
						$custom_input_class = '';
					}
					echo elgg_view('input/dropdown', array(
						'name' => "header[$header][mapping]",
						'options_values' => $mapping_options,
						'value' => $mapping_value
					));

					echo elgg_view('input/text', array(
						'name' => "header[$header][custom]",
						'value' => $header,
						'class' => $custom_input_class
					));
				} else {
					echo elgg_view('input/hidden', array(
						'name' => "header[$header][mapping]",
						'value' => "custom"
					));

					echo elgg_view('input/text', array(
						'name' => "header[$header][custom]",
						'value' => $header
					));
				}
				echo '</td>';
			}
			?>
		</thead>

		<?php
/// Print the data
		for ($i = 0; $i < count($report); $i++) {
			echo "<tr>";
			if (is_array($role_options)) {
				echo '<td>';
				echo elgg_view('input/dropdown', array(
					'name' => 'user_upload_role[]',
					'value' => DEFAULT_ROLE,
					'options_values' => $role_options
				));
				echo '</td>';
			}

			foreach ($headers as $header) {
				echo '<td>';
				if ($report[$i]['create_user']) {
					if ($header !== 'status') {
						echo elgg_view('input/text', array(
							'name' => "{$header}[]",
							'value' => $report[$i][$header]
						));
					} else {
						echo $report[$i][$header];
					}
				}
				echo '</td>';
			}
			echo "</tr>";
		}
		?>
	</table>
</div>
<?php echo elgg_view('input/securitytoken') ?>
<?php echo elgg_view('input/submit', array('value' => elgg_echo('upload_users:create_users'))); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('select[name^=header]').change(function() {
			if ($(this).val() == 'custom') {
				$(this).next('input').show();
			} else {
				$(this).next('input').hide();
			}
		});
	})
</script>