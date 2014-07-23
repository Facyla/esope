<?php
/**
 * externalmember plugin
 *
 */
elgg_register_event_handler('init', 'system', 'externalmember_init'); // Init
elgg_register_event_handler('pagesetup', 'system', 'externalmember_pagesetup');


/**
 * Init externalmember plugin.
 */
function externalmember_init() {
	
	if (elgg_is_logged_in()) {
	  global $CONFIG;
	  $user = elgg_get_logged_in_user_entity();
	  if ($user->isexternal == 'yes') {
	    
	    // Vue chargée en dernier
	    elgg_extend_view('css', 'externalmembers/css_extend');
	    
	    // 1. Redessiner la page d'accueil (pas de tableau de bord tant qu'on ne sait pas limiter les accès)
		  elgg_unregister_plugin_hook_handler('index','system','adf_platform_index', 0);
		  elgg_register_plugin_hook_handler('index','system','externalmember_index', 0);
	
	    // TODOS :
	    // 2. Vérifier les accès, si possible au plus bas niveau des entités
	    
	    // Bas niveau : entités (mais ne les masque pas - permet seulement de rediriger)
	    // Hooks to override permissions under conditions
	    elgg_register_plugin_hook_handler('permissions_check', 'all', 'externalmember_permissions_check');
	    
	    // Moyen niveau : conteneurs (à tester)
      /*
	    elgg_register_plugin_hook_handler('container_permissions_check', 'all', 'externalmember_permissions_check');
      */
      
      // Haut niveau : page_handler
	    elgg_register_plugin_hook_handler('route', 'all', 'externalmember_route');
	    
	    // 3. Changer les vues principales : on définit une autre racine et on reprend la même arborescence
	    elgg_set_view_location('adf_platform/adf_header', $CONFIG->pluginspath . 'externalmembers/alternate_views/');
	    // Plus radical : pas de 2e niveau de menu, et on reprend le principal pour ajouter les projets
	    
	    // 4. Quelques menus en moins
	    // @todo : mettre en place des hooks spécifiques
	    
	  }
	}
}



