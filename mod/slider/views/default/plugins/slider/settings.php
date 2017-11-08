<?php
/**
 * Slider plugin settings
 * Params :
 * - contenu du slider par défaut
 * - styles du slider par défaut
 *
*/

$url = elgg_get_site_url();
$vendor_url = $url . 'mod/slider/vendors/anythingslider/';

// Define options
$yn_opts = array('yes' => elgg_echo('slider:option:yes'), 'no' => elgg_echo('slider:option:no'));


// Set defaults - Valeurs des paramètres (et de réinitialisation)
if (empty($vars['entity']->css_main)) { $vars['entity']->css_main = 'width:100%; height:300px;'; }
if (empty($vars['entity']->css_textslide)) { $vars['entity']->css_textslide = 'padding: 6px 12px;'; }
if (empty($vars['entity']->css)) { 	$vars['entity']->css = ''; }
if (!isset($vars['entity']->enable_cloning)) { $vars['entity']->enable_cloning = 'no'; }

if (empty($vars['entity']->jsparams)) {
	$vars['entity']->jsparams = "
theme : 'cs-portfolio',
autoPlay : true,
mode : 'f',
resizeContents : true,
expand : true,
buildNavigation : true,
buildStartStop : false,
toggleControls : true,
toggleArrows : true,
hashTags : false,
delay : 5000,
//easing : 'linear',
//navigationSize : 3, // Set this to the maximum number of visible navigation tabs; false to disable
/* 
// Noms des slides (hover sur les points pour naviguer)
navigationFormatter : function(index, panel){
	return ['Introduction', 'Services', 'Testimonial'][index - 1];
},
onSlideBegin: function(e,slider) {
	// keep the current navigation tab in view
	slider.navWindow( slider.targetPage );
},
onSlideComplete : function(slider){
	// alert('Welcome to Slide #' + slider.currentPage);
},
*/
";
}

if (empty($vars['entity']->content)) {
	$vars['entity']->content = '<ul>
<li>
<div class="textSlide">
	<h3>Fusce dictum nisi eu convallis luctus.</h3>
	<div>
		<p>
		Integer scelerisque augue id libero scelerisque imperdiet. Nam in tempor metus, ut bibendum nisi.</p>
		<p>Cras suscipit dui et erat placerat, a laoreet turpis egestas. Fusce hendrerit posuere elit vitae tempor. Ut convallis tellus eget libero rhoncus, ut iaculis ante mattis. Suspendisse potenti.</p>
		<p>Nulla luctus dignissim leo sed iaculis. Cras quis orci vulputate, egestas lacus dictum, luctus elit. Etiam maximus sit amet justo a suscipit. Fusce eleifend magna quam, non vehicula ex sodales a. In vitae tempor massa, eu maximus ex.</p>
		<p>Sed sed commodo dolor. Ut aliquet fermentum dictum. Nullam eu faucibus nisi. Vestibulum eu convallis dolor. Praesent ornare nulla non orci facilisis placerat.</p>
	</div>
</div>
</li>

<li><iframe frameborder="0" width="300" height="160" src="http://www.dailymotion.com/embed/video/xrz93q"></iframe></li>

<li>
<div class="textSlide">
	<h3>Nulla feugiat nunc eget interdum venenatis</h3>
	<div>
		<img src="' . $vendor_url . 'demos/images/slide-civil-2.jpg" alt="" style="float:right; width:300px; height:auto; margin:0 0 6px 12px;" />
		<p>Suspendisse in erat hendrerit, auctor nibh id, facilisis ipsum. Maecenas dictum mi lorem, quis fermentum dolor dictum sed. Pellentesque condimentum erat sit amet pellentesque condimentum. Fusce malesuada viverra magna, aliquet elementum tellus facilisis in. Suspendisse potenti. Cras varius semper mi. Vivamus eu erat non risus mollis maximus vel et arcu. Sed tincidunt neque sed turpis suscipit ornare.</p>
		<p>Suspendisse malesuada velit quis mauris ultricies, a congue nibh vehicula. Donec eu felis lacus. Praesent non venenatis libero. Fusce mattis nibh auctor, malesuada odio fermentum, blandit turpis. Pellentesque accumsan vehicula tellus nec ornare. Maecenas feugiat viverra risus sit amet tempor. Fusce congue, risus vitae euismod ullamcorper, ante lectus porta urna, eu ornare odio dui non turpis. Donec ac urna in mauris tempor eleifend.</p>
	</div>
</div>
</li>

<li>
<div class="textSlide">
	<h3>Donec eu eleifend tellus !</h3>
	<div>
		<img src="' . $vendor_url . 'demos/images/slide-env-2.jpg" alt="" style="float:right; width:300px; height:auto; margin:0 0 6px 12px;" />
		<p>Donec vitae cursus massa, vitae venenatis ligula. Quisque gravida diam eget volutpat tempor. Proin felis nisi, finibus sed feugiat id, auctor sit amet urna.</p>
		<p>Praesent nibh libero, molestie et sollicitudin ut, tincidunt ac dolor. Etiam eu ipsum non lacus interdum pharetra ac in massa.</p>
		<p>Praesent condimentum tortor pellentesque, lobortis nisi ut, luctus libero. Suspendisse sed ante vel orci accumsan dapibus. Sed mattis porta elementum.</p>
	</div>
</div>
</li>

</ul>';
}


