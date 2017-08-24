<?php

/* Niveaux d'accès :
	Logique : 
	- ouvert + noir ssi totalement ouvert/public
	- fermé et couleur si restreint de quelque manière que ce soit
		* tous les membres du site : vert
		* groupes : bleu
		* contacts : orange
		* liste de contacts : jaune
		* privé/brouillon : rouge
	- par défaut : grisé
*/


$urlicon = elgg_get_site_url() . 'mod/access_icons/graphics/';
//$padding_left = '18px';
$padding_left = '0';
?>

/* Adds a placeholder before text so there is no icon overlap */
.access-icon-placeholder { display: inline-block; width: 18px; }

.elgg-access { display: inline-block; }
.elgg-output .elgg-access { padding-left:18px; }
.elgg-access a { display: inline-block; margin-left: -<?php echo $padding_left; ?>; padding-left: <?php echo $padding_left; ?>; min-height: 16px; min-width:16px; text-decoration:none; }
.elgg-access a:hover, .elgg-access a:active, .elgg-access a:focus { text-decoration:none; }
.access-icons { float:right; font-size:0.75rem; margin-left: 15px; margin-top: 6px; }

/* Hack : can't easily insert access info into listings, so this class lets us "insert" it it the listing item */
.access-icons.access-icons-listing { /* margin-bottom: -21px; */ margin-top: 2px; }

.elgg-menu-item-access { /* margin-top: -8px; */ }


/* Listing des groupes : groupes ouverts et fermés (membership) */
/*
.elgg-menu-item-membership { height: 16px; width: 16px; overflow: hidden; color: transparent; }
*/
.membership-group-open { min-height:16px; padding-left:18px; background: transparent url(<?php echo $urlicon; ?>access-open.png) no-repeat left 50%; }
.membership-group-closed { min-height:16px; padding-left:18px; background: transparent url(<?php echo $urlicon; ?>access-closed.png) no-repeat left 50%; }


/* Groupes ouverts et fermés (liste des contenus) */
.elgg-access-group-open { min-height:16px; padding-left:18px; background: transparent url(<?php echo $urlicon; ?>access-open.png) no-repeat left 50%; }
.elgg-access-group-closed { min-height:16px; padding-left:18px; background: transparent url(<?php echo $urlicon; ?>access-closed.png) no-repeat left 50%; }
.shared_collection {  }



/* Couleur par défaut : grisé */
.elgg-access, .elgg-access.elgg-access-default { padding-left:<?php echo $padding_left; ?>; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-default.png) no-repeat top left; }

/* Public : noir et ouvert */
.elgg-access.elgg-access-public { padding-left:<?php echo $padding_left; ?>; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-public.png) no-repeat top left; }

/* Membres : vert et fermé */
.elgg-access.elgg-access-members { padding-left:<?php echo $padding_left; ?>; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-members.png) no-repeat top left; }

/* Site = accès spéciaux génériques : violet */
.elgg-access.elgg-access-site { padding-left:<?php echo $padding_left; ?>; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-site.png) no-repeat top left; }

/* Groupe : bleu et fermé */
.elgg-access.elgg-access-group { padding-left:<?php echo $padding_left; ?>; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-group.png) no-repeat top left; }

/* Contacts : orange et fermé */
.elgg-access.elgg-access-friends { padding-left:<?php echo $padding_left; ?>; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-friends.png) no-repeat top left; }

/* Liste de contacts : jaune et fermé */
.elgg-access.elgg-access-collection { padding-left:<?php echo $padding_left; ?>; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-collection.png) no-repeat top left; }

/* Privé : rouge et fermé */
.elgg-access.elgg-access-private { padding-left:<?php echo $padding_left; ?>; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-private.png) no-repeat top left; }
/* Brouillon : idem privé car le contenu est forcément privé */
.elgg-menu-item-published-status { padding-left:<?php echo $padding_left; ?>; min-width:16px; min-height:16px; background: transparent url(<?php echo $urlicon; ?>access-private.png) no-repeat top left; }


