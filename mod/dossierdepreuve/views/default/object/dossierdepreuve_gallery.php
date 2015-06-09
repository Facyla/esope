<?php
if ($vars['entity']) {
	$dossierdepreuve = $vars['entity'];

	$image = $CONFIG->url . "mod/dossierdepreuve/graphics/dossierdepreuve_100.png";
	echo '<div class="dossierdepreuve-gallery">
		<a href="'.$dossierdepreuve->getURL().'">
			<h4>'.$dossierdepreuve->title.'</h4>
			<img src="' . $image . '" class="dossierdepreuve-gallery-img" alt="Dossier de preuve : '.$dossierdepreuve->title.'" />
		</a><br />
		<p style="font-size:10px; font-weight:bold;">' . $dossierdepreuve->description . '<span style="float:right;">' . $dossierdepreuve->status . '</span></p>
		</div>';
}

