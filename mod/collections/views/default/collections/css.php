<?php
/* Note : Custom CSS are dynamically loaded, as they should NOT rely on cache (this would break per-view settings)
 * This view can be cached
*/

$imgroot = elgg_get_site_url() . 'mod/collections/graphics/';

?>


/* Main plugin styles (editor) */
.collection-edit-entity, .collection-edit-highlight { margin-top: 0.5ex; min-height:2ex; border:1px solid #ccc; padding:0ex 1ex 1ex 1ex; border-radius: 6px; background: rgba(0,0,0,0.05); height: 17em; width: 20em; float: left; margin: 0 10px 20px 0; overflow: auto; }
.collection-edit-highlight { border:1px dashed grey; color:#333; }
.elgg-button-collection-select { background: #999; padding: 2px 6px; margin: 2px 6px 2px 0; }
.collection-edit-entity blockquote { padding: 5px; background-color: white; }


/* Index */
.collections-index .elgg-head { padding: 0; margin: 0; border: 0; }
.collection_image.float { margin: 0 1em 0.5em 0; }
.elgg-item-object-collection .collection_image img { max-height: 260px; }
.elgg-item-object-collection .elgg-image { margin-right: 30px }
.elgg-item-object-collection .elgg-content { margin: 20px 0; }
.elgg-list.elgg-list-collections { background: none; padding: 0; margin: 0; }
.elgg-list.elgg-list-collections .elgg-image-block { background: white; padding: 0; }
.elgg-list.elgg-list-collections .elgg-body { padding: 40px 25px 20px 0; }
.elgg-list.elgg-list-collections .elgg-item { margin:0 0 40px 0; }


/* View */
.collections-view .elgg-head { margin-bottom:0; }
.collections-view-wrapper { background:white; }
.collections-view .elgg-content {  }
.collections-view-wrapper .elgg-menu-entity { margin: 5px 10px 0 0; }
#collections-action-tabs.elgg-tabs li { border:0; background: white; text-transform: uppercase; margin: 0 5px 0 0; }
#collections-action-tabs.elgg-tabs a { padding: 10px 20px; }
#collections-action-tabs.elgg-tabs .elgg-state-selected { border:0; }
#collections-action-tabs.elgg-tabs .elgg-state-selected a { background: #e2d8c3; }
.collections-view .elgg-tabs-content { border:0; padding:20px; background: #e2d8c3; }
.collections-view .elgg-image-block { padding: 0; }
.collections-view .elgg-image-block .elgg-image { margin-right: 30px; }
.collections-view .elgg-image-block .elgg-image-alt { margin: 30px; }
.collections-view .elgg-image-block .elgg-body { padding: 30px 0 30px 0; }


/* Rendu des collections */
.collections-listing { list-style-type:none; margin-right: -30px; }
.collections-item-entity { float: left; width: 310px; max-width:100%; height: 330px; overflow: hidden; }
.collections-item-entity .transitions-gallery-item { margin:0 0 0 0; }
.collections-item-entity .transitions-gallery-item .transitions-gallery-head { padding:24px; }
.collections-listing .collections-item-entity { /* box-shadow: 1px 1px 1px 1px black; padding: 1em; margin: 0.5em; */ padding:0; margin: 0 30px 30px 0; display: inline-block; }
.collections-listing .collections-item-entity blockquote { margin-bottom: 0; border-radius: 0 0 3px 3px; }

.collections-socialshare { font-size:3em; padding-bottom:0.5em; }
.collections-socialshare a { margin-right:0.3em; }


