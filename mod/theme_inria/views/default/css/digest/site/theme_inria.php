
body {
	background: none repeat scroll 0 0 #FFFFFF;
	color: #333333;
	font: 80%/1.4 "Lucida Grande",Arial,Tahoma,Verdana,sans-serif;
	word-wrap: break-word;
	-moz-hyphens: auto;
	-webkit-hyphens: auto;
	-ms-hyphens: auto;
	-o-hyphens: auto;
	hyphens: auto;
}
a {
	color: #1488CA;
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
	 color: #1488CA;
}
img {
	border: medium none;
}
h1, h2, h3, h4 {
	color: #384257;
	margin: 0;
}
h1 {
	font-size: 18px;
}
h2 {
	font-size: 16px;
}
h3 {
	font-size: 16px;
}
h4 {
	font-size: 14px;
}
#digest_online {
	color: #384257;
	font-size: 11px;
	padding: 10px 20px 0;
	text-align: right;
	width: 700px;
	margin: 0 auto;
}
#digest_online a {
	color: #1488CA;
	font-size: 11px;
	/* padding: 10px 20px 0; */
	text-align: right;
	text-decoration:underline;
}
#digest_header {
	background: none repeat scroll 0 0 #384257;
	border-color: #384257;
	border-radius: 5px 5px 0 0;
	border-style: solid;
	border-width: 1px;
	min-height: 10px;
	padding: 0px 30px 10px 30px;
}
#digest_header h1 {
	color: #FFFFFF;
	font-size: 36px;
}
#digest_container {
	margin: 0 auto;
	padding: 20px 0;
	width: 700px;
	max-width: 100%;
}
#digest_content {
	min-height: 100px;
}

.digest-groups .table-item { float:left; width:120px; min-height:170px; text-align: center; margin: 6px 10px 10px 0px; line-height: 1; font-size:12px; flex: 1 0 auto; font-size: 12px; padding: 0; }
.digest-profile .table-item { float:left; width:120px; min-height:170px; text-align: center; margin: 6px 10px 10px 0px; line-height: 1; font-size:12px; flex: 1 0 auto; font-size: 12px; padding: 0; }
.digest-groups img, .digest-groups img { margin-bottom: 3px; }

#digest_unsubscribe {
	color: #384257 !important;
	font-size: 11px;
	padding: 20px;
}
#digest_unsubscribe a {
	color: #1488CA;
	text-decoration: underline;
	font-size: 11px;
	/* padding: 20px; */
}
#digest_footer {
	background: none repeat scroll 0 0 #FFFFFF;
	border-color: #FFFFFF #DBDBDB #DBDBDB;
	border-radius: 0 0 5px 5px;
	border-style: solid;
	border-width: 1px;
	padding: 3px 6px;
}
.digest-footer-quote {
	color: #AFAFAF;
	font-size: 20px;
	text-align: center;
}
.digest-footer-quote table {
	width: 100%;
}
.digest-footer-quote-left {
	padding-right: 20px;
	vertical-align: top;
}
.digest-footer-quote-right {
	padding-left: 20px;
	vertical-align: bottom;
}
.elgg-module-digest {
	background: none repeat scroll 0 0 #FFFFFF;
	border-color: #FFFFFF #DBDBDB #DBDBDB;
	border-style: solid;
	border-width: 1px;
	padding: 10px;
}
.elgg-module-digest .elgg-head {
	border-bottom: 1px solid #DBDBDB;
	padding-bottom: 5px;
}
.elgg-module-digest h1 a, .elgg-module-digest h2 a, .elgg-module-digest h3 a {
	text-decoration: none;
	color: #384257;
}
.elgg-avatar {
	display: inline-block;
	position: relative;
}
.elgg-avatar > a > img {
	display: block;
	border-radius: 50%;
}
.elgg-avatar-tiny > a > img {
	background-size: 25px auto;
	border-radius: 3px;
	height: 25px;
	width: 25px;
}
.elgg-avatar-small > a > img {
	background-size: 40px auto;
	border-radius: 5px;
	height: 40px;
	width: 40px;
}
.elgg-avatar-medium > a > img {
	height: 100px;
	width: 100px;
}
.elgg-avatar-large > a > img {
	height: 200px;
	width: 200px;
}