/* Méthode 1 : Filtrage via le page_handler */
function externalmember_route($hook_name, $entity_type, $return_value, $parameters) {
  if (elgg_is_logged_in()) {
    $user = elgg_get_logged_in_user_entity();
    if ($user->isexternal == 'yes') {
      global $CONFIG;
      $home = $CONFIG->url;
		  //echo "ROUTE $hook_name : $entity_type, return : ".print_r($return_value, true).", params : ".print_r($parameters, true)." - ";
		  $allowed_groups = explode(',', $user->external_groups);
		  $handler = $return_value['handler'];
		  $allowed_handlers = array('js', 'css', 'ajax', 'groupicon', 'messages', 'friends', 'action', 'mod');
		  $forbidden_handlers = array('members', 'categories', 'activity', 'search', 'dashboard', 'invite', 'collections');
		  // $tools_handlers = get_registered_entity_types('object'); // (ne va pas car différent du handler..)
		  $conditional_handlers = array('profile', 'groups', 'settings', 'notifications', 'view', 'friend_request');
		  $tools_handlers = array('announcements', 'blog', 'bookmarks', 'brainstorm', 'discussion', 'file', 'pages', 'event_calendar', 'mission', 'cmspage', 'digest');
		  $conditional_handlers = array_merge($conditional_handlers, $tools_handlers);
	    
      // Note : les segments commencent après le page_handler (ex.: URL: groups/all donne 0 => 'all')
      $segments = $return_value['segments'];
      //echo print_r($segments, true); // debug
//register_error($handler . ' => ' . print_r($segments, true));
//error_log('DEBUG externalmembers ROUTE : ' . $handler . ' => ' . print_r($segments, true));
      
	    // Accueil : autorisé
		  if (empty($handler)) { return $parameters; }
		  
		  // Toujours autorisé
		  if (in_array($handler, $allowed_handlers)) { return $parameters; }
		  
		  // Toujours interdit
	    if (in_array($handler, $forbidden_handlers)) { forward($home); }
	    
		  // Comportements selon les autres cas
		  if (in_array($handler, $conditional_handlers)) {
		    // Switch pour les cas particuliers
		    switch($handler) {
          
          // Profil des membres
		      case 'profile':
	          // Seul son propre profil est accessible et modifiable
	          if ($segments[0] == $user->username) { return $parameters; }
	          // On peut aussi accéder aux profils de ses contacts
	          if ($profile = get_user_by_username($segments[0])) {
	            if (user_is_friend($user->guid, $profile->guid)) { return $parameters; } 
	            else { register_error("Pas en contact."); forward($home); }
            } else { forward($home); }
            break;
	        
	        // Groupes
	        case 'groups':
	          // Toujours interdit : Pas d'annuaire des groupes ni de création
	          if (in_array($segments[0], array('all', 'add'))) { forward($home); }
    	      // Droits d'affichage, d'édition et autres gérés par ailleurs
    	      if (in_array($segments[0], array('profile', 'edit', 'invite', 'activity'))) { return $parameters; }
    	      // Liste de ses groupes et invitations autorisés
    	      if (in_array($segments[0], array('member', 'owner', 'invitations'))) {
    	        if ($segments[1] == $user->username) { return $parameters; /* Droits d'édition gérés par ailleurs */ } 
              else { forward($home); }
  	        }
		        break;
	        
	        // Demandes de contact
	        case 'friend_request':
	          if ($segments[0] == $user->username) { return $parameters; } 
            else { forward($home); }
		        break;
	        
          // Paramètres du compte
	        case 'settings':
            // Types de paramètres personnels autorisés
            if (in_array($segments[0], array('user', 'plugins', 'statistics'))) {
	            // URL mal formées : on arrondit les angles..
	            if (empty($segments[1])) $segments[1] = $user->username;
	            // Accès seulement à son propre profil..
              if ($segments[1] == $user->username) { return $parameters; }
              else { register_error("Vous ne pouvez modifier que votre propre profil."); forward($home); }
            } else { register_error("Vous n'avez pas accès à ces paramètres."); forward($home); }
		        break;
	        
	        case 'event_calendar':
	          if ($segments[0] == 'list') { return $parameters; }
            //else { register_error("Vous ne pouvez modifier que votre propre profil."); forward($home); }
	          break;
          
    		  /*
	        case 'notifications':
		        break;
	        case 'view':
		        break;
	        default:
	          // Accès à définir
	          register_error("L'accès à ces pages n'est pas encore déterminé : " . $handler);
	    	  */
	      }
	      
	      // Cette règle gère l'affichage de toutes les pages d'index des outils des groupes
        // Lecture pages d'accueil des outils : tool/group/group_guid
        // Exception 'discussion' : tool/owner/group_guid
	      if ( (in_array($handler, $tools_handlers) && ($segments[0] == "group")) 
	        || (($handler == 'discussion') && ($segments[0] == "owner")) ) {
	        if (in_array($segments[1], $allowed_groups)) {
	          return $parameters;
	        } else {
	          register_error("Désolé, vous essayez d'accéder à une page d'un groupe auquel vous n'avez pas accès."); forward($home);
	        }
	      }
	      
	      // Cette règle gère l'affichage et l'édition de tous les contenus publiés dans les groupes
        // Lecture : tool/view/entity_guid
        // Edition : tool/edit/entity_guid
	      if (in_array($handler, $tools_handlers) && in_array($segments[0], array('view', 'edit'))) {
          $entity = get_entity($segments[1]);
          if (in_array($entity->container_guid, $allowed_groups)) {
	          return $parameters;
          } else {
            register_error("Vous n'avez pas accès à cette publication (hors d'un de vos groupes)."); forward($home);
          }
	      }
	      
	      // Cette règle gère la création de tous les contenus publiés dans les groupes
        // Création : tool/add/group_guid
	      if (in_array($handler, $tools_handlers) && ($segments[0] == 'add')) {
          if (in_array($segments[1], $allowed_groups)) {
	          return $parameters;
          } else {
            register_error("Vous ne pouvez pas créer de publication hors des groupes auxquels vous appartenez."); forward($home);
          }
	      }
	      
        // Pour toutes les publications : on vérifie le container (cas particuliers puis génériques)
        if ($handler == 'event_calendar') {
          return $parameters;
        } else if ($handler == 'digest') {
          return $parameters;
        } else if (in_array($handler, $tools_handlers)) {
          if (in_array($segments[1], $allowed_groups)) {
            // Ok, selon droits d'édition déterminés par ailleurs
          } else {
            $entity = get_entity($segments[1]);
	          if (in_array($entity->container_guid, $allowed_groups)) {
  	          // OK
            } else {
	            register_error("Vous n'avez pas accès à cette page (hors d'un groupe autorisé)."); forward($home);
            }
          }
        }
        
	    }
	    //  @todo : Pour tous les autres cas => déterminer le handler et ajuster le comportement
      register_error("L'accès à ces pages n'est pas encore déterminé (les droits standards s'appliquent) : " . $handler . ' / ' . print_r($segments, true));
      error_log("L'accès à ces pages n'est pas encore déterminé : " . $handler . ' / ' . print_r($segments, true));
	  }
	}
  /* Valeurs de retour :
    * return false; // Interrompt la gestion des handlers
    * return $parameters; // Laisse le fonctionnement habituel se poursuivre
  */
	return $parameters;
}



