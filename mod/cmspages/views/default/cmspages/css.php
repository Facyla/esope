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

#cmspages-form-select { display:inline-block; }
#cmspages-form-new {  }


/* CMS Pages admin listing */
.cmspages-item { display:block; margin:0px 0 1ex 0; padding:0.5ex 1ex; border:1px solid; border-radius:6px; }
.cmspages-content_type { font-weight:bold; background:#CCC; min-width:10ex; display:inline-block; color: white; text-align: center; border-radius: 1ex; font-size:70%; padding: 2px 4px; margin-right: 1ex; }
/* Différenciation des types de contenus */
.cmspages-item-, .cmspages-item-editor, .cmspages-item-rawhtml { border-color:#333; }
.cmspages-item- .cmspages-content_type, .cmspages-item-editor .cmspages-content_type, .cmspages-item-rawhtml .cmspages-content_type { background:#333; }
.cmspages-item-module { border-color:#090; }
.cmspages-item-module .cmspages-content_type { background:#090; }
.cmspages-item-template { border-color:#009; }
.cmspages-item-template .cmspages-content_type { background:#009; }


/* CMS Pages edition interface */
#cmspages-edit-form { background: transparent; }
.elgg-context-cmspages_admin { padding: 0 2ex; }
.elgg-context-cmspages_admin .elgg-menu.elgg-breadcrumbs { display: inline-block; padding: 2ex 0 0 3ex; }
#cmspages-edit-form label { font-size: 120%; }


