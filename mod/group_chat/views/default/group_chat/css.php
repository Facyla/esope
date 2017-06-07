/* Chat layout and main styles */

#page-wrap { width: 333px; margin: 0px auto; background-color:#FFFFFF; float:right}
#chat-wrap { margin:0; }
#chat-area { height: 280px; overflow: auto; padding: 0 10px 10px 10px; background: white; }
#chat-area span { color: #D6D6D6; margin: 18px 5px 0 0; background-color:#FFFFFF; font-family: "Lucida Grande", Sans-Serif; min-width:60px; font-size:11px; }
#chat-area p { padding: 1px 0; border-bottom: 1px solid #ccc; margin:4px; }


#name-area { position: absolute; top: 12px; right: 0; color: white; font: 11px  "Lucida Grande", Sans-Serif; text-align: right; }   
#name-area span { color: #fa9f00; }

/* Message editor */
#send-message-area p { float: left; color: white; padding-top: 27px; font-size: 14px; }
#sendie { padding: 6px; font: 11px "Lucida Grande", Sans-Serif; float:right;  height:70px; border-radius:0px;  border:1px solid #FFFFFF; }

.clearfloat textarea {height:70px; width:710px; }
#chat-wrap ol { margin: 0; }
.timeChat { /* border:1px solid #FF0000; display:none; */ }
/*.chatTime { position:absolute; display:block; background-color:white; }*/
.outSide {
	width:330px; 
	border:1px solid #CCCCCC; 
	border-bottom:0; 
	/*float:right;*/
	padding-top: 10px;
	background-color:#FFFFFF;
}

#groups-tools > li:nth-child(2n+1) { margin-right: 2%; }
#groups-tools li { margin-left:5px; }

