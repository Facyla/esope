
/* Edit form */
#transitions-post-edit select { max-width: 16em; }
.transitions-characters-remaining-warning { color: red; }
.transitions-characters-remaining-warning .hidden { display:block; }


/* Content category types */
.elgg-list .transitions-category { margin: 0 0.5ex 0.5ex 0; }
.transitions-all { background-color:#000; padding:0.5ex 1ex; }
.transitions-actor { background-color:#6299EB; padding:0.5ex 1ex; }
.transitions-project { background-color:#A581DA; padding:0.5ex 1ex; }
.transitions-experience { background-color:#E25C7C; padding:0.5ex 1ex; }
.transitions-imaginary { background-color:#EB5656; padding:0.5ex 1ex; }
.transitions-tools { background-color:#DFA615; padding:0.5ex 1ex; }
.transitions-knowledge { background-color:#68C568; padding:0.5ex 1ex; }
.transitions-event { background-color:#FD8400; padding:0.5ex 1ex; }
.transitions-editorial { background-color:#AAA; padding:0.5ex 1ex; }
.transitions-challenge { background-color:#000; padding:0.5ex 1ex; }

/* Search form */
.transitions-search-menu { /* text-align: center; */ min-width:60%; }
.transitions-search-menu .elgg-button { margin:2px 4px; }
#transitions-search-home {  }
#transitions-search-home input { font-size: 2em; padding: 0.5em 0.5em; }
#transitions-search-home input[name=q] { max-width:80%; }
#transitions-search{  }
#transitions-search input{ max-width:20em; }


/* Full view */
.transitions_image.float { margin: 0 1em 0.5em 0; }


/* Gallery view */
#transitions .elgg-gallery .elgg-item { width:300px; }
.transitions-gallery-quickform { width:300px; float:left; }
.transitions-gallery-item { border: 0;margin: 0 1.5ex 2ex 0; padding: 0.5ex 1ex; }
.transitions-gallery-item .transitions-gallery-box { position:relative; }
.transitions-gallery-item .transitions_image { width: 100%; height:auto; border-radius:5px; }
.transitions-gallery-item .transitions_image img { width: 100%; height:auto; border-radius:5px; }
.transitions-gallery-item .transitions-gallery-hover { position:absolute; top:0; left:0; width: 100%; height:100%; /* display:none; background:rgba(255,255,255,0.8); text-align:center; */ border-radius:5px; }
.transitions-gallery-item:hover .transitions-gallery-hover { display:block; }
/*
.transitions-gallery-item .transitions-category { position: absolute; top: 0; right: 0; color: white; }
*/
.transitions-gallery-item .transitions-category { float:right; margin: -6px -10px 2px 4px; color: white; }

/*
.transitions-gallery-item .transitions-gallery-head { background: rgba(255,255,255,0.7); position: absolute; top: 30%; left: 0; right: 0; box-shadow: 0 0 4px 0 white; padding: 0.2em 0.5em; max-height: 60%; overflow: hidden; }
*/
.transitions-gallery-item .transitions-gallery-head { background: rgba(0,0,0,0.5); position: absolute; top:0; bottom: 0; left: 0; right: 0; padding: 0; max-height: 100%; overflow: hidden; color:white; text-shadow: 1px 1px black; }
.transitions-gallery-item .transitions-gallery-inner { padding: 6px 10px; }
.transitions-gallery-item .transitions-gallery-head *, .transitions-gallery-item .transitions-gallery-head a, .transitions-gallery-item .transitions-gallery-head a:hover { color:white; }

.transitions-gallery-item .transitions-gallery-content .elgg-content { text-style:italic; font-size: 1.2em; }
.transitions-gallery-item .transitions-gallery-content { /* position: absolute; bottom: 3em; left: 0; background: rgba(255,255,255,0.8); padding: 0 0.5em; */ }
.transitions-gallery-item .transitions-gallery-actions { /* position: absolute; top: 0; left: 0; background: white; padding: 2px 4px; */ position: absolute; bottom: 0; left:0; right:0; background: black; font-size: 1.1em; }
.transitions-gallery-actions a { margin-left: 1em; }
.transitions-socialshare { font-size:3em; padding-bottom:0.5em; }
.transitions-socialshare a { margin-right:0.3em; }


/* Popups */
.transitions-popup-link, .transitions-popup-embed { max-width:30em; }
.transitions-popup-link textarea { min-height:3em; }
.transitions-popup-embed textarea { min-height:7em; }
.transitions-popup-share { width: 500px; margin: 0 auto; }
.transitions-popup-share textarea { height:3em; word-break: break-all; }



/* Responsive gallery grid */

@media (max-width: 1030px) {
	#transitions .elgg-gallery .elgg-item { width:33.3333333%; }
}

@media (max-width: 820px) {
	#transitions .elgg-gallery .elgg-item { width:50%; }
}

@media (min-width: 767px) {
	.transitions-popup-share { width: 400px; }
}

@media (max-width: 766px) {
}

@media (max-width: 600px) {
	#transitions .elgg-gallery .elgg-item { width:100%; }
	.transitions-popup-share { width: 80%; }
}


