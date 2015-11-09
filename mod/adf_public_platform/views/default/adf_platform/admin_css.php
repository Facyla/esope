html { -webkit-font-smoothing: antialiased; }

.elgg-page-admin header h2 { display:inline; }
.elgg-page-admin header ul { display:inline; float:right; }
.elgg-page-admin header ul li { margin-left:6px; }

/* Feuilles de style jquery UI */
/* Pour la config du plugin de thème */
.ui-icon.ui-icon-triangle-1-e, .ui-icon.ui-icon-triangle-1-s { float: left; margin-right: 4px; }

/* Champs longtext avec éditeur désactivé par défaut */
textarea, .elgg-input-rawtext { width:100%; }

/* Interface admin */
#adf_public_platform-settings .miniColors-trigger { float: right; height: 3ex; width: 3ex; }
#adf_public_platform-settings input { max-width:40%; }
#adf_public_platform-settings label { font-size:90%; }

.elgg-form fieldset { border:1px solid #999; padding:1ex; margin:2ex 0ex; }
.elgg-form fieldset legend { padding:0 0.5ex; }

.elgg-color-picker { max-width:45%; }

.elgg-page-admin .elgg-module-widget li { margin: 0; }
.elgg-module-widget button { padding: 0; border: 0; margin: 0; background: transparent; }


/* Font Awesome */
/* Use FA without i or other empty tags
 - see http://dusted.codes/making-font-awesome-awesome-using-icons-without-i-tags
 - and also the class*= tip from http://www.weloveiconfonts.com/
 Note : this method allows to strip off all "fa" class, 
        but take care to fa-fw which should become fa-fw::before to avoid any problem with containing block
 */
.icon::before, [class*="fa-"]:before {
	display: inline-block;
	font: normal normal normal 14px/1 FontAwesome;
	font-size: inherit;
	text-rendering: auto;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	margin-right: .5em;
	transform: translate(0, 0);
}
/* Extra class for easier scale 1 stacking */
.fa-stack-half { font-size: 0.5em; }
/* Quick effect on hover */
/*
.fa:hover, a:hover .fa, a:hover [class*="fa-"]:before, [class*="fa-"]:hover:before { transform: rotateY(360deg); transition-duration: 0.5s; }
*/


