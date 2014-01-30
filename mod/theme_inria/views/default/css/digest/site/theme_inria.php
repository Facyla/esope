<?php
global $CONFIG;
?>

body {
    background: none repeat scroll 0 0 #6D2D4F;
    color: #333333;
    font: 80%/1.4 "Lucida Grande",Arial,Tahoma,Verdana,sans-serif;
}
a {
    color: #6D2D4F;
    text-decoration: none;
}
a:hover {
	text-decoration: underline;
	 color: #6D2D4F;
}
img {
    border: medium none;
}
h1, h2, h3, h4 {
   	color: #EF783E;
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
#digest_online a {
    color: #FFFFFF;
    font-size: 11px;
    /* padding: 10px 20px 0; */
    text-align: right;
}
#digest_online {
    color: #FFFFFF;
    font-size: 11px;
    padding: 10px 20px 0;
    text-align: right;
}
#digest_header {
    background: none repeat scroll 0 0 #6D2D4F;
    border-color: #6D2D4F;
    border-radius: 5px 5px 0 0;
    border-style: solid;
    border-width: 1px;
    min-height: 10px;
    padding: 10px 30px;
}
#digest_header h1 {
	color: #FFFFFF;
	font-size: 36px;
}
#digest_container {
    margin: 0 auto;
    padding: 20px 0;
    width: 700px;
}
#digest_content {
    min-height: 100px;
}
#digest_unsubscribe {
    color: #FFFFFF;d
    font-size: 11px;
    padding: 20px;
}
#digest_unsubscribe a {
    color: #FFFFFF;d
    font-size: 11px;
    /* padding: 20px; */
}
#digest_footer {
    background: none repeat scroll 0 0 #FFFFFF;
    border-color: #FFFFFF #DBDBDB #DBDBDB;
    border-radius: 0 0 5px 5px;
    border-style: solid;
    border-width: 1px;
    padding: 30px;
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
	color: #EF783E;
}
.elgg-avatar {
    display: inline-block;
    position: relative;
}
.elgg-avatar > a > img {
    display: block;
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
.elgg-icon {
    background: url("<?php echo $CONFIG->url; ?>_graphics/elgg_sprites.png") no-repeat scroll left center transparent;
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
	color: #6D2D4F;
}
.digest-groups {
    border-collapse: collapse;
    width: 100%;
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
}
.digest-profile td {
    padding: 10px;
    text-align: center;
    vertical-align: top;
    width: 33%;
}
.digest-profile tr {
    border-bottom: 1px dotted #DBDBDB;
}

#digest_container div #digest_content .elgg-module.elgg-module-digest .elgg-body .elgg-output p {
	font-weight: bold;
}

/* Hide subgroup text */
.au_subgroup.au_subgroup_icon-medium { display: none; }


