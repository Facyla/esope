<?php
/**
 * prevent_notificationss
 *
 */

elgg_register_event_handler('init', 'system', 'prevent_notifications_init'); // Init


/**
 * Init prevent_notifications plugin.
 */
function prevent_notifications_init() {
  global $CONFIG;
  // START.PHP : fonction pour bloquer les notifications si on a demandé à les désactiver
  register_plugin_hook('object:notifications', 'all', 'prevent_notifications_object_notifications_disable', 0);
  
  //elgg_extend_view('input/form', 'prevent_notifications/prevent_form_extend', 400);
  //elgg_extend_view('input/access', 'prevent_notifications/prevent_form_extend', 400);
  /*
  elgg_extend_view('forms/blog/save', 'prevent_notifications/prevent_form_extend', 400);
  elgg_extend_view('forms/pages/edit', 'prevent_notifications/prevent_form_extend', 400);
  */
  /*
  #blog-post-edit ou .elgg-form-blog-save
  .elgg-form-pages-edit
  */
}

function prevent_notifications_object_notifications_disable($hook, $entity_type, $returnvalue, $params) {
  $send_notification = get_input('send_notification', true);
  if ($send_notification == 'no') {
    //return true = don't notify
    return true;
  } else {
    // don't change behaviour
    return $returnvalue;
  }
}



