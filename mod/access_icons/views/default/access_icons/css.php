<?php
global $CONFIG;
$urlicon = $CONFIG->url . 'mod/access_icons/graphics/';
?>

/* Listing des groupes : groupes ouverts et fermés (membership) */
.elgg-menu-item-membership { height: 16px; width: 16px; overflow: hidden; color: transparent; }
.elgg-menu-item-membership.membership-group-open {background: transparent url(<?php echo $urlicon; ?>access-open.png) no-repeat 50% 50%; }
.elgg-menu-item-membership.membership-group-closed {background: transparent url(<?php echo $urlicon; ?>access-closed.png) no-repeat 50% 50%; }


/* Niveaux d'accès :
	Logique : 
	- ouvert + noir ssi totalement ouvert/public
	- fermé et couleur si restreint de quelque manière que ce soit
		* tous les membres du site : vert
		* groupes : bleu
		* contacts : orange
		* liste de contacts : jaune
		* privé/brouillon : rouge
*/
/* Défaut : grisé */
.elgg-access.elgg-access-default { padding-left:18px; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-default.png) no-repeat top left; }
/* Public : noir et ouvert */
.elgg-access.elgg-access-public { padding-left:18px; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-public.png) no-repeat top left; }
/* Membres : vert et fermé */
.elgg-access.elgg-access-members { padding-left:18px; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-members.png) no-repeat top left; }
/* Groupe : bleu et fermé */
.elgg-access.elgg-access-group { padding-left:18px; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-group.png) no-repeat top left; }
/* Contacts : orange et fermé */
.elgg-access.elgg-access-friends { padding-left:18px; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-friends.png) no-repeat top left; }
/* Liste de contacts : jaune et fermé */
.elgg-access.elgg-access-collection { padding-left:18px; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-collection.png) no-repeat top left; }
/* Privé : rouge et fermé */
.elgg-access.elgg-access-private { padding-left:18px; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-private.png) no-repeat top left; }
/* Brouillon : idem privé car le contenu est forcément privé */
.elgg-menu-item-published-status { padding-left:18px; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-private.png) no-repeat top left; }


/* Groupes ouverts et fermés (liste des contenus) */
.elgg-access-group-open {}
.elgg-access-group-closed {}
.shared_collection {}