/* Méthode 2 : Filtrage EN ECRITURE lors de l'affichage de la page */
// On l'utilise car cet accès permet de forwarder sur la home lorsque on tente de savoir si un accès en écriture est autorisé
/**
 * Overrides default permissions for the external members
 * grants access to specific content
 * WRITE access only
 */
// But = restreindre l'accès EN ECRITURE si on n'est pas dans l'un des containers configurés
function externalmember_permissions_check($hook_name, $entity_type, $return_value, $parameters) {
	// elgg_override_permissions(true) // overrides access system
//error_log('DEBUG externalmembers PERMISSION CHECK : ' . $hook_name . ' / ' . $entity_type . ' / ' . print_r($parameters, true));
	// Si loggué seulement, sinon on laisse les autres plugins voir..
  if (elgg_is_logged_in()) {
    $user = elgg_get_logged_in_user_entity();
    global $CONFIG;
    $home = $CONFIG->url;
    if ($user->isexternal == 'yes') {
      // Pas d'interdiction sur l'accueil
      if (current_page_url() == $home) { return $parameters; }
      // Groupes autorisés
      $allowed_groups = explode(',', $user->external_groups);
      $container_guid = $parameters['entity']->container_guid;
		  // Objets
		  if ($entity_type == "object") {
		    //echo $parameters['entity']->guid;
//		    echo "object in " . $container_guid;
		    if (in_array($container_guid, $allowed_groups) || (user_is_friend($user->guid, $container_guid))) {
		      if ($container = get_entity($container_guid)) {
		        if ($container instanceof ElggGroup) { return $parameters; } 
		        else if ($container instanceof ElggUser) { return $parameters; } 
		        else {
		          register_error("Vous n'avez pas accès à cette page (hors groupe ou pas en contact).");
		          forward($home);
		        }
		      } else register_error("Container non valide.");
		    } else {
		      // Un peu violent mais efficace pour empêcher l'accès à toute page qui contient un élement inaccessible
		      register_error("Vous n'avez pas accès à cette page (contenus non autorisés).");
		      forward($home);
		    }
		  } else if ($entity_type == "group") {
		    // Groupes
		    //echo $parameters['entity']->guid;
//		    echo "group " . $parameters['entity']->guid;
		    if (in_array($parameters['entity']->guid, $allowed_groups)) {
		      // OK
		      return $parameters;
		    } else {
		      register_error("Vous n'avez pas accès cette page (hors d'un de vos groupes).");
		      return false;
		      //forward($home);
		    }
		  } else if ($entity_type == "user") {
		    // Membres
		    if ($parameters['entity']->guid == $user->guid) {
		      // Ok (concerne le membre lui-même)
		      return $parameters;
		    } else {
		    }
	      return $parameters;
		    //echo $parameters['entity']->guid;
//		    echo "user in " . $parameters['entity']->container_guid;
		  } else {
		    // Autres cas
		    //echo $parameters['entity']->guid;
//		    echo "$entity_type in " . $parameters['entity']->container_guid;
		  }
		  
error_log('DEBUG externalmembers PERMISSION CHECK 2 : ' . elgg_get_context() . ' / ' . $hook_name . ' / ' . $entity_type . ' / ' . $parameters['entity']->guid);
		  return false;
	  }
	}
	return $parameters;
} 



/* Méthode 3 : Filtrage lors de l'affichage de la page, selon le page_owner
 * règle : l'owner d'une page est fiable : si c'est un groupe on filtre, sinon rien
*/
function externalmember_pagesetup() {
	if (elgg_is_logged_in()) {
	  $user = elgg_get_logged_in_user_entity();
	  if ($user->isexternal == 'yes') {
      global $CONFIG;
      $home = $CONFIG->url;
	    if (current_page_url() != $home) {
        $owner = elgg_get_page_owner_entity();
		    if ($owner instanceof ElggGroup) {
		      // On est dans un groupe : il suffit de déterminer si c'est l'un des groupes autorisés 
		      // et c'est réglé pour les accès limités aux contenus dans les groupes
		      $allowed_groups = explode(',', $user->external_groups);
		      if (!in_array($owner->guid, $allowed_groups)) {
		        // Pas d'accès à ce groupe => eject
		        register_error("Vous n'avez pas accès à ce groupe.");
		        forward($home);
		      }
		    } else {
		      // Pas un groupe : on ne fait rien et on utilise les autres méthodes
		      // Peut être un contenu dans un groupe, etc. mais surtout tout autre chose : réglages, etc.
		      // Mieux vaut travailler sur la route prise..
		    }
	    }
	    // @todo : D'autres choses pour le pagesetup ?  c'est ici
	  }
	}
	return true;
}


