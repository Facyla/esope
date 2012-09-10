<?php
/**
 * externalmember plugin
 *
 */
elgg_register_event_handler('init', 'system', 'externalmember_init'); // Init
elgg_register_event_handler('pagesetup', 'system', 'externalmember_pagesetup'); // Init


/**
 * Init externalmember plugin.
 */
function externalmember_init() {
	
	if (elgg_is_logged_in()) {
	  $user = elgg_get_logged_in_user_entity();
	  if ($user->isexternal == 'yes') {
	    
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
		  $allowed_handlers = array('js', 'css', 'ajax', 'groupicon');
		  $forbidden_handlers = array('profile', 'members', 'categories');
		  $conditional_handlers = array('announcements', 'blog', 'bookmarks', 'brainstorm', 'discussion', 'file', 'pages', 'event_calendar', 'groups', 'settings', 'notifications', 'activity');
		  
		  // Comportements selon les cas
		  if (empty($handler)) {
		    // Autorisé : Accueil
		    
	    } else if (in_array($handler, $allowed_handlers)) {
		    // Autorisés dans tous les cas
		    
	    } else if (in_array($return_value['handler'], $forbidden_handlers)) {
	      register_error("Désolé, l'accès au site est limité à la page d'accueil et aux groupes dans lesquels vous intervenez.");
	      forward($home);
	      
	    } else if (in_array($return_value['handler'], $conditional_handlers)) {
	      //system_message("Ces pages sont accessibles en fonction de vos groupes.");
	      $segments = $return_value['segments'];
	      if ($segments[0] == "group") {
	        if (!in_array($segments[1], $allowed_groups)) {
	          register_error("Désolé, vous essayez d'accéder à une page d'un groupe auquel vous n'avez pas accès.");
	          forward($home);
	        }
	      } else {
	        // Vérifier le conteneur de l'objet
	        //register_error("Désolé, l'accès aux contenus est limité aux groupes dans lesquels vous intervenez.");
  	      //forward($home);
	      }
	      
	    } else {
	      system_message("L'accès à ces pages n'est pas encore déterminé : " . $return_value['handler']);
      }
		  //return false; // Interrompt la gestion des handlers
	  }
	}
	return $parameters;
}



/* Méthode 2 : Filtrage lors de l'affichage de la page */
/**
 * Overrides default permissions for the external members
 * grants access to specific content
 * WRITE access only
 */
// But = restreindre l'accès si on n'est pas dans l'un des containers configurés
function externalmember_permissions_check($hook_name, $entity_type, $return_value, $parameters) {
	// elgg_override_permissions(true) // overrides access system
	
	// Si loggué seulement, sinon on laisse les autres plugins voir..
  if (elgg_is_logged_in()) {
    $user = elgg_get_logged_in_user_entity();
    global $CONFIG;
    $home = $CONFIG->url;
    if (($user->isexternal == 'yes') && (current_page_url() != $home)) {
      $allowed_groups = explode(',', $user->external_groups);
		  //echo "PERMISSIONS $hook_name, $entity_type";
		  if ($entity_type == "object") {
		    //echo $parameters['entity']->guid;
//		    echo "object in " . $parameters['entity']->container_guid;
		    if (in_array($parameters['entity']->container_guid, $allowed_groups)) {
//		      echo "OK";
		    } else {
		      register_error("Vous n'avez pas accès à cette page.");
		      forward($home);
		    }
		  } else if ($entity_type == "group") {
		    //echo $parameters['entity']->guid;
//		    echo "group " . $parameters['entity']->guid;
		    if (in_array($parameters['entity']->guid, $allowed_groups)) {
		      // OK
		    } else {
		      register_error("Vous n'avez pas accès à ce groupe.");
		      return false;
		      //forward($home);
		    }
		  } else if ($entity_type == "user") {
		    //echo $parameters['entity']->guid;
//		    echo "user in " . $parameters['entity']->container_guid;
		  } else {
		    //echo $parameters['entity']->guid;
//		    echo "$entity_type in " . $parameters['entity']->container_guid;
		  }
		  
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
		      // On est dans un groupe : suffit de savoir si c'est l'un des bons 
		      // et c'est réglé pour les accès limités aux contenus dans les groupes
		      $allowed_groups = explode(',', $user->external_groups);
		      if (!in_array($owner->guid, $allowed_groups)) {
		        // Pas d'accès à ce groupe => eject
		        register_error("Vous n'avez pas accès à ce groupe.");
		        forward($home);
		      }
		    } else {
		      // Pas un groupe : on ne fait rien et on utilise les autres méthodes
		      // Peut être un contenu dans un groupe, etc.
		    }
	    }
	  }
	}
	return true;
}


// Remplace l'index par la page configurée, ou par index.php sinon
function externalmember_index() {
  global $CONFIG;
  
	// Ensure that only logged-in users can see this page
	gatekeeper();

	// Set context and title
	elgg_set_context('dashboard');
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	$title = elgg_echo('dashboard');
	
	// Define static elements in top of widgets - or use a modified widgets view directly
	$static = '<h2 class="invisible">Page d\'accueil invité</h2><hr />';
	$content = '<h3>Compte invité - accès limité</h3>';
	$content .= '<ul>';
	$content .= '<li>TODO : Liste de vos groupes</li>';
	$content .= '<li>TODO : Liste de vos contacts</li>';
	$content .= '</ul>';
	
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

