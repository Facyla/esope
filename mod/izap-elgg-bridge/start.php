<?php

/* * ************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2010. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

define('GLOBAL_IZAP_ELGG_BRIDGE', 'izap-elgg-bridge');
define('GLOBAL_IZAP_PAGEHANDLER', 'izap_pagehandler_bridge');
define('GLOBAL_IZAP_ACTIONHOOK', 'izap_actionhook_bridge');
//init for the bridge plugin
elgg_register_event_handler('init', 'system', 'izap_bridge_init');

function izap_bridge_init() {
  global $CONFIG;

  //including venders directory in default include paths.
  set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/vendors/');

  // initializes the bridge plugin
  izap_plugin_init(GLOBAL_IZAP_ELGG_BRIDGE);

  //registering tab view javascript
  elgg_register_js('jquery.md5', 'mod/izap-elgg-bridge/vendors/tabs_view.js');

  //load library for the bridge(using bridge)
  IzapBase::loadLib(array('plugin' => GLOBAL_IZAP_ELGG_BRIDGE, 'lib' => 'init'));
  // over-ride "admin" pagehandler
  elgg_register_page_handler('admin', GLOBAL_IZAP_PAGEHANDLER);

  // register some basic hooks
  elgg_register_plugin_hook_handler('register', 'user', 'izap_registration_sniffer');
  elgg_register_event_handler('login', 'user', 'izap_login_sniffer');
  elgg_register_event_handler('create', 'all', 'izap_entity_creation_sniffer');
  elgg_register_event_handler('update', 'all', 'izap_entity_updation_sniffer');
  elgg_register_event_handler('delete', 'all', 'izap_entity_deletion_sniffer');
  elgg_register_event_handler('ready', 'system', 'system_ready_hook');
  elgg_register_plugin_hook_handler('config', 'htmlawed', 'izap_htmlawed_hook');

  // set pages for the admin
  elgg_register_admin_menu_item('administer', 'marked-spammers', 'users'); // @todo: merge to izap menu
  elgg_register_admin_menu_item('administer', 'suspected-spammers', 'users'); // @todo: merge to izap menu

  /**
   * common horizontal control menu hook registration for all plugins dependent
   * on izap-elgg-bridge
   */
  elgg_register_plugin_hook_handler('register', 'menu:entity', 'izap_entity_menu_setup');

  elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'izap_mark_spammer');

  elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'izap_unmark_spammer');

  elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'izap_suspected_spammer');
  elgg_extend_view('page/elements/footer', GLOBAL_IZAP_ELGG_BRIDGE . '/our_link');
  if (elgg_is_admin_logged_in()) {
    if (IzapBase::pluginSetting(array(
                'name' => 'izap_api_key',
                'plugin' => GLOBAL_IZAP_ELGG_BRIDGE,
            )) == '') {
      elgg_add_admin_notice('api_key', elgg_echo('izap-bridge:add_api'));
    }
  }
  $global_currency = IzapBase::pluginSetting(array(
              'name' => 'izap_site_currency',
              'plugin' => GLOBAL_IZAP_ELGG_BRIDGE
          ));

  if ($global_currency == '') {
    $CONFIG->site_currency_name = 'USD';
    $CONFIG->SITE_CURRENCY_SIGN = '$';
  } else {
    $site_currency = explode(':', $global_currency);
    $CONFIG->site_currency_name = $site_currency[0];
    $CONFIG->site_currency_sign = $site_currency[1];
  }

  // regiter antispam with elgg
  elgg_register_ajax_view('/js/antispam/userstats');
}

/**
 * Reads the path and reads the file and directories
 *
 * @param string $path    the path to be read
 * @return array          an array containing the matched files/directories and
 *                        if the path is empty it returns the current directory
 */
function izap_read_dir($path = '') {
  global $CONFIG;
  if (empty($path)) {
    $path = dirname(__FILE__) . DIRECTORY_SEPARATOR;
  }
  return glob($path);
}

function izap_pagehandler_bridge($page) {
  // set page Owner first, plugins can change it later
  IzapBase::setPageOwner($page[1]);

  // get the context to get the controller
  $context = elgg_get_context();
  //defines the controller class
  $class = 'Izap' . ucfirst($context) . 'Controller';
  //global definition for the class
  define('GLOBAL_IZAP_CURRENT_CONTROLLER', $class);
  // now start the action
  $controller = new $class($page);
  //calls the action of the class controller
  $controller->runAction();
  return true;
}

/**
 * validates the form and its attributes
 * compulsory fields are checked,filter the tags and
 * push the attributes to the config
 * @global global $CONFIG
 */
