
/* Edit form */
#transitions-post-edit select { max-width: 16em; }
.transitions-characters-remaining-warning { color: red; }
.transitions-characters-remaining-warning .hidden { display:block; }
.elgg-form-transitions-save fieldset fieldset { border: 1px solid #023824; padding: 2px 6px; margin: 20px 0 20px 0; }
.elgg-form-transitions-save legend { border: 1px solid #023824; padding: 0 3px; }
.transitions-edit-addlink-highlight { margin-bottom: 1ex; border:1px dashed grey; padding:0.5ex 1ex; height:5ex; }
.transitions-edit-contributed-link { margin-bottom: 1ex; border:1px solid grey; padding:0.5ex 1ex; }



/* Content category types */
/*
.elgg-list .transitions-category { margin: 0 0.5ex 0.5ex 0; }
.transitions-all { background-color:#000; padding: 1px 6px; color:white; }
.transitions-actor { background-color:#6299EB; padding: 1px 6px; color:white; }
.transitions-project { background-color:#A581DA; padding: 1px 6px; color:white; }
.transitions-experience { background-color:#E25C7C; padding: 1px 6px; color:white; }
.transitions-imaginary { background-color:#EB5656; padding: 1px 6px; color:white; }
.transitions-tools { background-color:#DFA615; padding: 1px 6px; color:white; }
.transitions-knowledge { background-color:#68C568; padding: 1px 6px; color:white; }
.transitions-event { background-color:#FD8400; padding: 1px 6px; color:white; }
.transitions-editorial { background-color:#AAA; padding: 1px 6px; color:white; }
.transitions-challenge { background-color:#000; padding: 1px 6px; color:white; }
*/
.transitions-all { background-color:#000; padding: 1px 6px; }
.transitions-actor { background-color:#75ab97; padding: 1px 6px; }
.transitions-project { background-color:#297256; padding: 1px 6px; }
.transitions-experience { background-color:#89bf4e; padding: 1px 6px; }
.transitions-imaginary { background-color:#023824; padding: 1px 6px; }
.transitions-tools { background-color:#359973; padding: 1px 6px; }
.transitions-knowledge { background-color:#20963e; padding: 1px 6px; }
.transitions-event { background-color:#abd660; padding: 1px 6px; }
.transitions-editorial { background-color:#abd660; padding: 1px 6px; }
.transitions-challenge { background-color:#12553b; padding: 1px 6px; }

.transitions-gallery-head { background: rgba(0,0,0,0.8); }
.transitions-category-all .transitions-gallery-head {  background-color:rgba(41,114,86,0.8); }
.transitions-category-actor .transitions-gallery-head {  background-color:rgba(117,171,151,0.8); }
.transitions-category-project .transitions-gallery-head {  background-color:rgba(41,114,86,0.8); }
.transitions-category-experience .transitions-gallery-head {  background-color:rgba(137,191,78,0.8); }
.transitions-category-imaginary .transitions-gallery-head {  background-color:rgba(2,56,36,0.8); }
.transitions-category-tools .transitions-gallery-head {  background-color:rgba(53,153,115,0.8); }
.transitions-category-knowledge .transitions-gallery-head {  background-color:rgba(32,150,62); }
.transitions-category-event .transitions-gallery-head {  background-color:rgba(171,214,96,0.8); }
.transitions-category-editorial .transitions-gallery-head {  background-color:rgba(21,99,37,0.8); }
.transitions-category-challenge .transitions-gallery-head {  background-color:rgba(18,85,59,0.8); }


/* Search form */
.transitions-search-menu { /* text-align: center; */ min-width:60%; }
.transitions-search-menu .elgg-button { margin:2px 4px; }
#transitions-search-home {  }
#transitions-search-home input { font-size: 2em; padding: 0.5em 0.5em; }
#transitions-search-home input[name=q] { max-width:80%; }
#transitions-search {  }
#transitions-search input{ max-width:20em; }


/* Full view */
.transitions_image.float { margin: 0 1em 0.5em 0; }
.transitions-contributed-links {  }
.transitions-contributed-links li { margin-bottom:10px; }


/* Gallery view */
.transitions-gallery .elgg-gallery { margin-right:-32px; }
.elgg-gallery .transitions-item { max-width:100%; }
.transitions-gallery .elgg-gallery .elgg-item { /* width:389px; */ }
.transitions-gallery-quickform { width:300px; float:left; }
.transitions-gallery-item { border: 0; margin: 0 32px 32px 0; padding: 0; }
.transitions-gallery-item .transitions-gallery-box { position:relative; width: 308px; height: 240px; background-size:cover; max-width: 100%; }
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
.transitions-gallery-item .transitions-gallery-head { position: absolute; top:0; bottom: 0; left: 0; right: 0; padding: 40px; max-height: 100%; overflow: hidden; color:white; /* text-shadow: 1px 1px black; */ font-size:14px; }
.transitions-gallery-item .transitions-gallery-head h3 { text-transform: uppercase; font-size: 18px; line-height: 1.3; }
.transitions-gallery-item .transitions-gallery-inner { padding: 10px; }
.transitions-gallery-item .transitions-gallery-head *, .transitions-gallery-item .transitions-gallery-head a, .transitions-gallery-item .transitions-gallery-head a:hover { color:white; }

.transitions-gallery-item .transitions-gallery-content .elgg-content { text-style:italic; font-size: 1.2em; }
.transitions-gallery-item .transitions-gallery-content { /* position: absolute; bottom: 3em; left: 0; background: rgba(255,255,255,0.8); padding: 0 0.5em; */ }
.transitions-gallery-item .transitions-gallery-actions { /* position: absolute; top: 0; left: 0; background: white; padding: 2px 4px; background: black; */ position: absolute; bottom: 0; left:0; right:0; font-size: 2em; }
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


