
/* Edit form */
#transitions-post-edit select { max-width: 16em; }


/* Content category types */
.transitions-all { background-color:#000; padding:0.5ex 1ex; }
.transitions-knowledge { background-color:#66F; padding:0.5ex 1ex; }
.transitions-experience { background-color:#CAC; padding:0.5ex 1ex; }
.transitions-imaginary { background-color:#FAC; padding:0.5ex 1ex; }
.transitions-tools { background-color:#CA0; padding:0.5ex 1ex; }
.transitions-actor { background-color:#9F9; padding:0.5ex 1ex; }
.transitions-project { background-color:#AAF; padding:0.5ex 1ex; }
.transitions-event { background-color:#FC9; padding:0.5ex 1ex; }
.transitions-editorial { background-color:#AAA; padding:0.5ex 1ex; }

/* Search form */
.transitions-search-menu .elgg-button { margin:2px 4px; }


/* Full view */
.transitions_image.float { margin: 0 1em 0.5em 0; }


/* Gallery view */
#transitions .elgg-gallery .elgg-item { width:300px; }
.transitions-gallery-item { border: 0;margin: 0 1.5ex 2ex 0; padding: 0.5ex 1ex; }
.transitions-gallery-item .transitions-gallery-box { position:relative; }
.transitions-gallery-item .transitions_image { width: 100%; height:auto; border-radius:5px; }
.transitions-gallery-item .transitions_image img { width: 100%; height:auto; border-radius:5px; }
.transitions-gallery-item .transitions-gallery-hover { position:absolute; top:0; left:0; width: 100%; height:100%; /* display:none; background:rgba(255,255,255,0.8); text-align:center; */ }
.transitions-gallery-item:hover .transitions-gallery-hover { display:block; }
.transitions-gallery-item .transitions-category { position: absolute; top: 0; right: 0; }

.transitions-gallery-item .transitions-gallery-head { background: rgba(255,255,255,0.7); position: absolute; bottom: 3em; left: 0; padding: 0.2em 0.5em; }
.transitions-gallery-item .transitions-gallery-content { /* position: absolute; bottom: 3em; left: 0; background: rgba(255,255,255,0.8); padding: 0 0.5em; */ }
.transitions-gallery-item .transitions-gallery-actions { /* position: absolute; top: 0; left: 0; background: white; padding: 2px 4px; */ }
.transitions-gallery-item .transitions-gallery-actions { /* position: absolute; top: 0; left: 0; background: white; padding: 2px 4px; */ }


/* Responsive gallery grid */

@media (max-width: 1030px) {
	#transitions .elgg-gallery .elgg-item { width:33.3333333%; }
}

@media (max-width: 820px) {
	#transitions .elgg-gallery .elgg-item { width:50%; }
}

@media (min-width: 767px) {
}

@media (max-width: 766px) {
}

@media (max-width: 600px) {
	#transitions .elgg-gallery .elgg-item { width:100%; }
}