// Enable/disable editing by members, or admins only ?
echo '<p><label>' . elgg_echo('slider:settings:slider_access') . ' ';
echo elgg_view('input/pulldown', array('name' => 'params[slider_access]', 'value' => $vars['entity']->slider_access, 'options_values' => $yn_opts));
echo '</label><br />' . elgg_echo('slider:settings:slider_access:details');
echo '</p>';

// Enable cloning
echo '<p><label>' . elgg_echo('slider:settings:enable_cloning') . ' ';
echo elgg_view('input/pulldown', array('name' => 'params[enable_cloning]', 'value' => $vars['entity']->enable_cloning, 'options_values' => $yn_opts));
echo '</label><br />' . elgg_echo('slider:settings:enable_cloning:details');
echo '</p>';
?>

<p>
	<em>
		<h3><?php echo elgg_echo('slider:settings:defaultslider'); ?></h3>
		<?php echo elgg_echo('slider:settings:defaultslider:help'); ?>
	</em>
</p>
<br />

<p><label><?php echo elgg_echo('slider:settings:content'); ?></label><br />
	<?php echo elgg_echo('slider:settings:content:help'); ?><br />
	<?php echo elgg_view('input/longtext', array( 'name' => 'params[content]', 'value' => $vars['entity']->content, 'class' => 'elgg-input-rawtext' )); ?>
</p><br />

<p><label><?php echo elgg_echo('slider:settings:jsparams'); ?></label><br />
	<?php echo elgg_echo('slider:settings:jsparams:help'); ?><br />
	<?php echo elgg_view('input/plaintext', array( 'name' => 'params[jsparams]', 'value' => $vars['entity']->jsparams )); ?>
</p><br />

<p><label><?php echo elgg_echo('slider:settings:css_main'); ?></label><br />
	<?php echo elgg_echo('slider:settings:css_main:help'); ?><br />
	<?php echo elgg_view('input/text', array( 'name' => 'params[css_main]', 'value' => $vars['entity']->css_main )); ?>
</p><br />

<p><label><?php echo elgg_echo('slider:settings:css_textslide'); ?></label><br />
	<?php echo elgg_echo('slider:settings:css_textslide:help'); ?><br />
	<?php echo elgg_view('input/text', array( 'name' => 'params[css_textslide]', 'value' => $vars['entity']->css_textslide )); ?>
</p><br />

<!--
<p><label><?php echo elgg_echo('slider:settings:css'); ?></label><br />
	<?php echo elgg_echo('slider:css:help'); ?>
	<?php echo elgg_view('input/plaintext', array( 'name' => 'params[css]', 'value' => $vars['entity']->css )); ?>
</p>
//-->

<br />


