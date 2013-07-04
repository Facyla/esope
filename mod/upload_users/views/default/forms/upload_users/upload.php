<?php

/**
 * Upload users upload form view.
 *
 * @package upload_users
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jaakko Naakka / Mediamaisteri Group
 * @copyright Mediamaisteri Group 2009
 * @link http://www.mediamaisteri.com/
 */
?>
<?php echo elgg_echo('upload_users:upload_help'); ?>
<p class="code">
	username; password; email; name; location; interests<br>
	test_user; t3st; test@test.com; Test User; Helsinki; Elgg, php, jquery Web 2.0<br>
	user_test; testing; testing@test.com; User for Testing; London; Moodle, e-learning, photography<br>
</p>

<?php

/// Diaplay the file selction
echo '<h4>' . elgg_echo('upload_users:choose_file') . '</h4>';
echo elgg_view('input/file', array('name' => 'csvfile'));
echo '<br />';

/// Display encoding pull down
$options = array('UTF8', 'ISO-8859-1');
echo '<h4>' . elgg_echo('upload_users:encoding') . '</h4>';
echo elgg_view('input/dropdown', array('options' => $options, 'name' => 'encoding'));
echo '<br />';

/// Display delimiter pull down
$options = array(',', ';', ':', '|');
echo '<h4>' . elgg_echo('upload_users:delimiter') . '</h4>';
echo elgg_view('input/dropdown', array('options' => $options, 'name' => 'delimiter'));
echo '<br />';

/// Display send emails pull down
$options = array('1' => elgg_echo('upload_users:yes'), '0' => elgg_echo('upload_users:no'));
echo '<h4>' . elgg_echo('upload_users:send_email') . '</h4>';
echo elgg_view('input/dropdown', array('options_values' => $options, 'name' => 'notification'));
echo '<br />';

/// Display submit button
echo elgg_view('input/submit', array('value' => elgg_echo('next')));