.chatTxt, .group_chat-text { clear:both; margin-top:5px; font-size: 12px; border-top:1px solid #F7F7F7; }

.padTop5 { padding-top:5px; }

.clear { clear:both; }
.floatLeft { float:left; }
.floatRight { float:right; }
.txtDiv { text-align:justify; width:254px; margin-left:5px }
.clr6 { color:#666666; }

.chatTime {
	/*position:absolute; */
	float:right;
	padding-left:245px;
	height:0px;
	font-size:9px; color:#CCCCCC;
	display:none;
}

#groupTitleChat {
	width:325px; height:25px; padding:5px 0px 0px 5px;
	border:1px solid #CCCCCC; border-bottom:0;
	background-color:#F7F7F7; font-weight:bold;
}
.padRht10 { padding-right:10px; }
.cursor { cursor:pointer; }

#groupchat-container { bottom: 0px; right:0px; display: none; position: fixed; }

.maxMize { display:none; }

.sendieDiv { width:330px; border:1px solid #CCCCCC; }
.smileyMain { padding-top:13px; padding-right: 9px; }
#smileyGroup {
	display:none;
	position:absolute; bottom:0px; right:0px;
	background-color:#FFFFFF;
}

.pad5 { padding-right:5px; }

.smileyCon { }

.smileyCon:hover { cursor:pointer; }
.closeIcon {
	/* font-size:10px; */
	text-decoration:none;
	cursor:pointer;
}

.dateD {
	background-color:#FBFBFB;
	color:#333333;
	font-size:9px;
	font-family: "Lucida Grande", Sans-Serif;
	text-align:right;
}
.joinGroup {
	font: 11px  "Lucida Grande", Sans-Serif; 
	text-align: right;
	height:35px;
	padding:7px 0px 0px 12px;
	color:#666;
}


/* Site chat styles */
.site-outSide { border-top:1px solid #CCCCCC; background-color:#FFFFFF; }
.site-sendieDiv { border-top:1px solid #CCCCCC; position:absolute; width:98%; bottom:2px; margin: 0 auto; }
#sitechat-compose { width:90%; }
#sitechat-helpers { float:right; width:10%; text-align:right; }
#sitechat-page-wrap #sendie { width:100%; }
#sitechat-page-wrap #smileyGroup { clear:both; width:100%; /* position:relative; */ box-shadow: 1px 1px 3px 1px; padding: 1ex 0; }
#sitechat-page-wrap #chat-area  { height: auto; position: fixed; top: 20px; bottom: 80px; left: 0; right: 0; }

/* Site chat button */
#groupchat-sitelink { position:fixed; right:0; top: 3px; background:white; border: 1px solid black; border-radius: 10px; padding: 4px 16px 4px 6px; margin-right: -10px; width: 16px; height:14px; box-shadow:0 0 3px 0 white; overflow:hidden; vertical-align: top; z-index:111; }
#groupchat-sitelink:hover, #groupchat-sitelink:focus, #groupchat-sitelink:active { width:auto; }



/* Group chat styles */
/* Group chat button */
#groupchat-grouplink { position:fixed; right:0; bottom: 2rem; background:#EAEAFF; border: 1px solid #9999FF; border-radius: 10px; padding: 4px 16px 4px 6px; margin-right: -10px; width: 16px; height:14px; box-shadow:0 0 3px 0 #9999FF; overflow:hidden; vertical-align: top; z-index:111; }
#groupchat-grouplink:hover, #groupchat-grouplink:focus, #groupchat-grouplink:active { width:auto; }

#groupchat-grouplink.chat-active { bottom: 20px; border: 1px solid #000099; box-shadow:0 0 20px 0 #000099;  }



/* Notifications */
#group_chat-notification { position: fixed; z-index:101; position: fixed; bottom: 0; left: 0; }
#group_chat-notification .elgg-message { border-radius: 0; }
#group_chat-notification-content { font-weight:normal; }
#group_chat-notification-content a {  }
.group-chat-notification { display: block; background: white; color: #333; padding: 1.5ex 2.5ex; border-top: 1px solid black; border-right: 1px solid black; }
.group-chat-notification:hover, .group-chat-notification:active, .group-chat-notification:focus { text-decoration:none; color:black; font-weight:bold; background:#DEDEDE; transition-duration:0.5s; }


.group_chat-notification-alert {
	float: right; z-index: 102; margin: -1ex -1.5ex 1ex 1.5ex;
	font-size: 5ex; color: gold; text-shadow: 2px 2px 3px black;
	padding: 5px 10px; /* background: rgba(0,0,0,0.8); */ border-radius: 5ex;
}


/* Replace old classes and hardcoded styles with more cleaner and integrated ones */
.chat-title { background: black; color: white; font-size: 10px; height: 18px; padding: 3px 5px; overflow:hidden; text-transform: uppercase; }
.chat-title a { color: white; }
.group_chat-text { clear:both; margin-top:5px; font-size: 12px; border-top:1px solid #F7F7F7; padding-top:5px; color:white; }
.group_chat-text:hover { color:#CCCCCC; }
.group_chat-time { font-size:9px; float: right; }
.group_chat-image { float:left; margin-right:5px; margin-bottom:1px; }
#chat-area .group_chat-message { color:#666666; }
#smileyGroup img { line-height:20px; margin-left:5px; }




/* group_chat-blinking effect - http://visualidiot.com/files/real-world.css */
.group_chat-blink {
	-webkit-animation: group_chat-blink .75s linear infinite alternate;
	-moz-animation: group_chat-blink .75s linear infinite;
	-ms-animation: group_chat-blink .75s linear infinite;
	-o-animation: group_chat-blink .75s linear infinite;
	animation: group_chat-blink .75s linear infinite alternate;
}
@-webkit-keyframes group_chat-blink {
	0% { opacity: 1; }
	100% { opacity: 0.5; }
}
@-moz-keyframes group_chat-blink {
	0% { opacity: 1; }
	100% { opacity: 0.5; }
}
@-ms-keyframes group_chat-blink {
	0% { opacity: 1; }
	100% { opacity: 0.5; }
}
@-o-keyframes group_chat-blink {
	0% { opacity: 1; }
	100% { opacity: 0.5; }
}
@keyframes group_chat-blink {
	0% { opacity: 1; }
	100% { opacity: 0.5; }
}


/* Wobble effect - http://visualidiot.com/files/real-world.css */
.group_chat-wobble {
	position: relative;
	display: inline-block;
	-webkit-animation: group_chat-wobble .75s linear infinite;
	-moz-animation: group_chat-wobble .75s linear infinite;
	-ms-animation: group_chat-wobble .75s linear infinite;
	-o-animation: group_chat-wobble .75s linear infinite;
	animation: group_chat-wobble .75s linear infinite;
}

@-webkit-keyframes group_chat-wobble {
	0% { -webkit-transform: rotate(-2deg); }
	20% { -webkit-transform: rotate(4deg); }
	30% { -webkit-transform: rotate(1deg); }
	40% { -webkit-transform: rotate(3deg); }
	55% { -webkit-transform: rotate(0deg); }
	70% { -webkit-transform: rotate(-4deg); }
	80% { -webkit-transform: rotate(2deg); }
	90% { -webkit-transform: rotate(-2deg); }
	90% { -webkit-transform: rotate(3deg); }
}
@-moz-keyframes group_chat-wobble {
	0% { -moz-transform: rotate(-2deg); }
	20% { -moz-transform: rotate(4deg); }
	30% { -moz-transform: rotate(1deg); }
	40% { -moz-transform: rotate(3deg); }
	55% { -moz-transform: rotate(0deg); }
	70% { -moz-transform: rotate(-4deg); }
	80% { -moz-transform: rotate(2deg); }
	90% { -moz-transform: rotate(-2deg); }
	90% { -moz-transform: rotate(3deg); }
}
@-ms-keyframes group_chat-wobble {
	0% { -ms-transform: rotate(-2deg); }
	20% { -ms-transform: rotate(4deg); }
	30% { -ms-transform: rotate(1deg); }
	40% { -ms-transform: rotate(3deg); }
	55% { -ms-transform: rotate(0deg); }
	70% { -ms-transform: rotate(-4deg); }
	80% { -ms-transform: rotate(2deg); }
	90% { -ms-transform: rotate(-2deg); }
	90% { -ms-transform: rotate(3deg); }
}
@-o-keyframes group_chat-wobble {
	0% { -o-transform: rotate(-2deg); }
	20% { -o-transform: rotate(4deg); }
	30% { -o-transform: rotate(1deg); }
	40% { -o-transform: rotate(3deg); }
	55% { -o-transform: rotate(0deg); }
	70% { -o-transform: rotate(-4deg); }
	80% { -o-transform: rotate(2deg); }
	90% { -o-transform: rotate(-2deg); }
	90% { -o-transform: rotate(3deg); }
}
@keyframes group_chat-wobble {
	0% { transform: rotate(-2deg); }
	20% { transform: rotate(4deg); }
	30% { transform: rotate(1deg); }
	40% { transform: rotate(3deg); }
	55% { transform: rotate(0deg); }
	70% { transform: rotate(-4deg); }
	80% { transform: rotate(2deg); }
	90% { transform: rotate(-2deg); }
	90% { transform: rotate(3deg); }
}


