<?php
$titlecolor = elgg_get_plugin_setting('titlecolor', 'adf_public_platform', '#2195B1');
//$textcolor = elgg_get_plugin_setting('textcolor', 'adf_public_platform', '#2195B1');
$linkcolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform', '#2195B1');
//$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'adf_public_platform', '#2195B1');
?>
#knowledge_database-add li { float: left; width: 31%; min-height: 5em; font-size: 2ex; text-align: center; margin: 1%; padding: 0; border: 1px solid #2195B1; border-radius: 0.5rem; position: relative; }
#knowledge_database-add li .fa { font-size: 3ex; }
#knowledge_database-add li a { text-decoration: none; display: inline-block; padding: 0.5rem; position: absolute; top: 0; bottom: 0; left: 0; right: 0; border-radius: 0.5rem; }
.elgg-context-kdb h3 { border-top: 1px solid <?php echo $titlecolor; ?>; padding-top: 10px; margin-top: 30px; }

/* Group KDB */
.kdb-group-intro { border:1px solid #2195B1; margin:10px; padding:10px; }
.kdb-maingroup-intro { border:1px solid #2195B1; margin:10px; padding:10px; }
.kdb-group-add { border:1px solid #2195B1; margin:10px; padding:10px; }

/* Search interface */
.kdb-search-main { /* width:50%; float:left; */ min-width:300px; }
.kdb-search-main input, .kdb-search-filter select { width: 16ex; max-width:60%; }
.kdb-search-main input[type="text"] { width: 30ex; max-width:60%; }
.kdb-search-main label { color: <?php echo $titlecolor; ?>; padding: 3px 6px; font-size: 1.2em; }

.kdb-search-filter { width:50%; float:left; min-width:200px; padding: 2px 0; }
.kdb-search-filter span { min-width: 17ex; display:inline-block;}
.kdb-search-filter input, .kdb-search-filter select { width: 17ex; }
#knowledge_database-advanced-fields .kdb-search-filter input, #knowledge_database-advanced-fields .kdb-search-filter select { min-width: 10ex; max-width: 18ex; }
.kdb-search-filter label { color: <?php echo $titlecolor; ?>; padding: 3px 6px; font-size: 1.2em; }

/* Search form */
#kdb-search-form fieldset { margin: 1ex 0; padding:1ex; border:1px solid; }
#kdb-search-form legend { padding: 0 1ex; }

/* Search results */
.knowledge_database-result-meta { float: right; font-size: 12px; text-align:right; }
.knowledge_database-result-meta .fa { font-size: 3ex; }
#esope-search-results .elgg-image { height: 60px; width: 100px; text-align: center; }
#esope-search-results .elgg-image img { max-height: 60px; width: auto; text-align: center; }
#esope-search-results .elgg-image .fa { font-size:50px; margin-top: 10px; }

/* Showcase */
.kdb-featured { width:33%; float:left; border-right: 1px solid grey; }
.kdb-featured:last-child { border-right: 0; }
.kdb-featured-content { height:300px; overflow:auto; padding:15px; border:0px solid <?php echo $titlecolor; ?>; }
.kdb-featured-header { padding: 0 10px 10px 10px; text-align:center; }
.kdb-featured-header .image-block { height: 100px; margin-bottom: 1ex; }
.kdb-featured-header .image-block img { height: 100px; width:auto; }
.kdb-featured-header .image-block .fa { font-size: 80px; }

.knowledge_database-selectors div { display: inline-block; float: right; }
.knowledge_database-selectors div button { max-width: 20ex; }
.knowledge_database-selectors p { clear:both; font-size:0.8em; }


/* Edit form */

.knowledge_database-edit-field {}
.knowledge_database-edit-field input[type="text"] { width:30ex; }
.knowledge_database-field { border:1px solid grey; border-radius: 5px; padding: 0.5ex 1ex; }
.kdb-field-file { max-width:50%; }

/* Input / output rendering */
.knowledge_database-fieldset { margin: 1rem 0; padding: 1rem; border: 1px solid #CCC; }
.knowledge_database-fieldset legend { padding: 0 0.5rem; border: 1px solid #CCC; }

