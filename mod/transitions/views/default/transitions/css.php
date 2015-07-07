



#transitions .elgg-gallery .elgg-item { width:300px; }
.transitions-gallery-item { border: 1px solid black; border: 1px solid black; margin: 0 1.5ex 2ex 0; box-shadow: 1px 1px 1px #999; padding: 0.5ex 1ex; }
.transitions-gallery-item .transitions-gallery-box { position:relative; }
.transitions-gallery-item .transitions_image { width: 100%; height:auto; border-radius:5px; }
.transitions-gallery-item .transitions_image img { width: 100%; height:auto; border-radius:5px; }
.transitions-gallery-item .transitions-gallery-hover { position:absolute; top:0; left:0; width: 100%; height:100%; display:none; background:rgba(255,255,255,0.8); text-align:center; }
.transitions-gallery-item:hover .transitions-gallery-hover { display:block; }


/* Responsive gallery grid */
@media screen and (max-width:1200px) {
	#transitions .elgg-gallery .elgg-item { width:33.3333333%; }
}

@media screen and (max-width:800px) {
	#transitions .elgg-gallery .elgg-item { width:50%; }
}

@media screen and (max-width:500px) {
	#transitions .elgg-gallery .elgg-item { width:100%; }
}


