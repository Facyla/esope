<?php
	$entity = $vars['entity'];
	$form_body = '<label>'.elgg_echo('microthemes:title').'</label>';
	$values = array();
	$assign_to = get_input('assign_to');
	$opt_values = array();
	if ($entity) {
		$form_body .= elgg_view("input/hidden", array(
                        'internalname' => 'entity_guid',
			'value' => $entity->getGUID()));
		$bgcolor = $entity->bg_color;
		$topbar_color = $entity->topbar_color;
		$title = $entity->title;
		if ($entity->hidesitename === 1)
			array_push($opt_values, 'hidesitename');
		if ($entity->translucid_page === 1)
			array_push($opt_values, 'translucid_page');
		if ($entity->repeatx === 1)
			array_push($values, 'repeatx');
		if ($entity->repeaty === 1)
			array_push($values, 'repeaty');
		if ($entity->bg_alignment)
			$align = $entity->bg_alignment;
		else
			$align = 'left';
		if ($entity->height === null)
			$height = 120;
		else
			$height = (int)$entity->height;
			
	}
	else {
		$bgcolor = '#000000';
		$topbar_color = '#000000';
		$height = 120;
		$title = '';
		$align = 'left';
	}

	$form_body .= elgg_view("input/hidden", array(
			'internalname' => 'assign_to', 'value'=>$assign_to));
	$form_body .= elgg_view("input/text", array(
			'internalname' => 'title', 'value'=>$title));


        // include the color picker from jQuery
         $form_body .="<link rel='stylesheet' type='text/css' href='".$CONFIG->wwwroot."mod/microthemes/vendors/css/colorpicker.css' />
        <script type='text/javascript' src='".$CONFIG->wwwroot."mod/microthemes/vendors/js/jquery.js'></script>
        <script type='text/javascript' src='".$CONFIG->wwwroot."mod/microthemes/vendors/js/colorpicker.js'></script>";
	// backgroud color
	$form_body .= '<label>'.elgg_echo('microthemes:color').'</label><div id="BGcolorSelector" class="colorSelector"><div style="background-color: '.$bgcolor.'"></div></div>';
	$form_body .= elgg_view("input/hidden", array(
			'internalname' => 'bg_color', 'value'=>$bgcolor, 'js'=>'id="bgcolor"'));
        $form_body .='<script type="text/javascript">
        $(document).ready(function() {

                $("#BGcolorSelector").ColorPicker({
	color: "'.$bgcolor.'",
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$("#BGcolorSelector div").css("backgroundColor", "#" + hex);
                document.getElementById("bgcolor").value = "#" + hex;
	}
        });
        });</script>';

	// topbar color
	$form_body .= '<label>'.elgg_echo('microthemes:topbar_color').' </label><div id="TBcolorSelector" class="colorSelector"><div style="background-color: '.$topbar_color.'"></div></div>';
	$form_body .= elgg_view("input/hidden", array(	'internalname' => 'topbar_color', 'value'=>$topbar_color, 'js'=>'id="topbar_color" '));
        $form_body .='<script type="text/javascript">
        $(document).ready(function() {

                $("#TBcolorSelector").ColorPicker({
	color: "'.$topbar_color.'",
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$("#TBcolorSelector div").css("backgroundColor", "#" + hex);
                document.getElementById("topbar_color").value = "#" + hex;
	}
        });
        });</script>';

	// banner
        $background = $CONFIG->wwwroot.'mod/microthemes/graphics/icon.php?size=medium&mode=banner&object_guid='.$vars['entity']->guid;
        $form_body .= "<p><br><img src='".$background."' style='float:right; margin: 0 40px 15px 15px; padding: 5px; border: 1px solid #aaa;' ><br>";
	$form_body .= '<label>'.elgg_echo('microthemes:banner').' </label>';
	$form_body .= elgg_view("input/file", array(
			'internalname' => 'banner_file')).'</p><br>';
        

	$form_body .= '<label>'.elgg_echo('microthemes:headerheight').'</label>';
	$form_body .= elgg_view("input/text", array(
			'internalname' => 'height', 'value'=>$height));
	$form_body .= '<p>';
	$form_body .= '<p><label>'.elgg_echo('microthemes:bgrepetition').' </label><br />';
	$form_body .= elgg_view("input/checkboxes", array(
			'options' => array(elgg_echo('microthemes:repeatx')=>'repeatx',
			elgg_echo('microthemes:repeaty')=>'repeaty'),
			'internalname'=>'repeat',
			'value' => $values));
	$form_body .= '</p>';
	$form_body .= '<p><label>'.elgg_echo('microthemes:alignment').' </label><br />';
	$form_body .= elgg_view("input/radio", array('value'=>$align,
				'internalname' => 'alignment',
				'options'=>array(
				elgg_echo('microthemes:left')=>'left',
				elgg_echo('microthemes:center')=>'center',
				elgg_echo('microthemes:right')=>'right')));
	$form_body .= '</p>';
	$form_body .= '<p>';
	$form_body .= '<p><label>'.elgg_echo('microthemes:options').' </label><br />';
	$form_body .= elgg_view("input/checkboxes", array(
			'options' => array(
			elgg_echo('microthemes:hidesitename')=>'hidesitename',
			elgg_echo('microthemes:translucid_page')=>'translucid_page'),
			'internalname'=>'options',
			'value' => $opt_values));
	$form_body .= '</p>';

	// footer
	//$form_body .= '<label>'.elgg_echo('microthemes:footer').'</label>';
	//$form_body .= elgg_view("input/file", array(
	//		'internalname' => 'footer_file'));

	// submit
	$form_body .= elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('microthemes:publish')));
	// cancel
	$onclick_link = "'".$CONFIG->wwwroot."pg/microthemes/view/?assign_to=".$assign_to."','_top'";
        $form_body .= '<input type="button" value="'.elgg_echo('cancel').'" class="cancel_button" onclick="window.open('.$onclick_link.');" />';

	echo elgg_view('input/form', array(
			'body' => $form_body,
			'method' => 'post',
			'enctype' => 'multipart/form-data',
			'action'=>$vars['url'].'action/microthemes/edit'));

?>
