<?php
$al = new AnnotationLike(get_input('id'));
if (!$al->isValid()){
	register_error(elgg_echo('annotations:notfound'));
	forward(REFERER);
}

$userid = elgg_get_logged_in_user_guid();
if (!$userid){
	register_error(elgg_echo('annotations:login_required'));
	forward(REFERER);
}

if ($al->like($userid)){
	system_message(elgg_echo('annotations:like:success'));
}else{
	system_message(elgg_echo('annotations:error'));
}

//forward($al->getAnnotation()->getEntity()->getURL());
// Back to the same exact page as before action !
forward(REFERER);

