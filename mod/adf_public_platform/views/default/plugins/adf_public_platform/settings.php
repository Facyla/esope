<?php
/**
 * ADF_platform plugin settings
 * Params :
 * - contenu de la bannière (HTML insérable)
 * - hauteur de la bannière
 * - image de fond du header
 * - hauteur du header
 * - contenu du footer (HTML insérable)
 * - éléments de la page d'accueil : afficher les stats
 *
 */

//echo elgg_view('input/dropdown', array( 'name' => 'params[hidden_groups]', 'options_values' => array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') ), 'value' => $vars['entity']->hidden_groups, ));


// SET DEFAULT VALUES

/* Unused since new theme w/ Urbilog
// Banner content
if (!isset($vars['entity']->header) || ($vars['entity']->header == 'RAZ')) { $vars['entity']->header = elgg_echo('adf_platform:header:default'); }
// header background URL
if (strlen($vars['entity']->headbackground) == 0) { $vars['entity']->headbackground = $vars['url'] . 'mod/adf_public_platform/img/headimg.jpg'; }
// header background height
if (strlen($vars['entity']->headheight) == 0) { $vars['entity']->headheight = 330; }
// Footer content
if (strlen($vars['entity']->footer) == 0) { $vars['entity']->footer = elgg_echo('adf_platform:footer:default'); }
*/

// Additionnal CSS content - loaded at the end
if (strlen($vars['entity']->css) == 0) { $vars['entity']->css = '/* ' . elgg_echo('adf_platform:css:default') . ' */'; }
// No stats on homepage
if (strlen($vars['entity']->displaystats) == 0) { $vars['entity']->displaystats = 'no'; }

// Set default colors - theme ADF
// Footer background color
if (empty($vars['entity']->footercolor)) { $vars['entity']->footercolor = '#555555'; }
// Titles
if (empty($vars['entity']->titlecolor)) { $vars['entity']->titlecolor = '#0A2C83'; }
// Links & other colors
if (empty($vars['entity']->linkcolor)) { $vars['entity']->linkcolor = '#002e6e'; }
if (empty($vars['entity']->color1)) { $vars['entity']->color1 = '#0050bf'; }
if (empty($vars['entity']->color2)) { $vars['entity']->color2 = '#0066cc'; }
if (empty($vars['entity']->color3)) { $vars['entity']->color3 = '#c61b15'; }
?>


<?php /* Unused since new theme w/ Urbilog
<p>
  <label><?php echo elgg_echo('adf_platform:header:content'); ?>
  <?php echo elgg_view('input/longtext', array( 'name' => 'params[header]', 'value' => $vars['entity']->header )); ?>
  </label>
</p>
<p>
  <label><?php echo elgg_echo('adf_platform:header:background'); ?>
  <?php echo elgg_view('input/text', array( 'name' => 'params[headbackground]', 'value' => $vars['entity']->headbackground )); ?>
  </label>
</p>
<p>
  <label><?php echo elgg_echo('adf_platform:header:height'); ?>
  <?php echo elgg_view('input/text', array( 'name' => 'params[headheight]', 'value' => $vars['entity']->headheight )); ?>
  </label>
</p>
<p>
  <label><?php echo elgg_echo('adf_platform:footer:color'); ?>
  <?php echo elgg_view('input/text', array( 'name' => 'params[footercolor]', 'value' => $vars['entity']->footercolor )); ?>
  </label>
</p>
<p>
  <label><?php echo elgg_echo('adf_platform:footer:content'); ?>
  <?php echo elgg_view('input/longtext', array( 'name' => 'params[footer]', 'value' => $vars['entity']->footer )); ?>
  </label>
</p>
*/ ?>

<p>
  <label><?php echo elgg_echo('adf_platform:home:displaystats'); ?>
  <?php echo elgg_view('input/dropdown', array( 'name' => 'params[displaystats]', 'options_values' => array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') ), 'value' => $vars['entity']->displaystats )); ?>
  </label>
</p>

<p>
  <label><?php echo elgg_echo('adf_platform:headertitle'); ?>
  <?php echo elgg_view('input/text', array( 'name' => 'params[headertitle]', 'value' => $vars['entity']->headertitle )); ?>
  </label>
  <p><?php echo elgg_echo('adf_platform:headertitle:help'); ?></p>
</p>

<p>
  <label><?php echo elgg_echo('adf_platform:css'); ?>
  <?php echo elgg_view('input/plaintext', array( 'name' => 'params[css]', 'value' => $vars['entity']->css )); ?>
  </label>
</p>

<p>
  <label><?php echo elgg_echo('adf_platform:homeintro'); ?>
  <?php echo elgg_view('input/longtext', array( 'name' => 'params[homeintro]', 'value' => $vars['entity']->homeintro )); ?>
  </label>
</p>

<p>
  <label><?php echo elgg_echo('adf_platform:dashboardheader'); ?>
  <?php echo elgg_view('input/longtext', array( 'name' => 'params[dashboardheader]', 'value' => $vars['entity']->dashboardheader )); ?>
  </label>
</p>

<hr />

<h3><?php echo elgg_echo('adf_platform:settings:colors'); ?></h3>

<p>
  <label><?php echo elgg_echo('adf_platform:title:color'); ?>
  <?php echo elgg_view('input/text', array( 'name' => 'params[titlecolor]', 'value' => $vars['entity']->titlecolor )); ?>
  </label>
</p>
<p>
  <label><?php echo elgg_echo('adf_platform:link:color'); ?>
  <?php echo elgg_view('input/text', array( 'name' => 'params[linkcolor]', 'value' => $vars['entity']->linkcolor )); ?>
  </label>
</p>
<p>
  <label><?php echo elgg_echo('adf_platform:color1:color'); ?>
  <?php echo elgg_view('input/text', array( 'name' => 'params[color1]', 'value' => $vars['entity']->color1 )); ?>
  </label>
</p>
<p>
  <label><?php echo elgg_echo('adf_platform:color2:color'); ?>
  <?php echo elgg_view('input/text', array( 'name' => 'params[color2]', 'value' => $vars['entity']->color2 )); ?>
  </label>
</p>
<p>
  <label><?php echo elgg_echo('adf_platform:color3:color'); ?>
  <?php echo elgg_view('input/text', array( 'name' => 'params[color3]', 'value' => $vars['entity']->color3 )); ?>
  </label>
</p>


<h3><?php echo elgg_echo('adf_platform:settings:publicpages'); ?></h3>
<p>
	<label>
    <?php // un nom de pages par ligne demandé (plus clair), mais on acceptera aussi séparé par virgules et point-virgule en pratique
    echo elgg_echo('adf_platform:publicpages');
    echo elgg_view('input/plaintext', array( 'name' => 'params[publicpages]', 'value' => $vars['entity']->publicpages ));
    ?>
	</label>
	<?php echo elgg_echo('adf_platform:publicpages:help'); ?>
</p>

<!--
<p>
  <label><?php echo elgg_echo('adf_platform:index:url'); ?>
  <?php echo elgg_view('input/text', array( 'name' => 'params[indexurl]', 'value' => $vars['entity']->indexurl )); ?>
  </label>
</p>


<p>
  <label><?php echo elgg_echo('adf_platform:login:redirect'); ?>
  <?php echo elgg_view('input/text', array( 'name' => 'params[loginredirect]', 'value' => $vars['entity']->loginredirect )); ?>
  </label>
</p>
//-->

