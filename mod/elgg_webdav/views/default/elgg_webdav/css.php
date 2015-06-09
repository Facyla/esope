
/* Main blocks */

.elgg-webdav nav {
	padding: 5px;
}

.elgg-webdav .actions, 
.elgg-webdav .properties {
	border-top:1px solid;
	margin-top:6ex;
	padding-top: 2ex;
}



/* Buttons */

.elgg-webdav .btn, 
.elgg-webdav button, 
.elgg-webdav input[type=submit] {
  display: inline-block;
  color: white;
  background: #4fa3ac;
  padding: 9px 15px;
  border-radius: 2px;
  border: 0;
  text-decoration: none;
}
.elgg-webdav a.btn:visited {
	color: white;
}

.elgg-webdav .btn.disabled {
  background: #eeeeee;
  color: #bbbbbb;
}



/* Generic styles */

.elgg-webdav hr {
  border: none;
  border-top: 1px dashed;
  margin-top: 30px;
  margin-bottom: 30px;
}



/* Forms */

.elgg-webdav fieldset {
  border: 1px solid;
  margin: 1ex 0 3ex;
  padding: 1ex;
}

.elgg-webdav legend {
  border: 1px solid;
  padding: 0.5ex 1ex;
}

.elgg-webdav input[type=text] {
  border: 1px solid #bbbbbb;
  line-height: 22px;
  padding: 5px 10px;
  border-radius: 3px;
}

.elgg-webdav .actions label {
	display: inline-block;
	line-height: 40px;
}

.elgg-webdav .actions input[type=text] {
	width: 450px;
	max-width:100%;
}
.elgg-webdav .actions input[type=file] {
	width: 450px;
	max-width:100%;
}

.elgg-webdav .actions input[type=submit] {
	display: inline-block;
	width:auto;
}



/* Tables */

.elgg-webdav table {
  border-collapse: collapse;
  border-spacing: 0;
  width:100%;
}
.elgg-webdav td,
.elgg-webdav th {
  padding: 0;
}

.elgg-webdav .nodeTable tr {
	border-bottom: 3px solid white;
}

.elgg-webdav .nodeTable td {
	padding: 10px 10px 10px 10px;
}

.elgg-webdav .nodeTable a {
	text-decoration: none;
}

.elgg-webdav .nodeTable .nameColumn {
  font-weight: bold;
  padding: 10px 20px;
  background: #ebf5f6;
  min-width: 200px;
}
.elgg-webdav .nodeTable .oi {
  color: #b10610;
}

.elgg-webdav .propTable tr {
	height: 40px;
}

.elgg-webdav .propTable th {
  background: #f6f6f6;
  padding: 0 10px;
  text-align: left;
}

.elgg-webdav .propTable td {
  padding: 0 10px;
  background: #eeeeee;
}




/* Tree */

.elgg-webdav ul.tree {
	list-style: none;
	margin: 0;
	padding: 0;
}

.elgg-webdav ul.tree ul {
	list-style: none;
	padding-left: 10px;
	border-left: 4px solid #ccc;
}

