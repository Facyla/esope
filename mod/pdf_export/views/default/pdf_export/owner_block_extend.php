<?php
if ( $vars['full'] 
  && !in_array(elgg_get_context(), array('listing', 'search')) 
  && ($vars['entity'] instanceof ElggObject)
  ) {
  global $CONFIG;
  $download_pdf_url = $CONFIG->url . 'pg/pdfexport/pdf/' . $vars['entity']->guid;
  
  //echo '<div class="clearfloat"></div>';
  //  rel="facebox" // pas top quand ça plante
  echo '<a href="' . $download_pdf_url . '" title="' . elgg_echo('pdfexport:download:title') . '" style="float:right; margin-left:8px;" class="tooltips-e" target="_new">
    <img src="' . $CONFIG->url . 'mod/pdf_export/graphics/pdf4_32.png" alt="' . elgg_echo('pdfexport:download:alt') . '" />
    </a>';
  //echo '<div class="clearfloat"></div>';
  
}

