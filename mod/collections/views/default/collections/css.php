<?php
/* Note : Custom CSS are dynamically loaded, as they should NOT rely on cache (this would break per-view settings)
 * This view can be cached
*/

$imgroot = elgg_get_site_url() . 'mod/collections/graphics/';

?>


/* Main plugin styles (editor) */
.collection-edit-entity { margin-top: 0.5ex; min-height:2ex; border:1px solid #ccc; padding:0ex 1ex 1ex 1ex; border-radius: 6px; background: rgba(0,0,0,0.05); height: 17em; width: 20em; float: left; margin: 0 10px 20px 0; overflow: auto; }
.collection-edit-highlight { margin-bottom: 1ex; border:1px dashed grey; padding:0.5ex 1ex; height: 17em; width: 20em; float: left; margin: 0 10px 20px 0; }
.elgg-button-collection-select { background: #999; padding: 2px 6px; margin: 2px 6px 2px 0; }


/* Index */
.collection_image.float { margin: 0 1em 0.5em 0; }
.elgg-item-object-collection .collection_image img { max-height: 260px; }
.elgg-item-object-collection .elgg-image { margin-right: 30px }
.elgg-item-object-collection .elgg-content { margin: 20px 0; }
.elgg-list.elgg-list-collections { background: none; padding: 0; margin: 0; }
.elgg-list.elgg-list-collections .elgg-image-block { background: white; padding: 0; }
.elgg-list.elgg-list-collections .elgg-body { padding: 40px 25px 20px 0; }
.elgg-list.elgg-list-collections .elgg-item { margin:0 0 40px 0; }


/* View */
.collections-view .elgg-content.clearfix { background: white; }
.collections-view .elgg-tabs li { border:0; background: white; text-transform: uppercase; margin: 0 5px 0 0; }
.collections-view .elgg-tabs a { padding: 10px 20px; }
.collections-view .elgg-tabs .elgg-state-selected { border:0; }
.collections-view .elgg-tabs .elgg-state-selected a { background: #e2d8c3; }
.collections-view .elgg-tabs-content { border:0; padding:20px; background: #e2d8c3; }


/* Rendu des collections */
.collections-listing { list-style-type:none; }
.collections-item-entity { float: left; height: 350px; }
ul.collections-listing > li, .collections-listing .collections-item-entity { /* box-shadow: 1px 1px 1px 1px black; padding: 1em; margin: 0.5em; */ padding:0; margin: 0 40px 40px; display: inline-block; }

.collections-socialshare { font-size:3em; padding-bottom:0.5em; }
.collections-socialshare a { margin-right:0.3em; }