// Remplace l'index par la page configurée, ou par index.php sinon
function externalmember_index() {
  global $CONFIG;
  $db_prefix = elgg_get_config('dbprefix');
  
	// Ensure that only logged-in users can see this page
	gatekeeper();
	$user = elgg_get_logged_in_user_entity();
	
	// Set context and title
	elgg_set_context('dashboard');
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	$title = elgg_echo('home');
	
	// Define static elements in top of widgets - or use a modified widgets view directly
	$static = '<h2 class="invisible">Page d\'accueil invité</h2>';
	//$content = '<h3>Groupes et projets</h3><br />';
	// TODO : faire qu'on soit forcément membre des groupes auxquels on est autorisé à accéder ?
	//$groups_content = elgg_list_entities_from_relationship(array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid, 'limit' => 10, 'full_view' => FALSE, 'pagination' => true));
  
  // On est dans un groupe : il suffit de déterminer si c'est l'un des groupes autorisés 
  // et c'est réglé pour les accès limités aux contenus dans les groupes
  $allowed_groups = explode(',', $user->external_groups);
  $switch = 'left';
  $ignore_access = elgg_get_ignore_access(); elgg_set_ignore_access(true);
  foreach ($allowed_groups as $group_guid) {
    $group = get_entity($group_guid);
    // On rejoint le groupe si ce n'est pas déjà le cas
    if ($group->isMember($user)) {} else { $group->join($user); }
    //$groups_content .= elgg_view_entity($group);
    $groups_content .= '<div class="" style="margin-bottom:30px; border-top:0px solid grey; float:'.$switch.'; width:45%;">';
    $groups_content .= '<img style="float:left; margin:0 12px 6px 0;" src="' . $group->getIconURL('small') . '" />';
    //$groups_content .= '<h4><a href="' . $group->getURL() . '">' . $group->name . '</a></h4>';
    $groups_content .= '<h4><a href="' . $CONFIG->url . 'groups/activity/' . $group->guid . '">' . $group->name . '</a></h4>';
    $groups_content .= '<em>' . $group->briefdescription . '</em>';
    //$groups_content .= '<span>' . elgg_view('output/tags', array('value' => $group->interests)) . '</span>';
    //$groups_content .= '<blockquote>' . $group->description . '</blockquote>';
    $groups_content .= '<div class="" style="font-size:85%;">';
    // Activité du groupe
	  $groups_content .= elgg_list_river(array('limit' => 3, 'pagination' => false, 
	    'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"), 
	    'wheres' => array("(e1.container_guid = {$group->guid})")
	    ));
    $groups_content .= '</div>';
    $groups_content .= '<div class="clearfloat"></div></div>';
    if ($switch == 'left') $switch = 'right'; else $switch = 'left';
    
  }
  elgg_set_ignore_access($ignore_access);
	if ($groups_content) { $content .= $groups_content; } else { $content .= elgg_echo('groups:none'); }
	
	
	/*
	// Fil d'activité filtré
	$content .= '<h3>Activité récente</h3>';
	$entities_filter = get_entities(array('container_guids' => $allowed_groups));
	$activity_filter = array('object_guids' => $entities_filter);
	$content .= elgg_list_river($activity_filter);
	*/
	
	/*
	$content .= '<h3>Contacts</h3>';
	$contacts = elgg_list_entities_from_relationship(array('relationship' => 'friend', 'relationship_guid' => $user->guid, 'inverse_relationship' => FALSE, 'type' => 'user', 'full_view' => FALSE));
	if ($contacts) { $content .= $contacts; } else { $content .= elgg_echo('friends:none'); }
	*/
	
	$body = elgg_view_layout('one_column', array('content' => $static . $content));

	echo elgg_view_page($title, $body);
	return true;
}

/*
if ($params['user'] && $params['container']) {
	$container_guid = $params['container']->getGUID();
	$user_guid = $params['user']->getGUID();
	if (check_entity_relationship($user_guid, 'operator', $container_guid))
		return true;
}
*/


