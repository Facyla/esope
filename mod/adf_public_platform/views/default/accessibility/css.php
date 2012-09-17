.invisible { position:absolute !important; left:-5000px !important; }
.blockform > div { margin-bottom: 15px; }
.blockform > div:last-child { margin-bottom: 0; }
.elgg-form-alt > .blockform > .elgg-foot { border-top: 1px solid #CCC; padding: 10px 0; }

.entity_title {font-weight:bold; }


/* Corrections des styles du core */
:focus {
	outline: 1px dotted grey;
}
input:focus, textarea:focus {
	outline:0;
}
.ui-autocomplete-input:focus {
	outline:0;
}
.elgg-button-action:hover,
.elgg-button-action:focus {
	outline:0;
}
.elgg-search input[type=text]:focus, .elgg-search input[type=text]:active {
	outline:0;
}

.elgg-page-header .elgg-search input[type=submit] {
	display: block !important;
}



<?php /*
// Tous les :hover à compléter par :focus et :active : cf. thème ADF

// Tous les display:none des menus à modifier/remplacer par des left:-5000px puis remettre en place..


.elgg-menu-site > li > ul {
	display: none;
}

.elgg-menu-page .elgg-child-menu {
	display: none;
}

.elgg-menu-hover {
	display: none;
}

.elgg-widget-edit {
	display: none;
}

.elgg-avatar > .elgg-icon-hover-menu {
	display: none;
	right: 0;
	bottom: 0;
}

.elgg-menu-topbar > li > ul {
	display: none;
  left:12px; top:21px; 
}

=> fonctionne sans JS mais pas accessible au clavier
=> modifier les display:none => left:-5000px;
=> les afficher via left: valeur; ou right:valeur;

=> remplacer par un masquage en JS



.elgg-menu-site > li > ul {
	display: none;
}

.elgg-menu-page .elgg-child-menu {
	display: none;
}

.elgg-menu-hover {
	display: none;
}

.elgg-widget-edit {
	display: none;
}

.elgg-avatar > .elgg-icon-hover-menu {
	display: none;
	right: 0;
	bottom: 0;
}

.elgg-menu-topbar > li > ul {
	display: none;
  left:12px; top:21px; 
}
*/ ?>



