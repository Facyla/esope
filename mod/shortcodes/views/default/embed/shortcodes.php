<?php
/**
 *	Elgg Shortcodes integration
 *	Author : Mohammed Aqeel | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info [at]</span><br /><br /> webgalli [dot]</span><br /><br /> com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package Collections of Shortcodes for Elgg
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015
 */ 
?>
<h3><?php echo elgg_echo('shortcodes:help');?></h3>
<blockquote><?php echo elgg_echo('shortcodes:description');?></blockquote>

<ul class="elgg-list elgg-list-entity">
	
	<li class="elgg-item embed-item"><strong><?php echo elgg_echo('shortcodes:available:video');?>&nbsp;:</strong><br /><span class="embed-insert">[video site="youtube" id="VIDEO_ID" w="600px" h="340px"]</span><br /><br /></li>
	
	<?php
	if (elgg_is_active_plugin('slider')) {
		echo '<li class="elgg-item embed-item"><strong>' . elgg_echo('shortcodes:available:slider:rawhtml') . '&nbsp;:</strong><br /><span class="embed-insert">[diaporama width="100%" height="300px" images="IMAGE1_URL, IMAGE2_URL"]</span><br /><br /></li>';
		
		echo '<li class="elgg-item embed-item"><strong>' . elgg_echo('shortcodes:available:slider:visual') . '&nbsp;:</strong><br /><span class="embed-insert">[diaporama width="100%" height="300px"]<ul><li>(LIST OF IMAGES)</li></ul>[/diaporama]</span><br /><br />';
	}
	?>
	
	<li class="elgg-item embed-item"><strong><?php echo elgg_echo('shortcodes:available:embedpdf');?>&nbsp;:</strong><br /><span class="embed-insert">[embedpdf width="600px" height="500px" url='PDF_URL']</span><br /><br /></li>
	
	<li class="elgg-item embed-item"><strong><?php echo elgg_echo('shortcodes:available:snap');?>&nbsp;:</strong><br /><span class="embed-insert">[snap url="PAGE_URL" alt="My description" w="400" h="300"]</span><br /><br /></li>
	
	<li class="elgg-item embed-item"><strong><?php echo elgg_echo('shortcodes:available:chart');?>&nbsp;:</strong><br /><span class="embed-insert">[chart data="41.52,37.79,20.67,0.03" bg="F7F9FA" labels="LABEL+1|LABEL+2|LABEL+3|LABEL+4" colors="058DC7,50B432,ED561B,EDEF00" size="488x200" title="CHART_TITLE" type="pie"]</span><br /><br /></li>
	
	<li class="elgg-item embed-item"><strong><?php echo elgg_echo('shortcodes:available:googlemap');?>&nbsp;:</strong><br /><span class="embed-insert">[googlemap width="600" height="300" src="MAP_URL"]</span><br /><br /></li>
	</a></li>
	
	<?php
	// Let other plugins extend shortcodes support
	echo elgg_view('shortcodes/embed/extend');
	?>
	
</ul>

<?php
/* @TODO : plus intéressant car permet d'insérer directement le shortcode, mais ne marche qu'après avoir lancé l'embed normal
<li class="elgg-item embed-item"><strong>Embed PDF : <a href="javascript:void(0);" class="elgg-item embed-item">
	<span class="embed-insert"><strong>[embedpdf width="600px" height="500px" url='http://infolab.stanford.edu/pub/papers/google.pdf']</span><br /><br /></span><br /><br />
</a></li>

<li class="elgg-item embed-item"><strong>Google Charts : <a href="javascript:void(0);" class="elgg-item embed-item">
	<span class="embed-insert"><strong>[chart data="41.52,37.79,20.67,0.03" bg="F7F9FA" labels="Reffering+sites|Search+Engines|Direct+traffic|Other" colors="058DC7,50B432,ED561B,EDEF00" size="488x200" title="Traffic Sources" type="pie"]</span><br /><br /></span><br /><br />
</a></li>

<li class="elgg-item embed-item"><strong>Google Maps : <a href="javascript:void(0);" class="elgg-item embed-item">
	<span class="embed-insert"><strong>[googlemap width="600" height="300" src="http://maps.google.com/maps?q=Heraklion,+Greece&hl=en&ll=35.327451,25.140495&spn=0.233326,0.445976& sll=37.0625,-95.677068&sspn=57.161276,114.169922& oq=Heraklion&hnear=Heraklion,+Greece&t=h&z=12"]</span><br /><br /></span><br /><br />
</a></li>

<li class="elgg-item embed-item"><strong>Webpage Snap : <a href="javascript:void(0);" class="elgg-item embed-item">
	<span class="embed-insert"><strong>[snap url="http://www.webgalli.com" alt="My description" w="400" h="300"]</span><br /><br /></span><br /><br />
</a></li>

<li class="elgg-item embed-item"><strong>Videos : <a href="javascript:void(0);" class="elgg-item embed-item">
	<span class="embed-insert"><strong>[video site="youtube" id="dQw4w9WgXcQ" w="600" h="340"]</span><br /><br /></span><br /><br />
</a></li>

<li class="elgg-item embed-item"><strong>Diaporama (slider) : <a href="javascript:void(0);" class="elgg-item embed-item">
	<span class="embed-insert"><strong>[diaporama width="600" height="340" images="IMAGE1_URL,IMAGE2_URL"]</span><br /><br /></span><br /><br />
</a></li>
*/