function izap_actionhook_bridge() {
  global $CONFIG;

  $CONFIG->post_byizap->form_validated = true;
  if (isset($_REQUEST['attributes'])) {
    @array_walk_recursive($_REQUEST['attributes'], 'get_input');
    foreach ($_REQUEST['attributes'] as $key => $val) {
      if ($key[0] == "_") {
        $attr = substr($key, 1);
        if ($val !== '0' && empty($val)) {
          $CONFIG->post_byizap->form_validated = FALSE;
          $CONFIG->post_byizap->form_errors[] = elgg_echo($_POST['attributes']['plugin'] . ':form_error:empty:' . $attr);
        }
      } else {
        $attr = $key;
      }
      $CONFIG->post_byizap->attributes[$attr] = filter_tags($val);
    }
    // put every thing to session
    elgg_make_sticky_form($CONFIG->post_byizap->attributes['plugin']);
    unset($_POST['attributes']);
  }
}

/**
 * displays the array in formatted manner
 * @param array $array  to be displayed
 */
function c($array) {
  echo '<pre>';
  echo '<div style="border:3px solid #000">';
  print_r($array);
  echo '</div>';
  echo '</pre>';
}

/**
 * initialises the plugin and some common tasks for all the plugins
 *
 * handles most of the common tasks e.g:
 * registeration of help file
 * registration of library
 * registration of hooks and actions
 * extending views
 *
 * @global global $CONFIG
 * @param string $plugin_id the id of the plugin to initialize
 * @param array $options optioinal array to provide extra information
 */
function izap_plugin_init($plugin_id, $options=array()) {
  global $CONFIG;
  $plugin_path = elgg_get_plugins_path() . $plugin_id . DIRECTORY_SEPARATOR;

  /**
   * reading the "lib", and registering it
   */
  $files = izap_read_dir($plugin_path . 'lib' . DIRECTORY_SEPARATOR . '*.php');
  if (sizeof($files)) {
    foreach ($files as $file) {
      $file_bak = $file;
      if (is_file($file)) {
        preg_match('/([a-zA-Z0-9\-\_\.]+)\.php/', $file, $file);
        elgg_register_library("izap:{$plugin_id}:{$file[1]}", $file_bak);
      }
    }
  }

  /**
   * reading "actions", and registering it according
   */
  $action_dirs = izap_read_dir($plugin_path . 'actions' . DIRECTORY_SEPARATOR . '*');
  if (sizeof($action_dirs)) {
    foreach ($action_dirs as $action_dir) {
      if (is_dir($action_dir)) {
        $dir_name = basename($action_dir);
        $action_files = izap_read_dir($action_dir . DIRECTORY_SEPARATOR . '*.php');
        if (sizeof($action_files)) {
          foreach ($action_files as $file) {
            $action_name = $plugin_id . '/' . current(explode('.', basename($file)));
            elgg_register_action($action_name, $file, $dir_name);
            elgg_register_plugin_hook_handler('action', $action_name, GLOBAL_IZAP_ACTIONHOOK);
          }
        }
      }
    }
  }

  /**
   * extending the views of css,js and metatags
   */
  elgg_extend_view('css/elgg', $plugin_id . '/css');
  elgg_extend_view('css/admin', $plugin_id . '/admin_css');
  elgg_extend_view('js/elgg', $plugin_id . '/js');
  elgg_extend_view('html_head/extend', $plugin_id . '/metatags');
}

/**
 * Registering elgg menu for suspected spammers
 * @param <type> $hook
 * @param <type> $type
 * @param <type> $return
 * @param <type> $params
 * @return <type>
 */
function izap_suspected_spammer($hook, $type, $return, $params) {

  $user = $params['entity'];
  if (elgg_instanceof($user, 'user')) {
    $item = ElggMenuItem::factory(array('name' => 'suspected_spammer', 'text' => elgg_Echo('izap:bridge:suspected_spammer'), 'guid' => $user->guid));
    $item->setLinkClass('izap_suspected_spammer');
    $item->setSection('admin');
    $return[] = $item;
  }
  return $return;
}

/**
 * Registering menu in user icon menu to mark anyone as spammer.
 * @param <type> $hook
 * @param <type> $type
 * @param ElggMenuItem $return
 * @param <type> $params
 * @return ElggMenuItem 
 */
function izap_mark_spammer($hook, $type, $return, $params) {

  $user = $params['entity'];
  if (elgg_instanceof($user, 'user')) {
    $item = new ElggMenuItem('mark_spammer', elgg_echo('izap:bridge:mark_spammer'),
                    elgg_add_action_tokens_to_url(IzapBase::getFormAction('mark_spammer', GLOBAL_IZAP_ELGG_BRIDGE) . '?guid=' . $user->guid));
    $item->setSection('admin');
    $return[] = $item;
  }
  return $return;
}

function izap_unmark_spammer($hook, $type, $return, $params) {
  $user = $params['entity'];
  if (elgg_instanceof($user, 'user')) {
    $item = new ElggMenuItem('unmark_spammer', elgg_echo('izap:bridge:unmark_spammer'),
                    elgg_add_action_tokens_to_url(IzapBase::getFormAction('not_spammer', GLOBAL_IZAP_ELGG_BRIDGE) . '?guid=' . $user->guid));
    $item->setSection('admin');
    $return[] = $item;
  }
  return $return;
}
