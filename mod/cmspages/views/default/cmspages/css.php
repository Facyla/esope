pre, code { word-break:break-all; }

/* IE6 */
* html #front_left_tbl { width:676px !important; }
* html #front_right_tbl { width:676px !important; }

#elgg_horizontal_tabbed_nav li.selected, #elgg_horizontal_tabbed_nav .selected a { background: white; color: #4690d6; font-weight:bold;  }
#elgg_horizontal_tabbed_nav li { background: #eeeeee; color: #4690d6; }
#elgg_horizontal_tabbed_nav li form input { background: transparent; font-weight:bold; height:14px; }


/* Cmspages edit form */
#cmspages-edit-form fieldset { border: 1px solid; padding: 1ex; margin:1ex 0 3ex 0; }
#cmspages-edit-form legend { margin:0 1ex; padding:0.5ex 1ex; border: 1px solid; font-weight:bold;}
#cmspages-edit-form ul { list-style-type: square; margin-left: 3ex; }
#cmspages-edit-form input, #cmspages-edit-form select { max-width:100%; }
#cmspages-edit-form select { max-width:28ex; }
#cmspages-edit-form .cmspages-delete { float: right; }

#cmspages-form-select { display:inline-block; }
#cmspages-form-new {  }
.cmspages-history { padding: 1ex 0 3ex 0; max-height:20ex; overflow:auto; }


/* CMS Pages */
.elgg-context-cmspages_admin .elgg-output ul { list-style-type:disc; margin-left:3ex; }
.elgg-module-popup.cmspages-popup { background: white; border: 1px solid; padding: 1ex; }
.elgg-context-cmspages_admin .elgg-breadcrumbs { float: left; margin-right: 2ex; }
.elgg-context-cmspages_admin .elgg-breadcrumbs li { float: left; margin-right: 1ex; }
.elgg-context-cmspages_admin .elgg-breadcrumbs li:before { content:">"; margin-right:1ex; }
.elgg-context-cmspages_admin .elgg-breadcrumbs li:first-of-type:before { content:""; margin-right:0; }
.elgg-cmspages-output { /* margin-top:0; */ }


/* CMS Pages admin listing */
.cmspages-item { display:block; margin:0px 0 1ex 0; padding:0.5ex 1ex; border:1px solid; border-radius:6px; }
.cmspages-content_type { font-weight:bold; background:#CCC; min-width:10ex; display:inline-block; color: white; text-align: center; border-radius: 1ex; font-size:70%; padding: 2px 4px; margin-right: 1ex; }
/* Différenciation des types de contenus */
.cmspages-item-, .cmspages-item-editor, .cmspages-item-rawhtml { border-color:#333; }
.cmspages-item- .cmspages-content_type, .cmspages-item-editor .cmspages-content_type, .cmspages-item-rawhtml .cmspages-content_type { background:#333; }
.cmspages-item-module { border-color:#060; }
.cmspages-item-module .cmspages-content_type { background:#060; }
.cmspages-item-template { border-color:#006; }
.cmspages-item-template .cmspages-content_type { background:#006; }
#cmspages-form-search input {  }
#cmspages-form-search select { width:100%; }
.cmspages-search-filter a { padding:2px 4px; background:#EEE; border-radius:4px; margin-right:4px; font-size: 90%; color: #333; text-decoration:none; }
.cmspages-search-filter a:hover, .cmspages-search-filter a:focus, .cmspages-search-filter a:active, .cmspages-search-filter a.elgg-selected { background: #333; color: #eee; }

/* CMS Pages edition interface */
#cmspages-edit-form { background: transparent; }
.elgg-context-cmspages_admin { padding: 0 2ex; }
.elgg-context-cmspages_admin .elgg-menu.elgg-breadcrumbs { display: inline-block; padding: 0 0 2ex 0; width: 100%; font-size:90%; color:#666; }
#cmspages-edit-form label { font-size: 120%; }
.cmspages-field { margin-bottom:2ex; }
.cmspages-types-tips {  }
.cmspages-unpublished { font-weight:bold; color:#A00; }
.cmspages-published { font-weight:bold; color:#0A0; }
#cmspages-edit-form .cmspages-categories ul, .cmspages-categories ul { list-style-type: none; margin-left: 0; }
#cmspages-edit-form .cmspages-categories ul ul, .cmspages-categories ul ul { margin-left: 3ex; }
.cmspages-delete { float: right; }

/* Password protection */
.cmspage-password-form { display:inline-block; background:transparent; }
.cmspage-password-form input { max-width:20ex; margin-left:1ex; }


/* Categories menu */
.elgg-menu-cmspages-categories {  }
#cmspages-settings .elgg-menu-cmspages-categories .elgg-child-menu { display:none; }
#cmspages-settings .elgg-menu-cmspages-categories li:hover > .elgg-child-menu { display: block; background:white; padding:0.5ex; box-shadow:1px 1px 3px black; }
#cmspages-settings .elgg-menu-cmspages-categories > .elgg-child-menu { position: absolute; }


/* Edit link on editable block hover */
.cmspages-admin-block { float:right; margin: 0 0 3px 6px; }
.cmspages-editable { /* padding:5px; */ display:inline-block; width: 100%; }
.cmspages-editable:hover { /* border: 2px dashed; padding:3px; */ background: rgba(220,220,255,0.3); display: inline-block; }
.cmspages-editable .fa.fa-edit { color: black; text-shadow: -1px 1px 0px white; }

/* Admin edit link */
.cmspages-admin-notexist {  }
.cmspages-admin-link { font-size:small; background:white; border: 1px solid; text-decoration:none; padding: 1ex 2ex; box-shadow: 2px 2px 3px 0 rgba(0,0,0,0.5); position:relative; z-index: 10001; /* border-radius: 2ex; */ }
.cmspages-admin-link { display: none; }
.cmspages-admin-link:hover { text-decoration:none; }
*:hover > .cmspages-admin-link { display: inline-block; margin-right: 10px; }
*:hover > .cmspages-admin-link a {  }



