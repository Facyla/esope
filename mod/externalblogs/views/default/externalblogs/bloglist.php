<?php
/**
 * Count of who has externalbloged something
 *
 *  @uses $vars['entity']
 */


$list = '';
$num_of_externalblogs = externalblogs_count($vars['entity']);
$guid = $vars['entity']->getGUID();

if ($num_of_externalblogs) {
	// display the number of externalblogs
	if ($num_of_externalblogs == 1) {
		$externalblogs_string = elgg_echo('externalblogs:userexternalblogedthis', array($num_of_externalblogs));
	} else {
		$externalblogs_string = elgg_echo('externalblogs:usersexternalblogedthis', array($num_of_externalblogs));
	}
	$params = array(
		'text' => $externalblogs_string,
		'title' => elgg_echo('externalblogs:see'),
		'rel' => 'popup',
		'href' => "#externalblogs-$guid"
	);
	$list = elgg_view('output/url', $params);
	$list .= "<div class='elgg-module elgg-module-popup elgg-externalblogs hidden clearfix' id='externalblogs-$guid'>";
	$list .= elgg_list_annotations(array(
		'guid' => $guid,
		'annotation_name' => 'externalblogs',
		'limit' => 99,
		'list_class' => 'elgg-list-externalblogs'
	));
	$list .= "</div>";
	echo $list;
}
