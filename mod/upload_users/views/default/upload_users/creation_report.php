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
?>
<div class="upload_users_container">
	<ul>
		<li><?php echo elgg_echo('upload_users:number_of_accounts'); ?>: <?php echo count($report); ?></li>
		<li><?php echo elgg_echo('upload_users:number_of_errors'); ?>: <?php echo $vars['num_of_failed']; ?></li>
	</ul>
</div>

<?php
if ($report) {
	?>
	<div class="creation_report_wrapper">
		<table id="creation_report">
			<thead>
	<?php
/// Print the headers
	foreach ($headers as $header) {
		echo '<td>' . $header . '</td>';
	}
	?>

			</thead>

				<?php
/// Print the data
				foreach ($report as $row) {
					echo '<tr>';
					foreach ($headers as $header) {
						echo '<td>' . $row[$header] . '</td>';
					}
					echo '</tr>';
				}
				?>

		</table>
	</div>
			<?php
		} else { /// ENDIF $report
			echo elgg_echo('upload_users:no_created_users');
		}
		?>