.elgg-avatar.elgg-avatar-large img, 
.elgg-avatar.elgg-avatar-medium img { border: 3px solid transparent; padding: 3px; }
.elgg-avatar.elgg-avatar-large.profile-type-external img, 
.elgg-avatar.elgg-avatar-medium.profile-type-external img { border: 3px solid #F7A621; }

.iris-badge-external {
	text-transform: uppercase;
	font-family: "Inria Sans", sans-serif;
	border-radius: 1rem;
	font-weight: bold;
	margin: 0rem 0rem 0rem 1rem;
	vertical-align: top;
	color: white;
	background-color: #F7A621;
	font-size: 0.75rem;
	padding: 0.3rem 0.5rem 0.2rem 0.5rem;
	display: inline-block;
	margin-top: 0.5rem;
}

.elgg-icon {
	background: url("<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png") no-repeat scroll left center transparent;
	height: 16px;
	margin: 0 2px;
	width: 16px;
}
.elgg-icon-arrow-right {
	background-position: 0 -18px;
}
.elgg-list {
	list-style: none outside none;
}
.clearfix:after, .elgg-inner:after, .elgg-head:after, .elgg-foot:after, .elgg-image-block:after {
	clear: both;
	content: ".";
	display: block;
	height: 0;
	visibility: hidden;
}
.elgg-body {
	display: block;
	overflow: hidden;
	width: auto;
	word-wrap: break-word;
}
.elgg-river {
	margin: 0;
	padding: 0;
}
.elgg-river-item .elgg-image {
	float: left;
	margin-right: 5px;
}
.elgg-list-river > li {
	border-bottom: 1px solid #CCCCCC;
	min-height: 55px;
}
.elgg-river-item {
	padding: 7px 0;
}
.elgg-river-item .elgg-pict {
	margin-right: 20px;
}
.elgg-river-timestamp {
	color: #666666;
	font-size: 85%;
	font-style: italic;
	line-height: 1.2em;
}
.elgg-river-attachments, .elgg-river-message, .elgg-river-content {
	border-left: 1px solid #CCCCCC;
	font-size: 85%;
	line-height: 1.5em;
	margin: 8px 0 5px;
	padding-left: 5px;
}
.elgg-river-attachments .elgg-avatar, .elgg-river-attachments .elgg-icon {
	float: left;
}
.digest-blog {
	display: inline-block;
	padding: 10px 0;
	width: 100%;
}
.digest-blog img {
	float: left;
	padding: 5px 15px 0 0;
}
.digest-blog h4 {
	padding-bottom: 5px;
}
.digest-blog h4 a {
	text-decoration: none;
	color: #384257;
}
.digest-groups {
	border-collapse: collapse;
	width: 100%;
	display: flex;
	flex-wrap: wrap;
}
.digest-groups td {
	padding: 10px;
	text-align: center;
	vertical-align: top;
	width: 33%;
}
.digest-groups tr {
	border-bottom: 1px dotted #DBDBDB;
}
.digest-profile {
	border-collapse: collapse;
	width: 100%;
	/*
	display: flex;
	flex-wrap: wrap;
	*/
}
.digest-profile td {
	padding: 10px;
	text-align: center;
	vertical-align: top;
	width: 33%;
}
.digest-groups .table-item a {
	color: #384257;
	font-weight: bold;
	font-size: 0.75rem;
	padding: 0rem;
	display: block;
}
.group-oldactivity {
	display: block;
}
.digest-profile .table-item a {
	color: #384257;
	font-weight: bold;
	font-size: 0.75rem;
	padding: 0rem;
	display: block;
}
.digest-profile tr {
	border-bottom: 1px dotted #DBDBDB;
}

#digest_container div #digest_content .elgg-module.elgg-module-digest .elgg-body .elgg-output p {
	font-weight: bold;
}

/* Hide subgroup text */
/* .au_subgroup.au_subgroup_icon-medium { display: none; } */
.au_subgroup {
	color: #969696;
	text-transform: uppercase;
	font-size: 0.6rem;
	display: block;
}


