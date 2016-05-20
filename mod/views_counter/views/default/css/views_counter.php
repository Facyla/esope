<?php
	/**
	 * @file views/default/views_counter/css.php
	 * @brief Include the css of views_counter plugin on elgg system 
	 */
?>

.settings_column {
	width: 200px;
}

.reduced_text {
	font-size: 70%;
}

.views_counter_left_column {
	float: left;
	width: 49%;
	border-right: solid 1px #CCCCCC;
}

.views_counter_right_column {
	float: left;
	width: 49%;
	margin-left: 5px;
}

.guid_column {
	/* width: 35px; */
	width: auto;
	max-width: 20%;
	text-align: right;
}

.title_column {
	/* width: 190px; */
	width: auto;
	text-align: left;
	padding-left: 1em;
}

.counter_column {
	/* width: 100px; */
	width: auto;
	max-width: 20%;
	text-align: right;
	padding-right: 1em;
}

.id_column {
	width: 50px;
	border: solid 1px;
	text-align: center;
}

.name_column {
	width: 220px;
	border: solid 1px;
	text-align: center;
}

.user_name_column {
	width: 220px;
	border: solid 1px;
	text-align: center;
}

.views_column {
	width: 80px;
	border: solid 1px;
	text-align: center;
}

.first_view_column {
	width: 150px;
	border: solid 1px;
	text-align: center;
}

.float_left {
	float: left;
}

.float_right {
	float: right;
}

.views_counter {
	padding: 0 5px;
	margin: 5px;
	border: 1px solid #CCCCCC;
	-moz-border-radius: 8px;
	background-color: #FFFFFF;
}


.container_id_input {
	width: 175px;
}

.views_counter_admin_page table {
	width: 100%;
}

.views_counter_admin_page tr:hover {
	background-color: #EEE;
}


@media (max-width:700px) {
	.views_counter_left_column, .views_counter_right_column {
		float: none;
		width: 49%;
		border: 0
	}
}
